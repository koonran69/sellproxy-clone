<?php

namespace App\Services;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\Order\OrderRepositoryInterface;
use App\Models\MemberLevel;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\VietqrBank;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{

    private $orderRepository;
    private $cartService;
    private $vietQRService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartService $cartService,
        VietQRService $vietQRService
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
        $this->vietQRService = $vietQRService;
    }

    public function placeOrder($customerId, $email_notify, $payment_method, $voucher_code)
    {
        $user = Auth::user();

        $cart = $this->cartService->getCartContent();
        if (!$cart || $cart->isEmpty()) {
            throw new \Exception("Giỏ hàng trống!");
        }

        if ($payment_method == "banking") {
            $payment_method = PaymentMethod::Banking;
        } elseif ($payment_method == "wallet") {
            $payment_method = PaymentMethod::Wallet;
        } elseif ($payment_method == "coin") {
            $payment_method = PaymentMethod::Coin;
        } elseif ($payment_method == "heleket") {
            $payment_method = PaymentMethod::Heleket;
        }

        $orderData = [
            'user_id' => $customerId,
            'email_notify' => $email_notify,
            'sub_total' => $this->cartService->getTotalPrice(),
            'total' => $this->cartService->getTotalPrice(),
            'discount' => 0,
            'payment_method' => $payment_method,
            'status' => OrderStatus::PendingPayment,
            'products' => $cart,
        ];

        $orderTotal = $orderData['total'];
        $voucher = null;
        $discountAmount = 0;

        if (!empty($voucher_code)) {
            $voucher = Voucher::where('code', $voucher_code)
                ->where('status', VoucherStatus::Used)
                ->where(function ($q) use ($user) {
                    $q->whereNull('member_level_id')->orWhere('member_level_id', $user->member_level_id)
                        ->orWhere('user_id', $user->id);
                })
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->where(function ($q) {
                    $q->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
                })
                ->lockForUpdate()
                ->first();

            if ($voucher) {
                $discountAmount = $voucher->type == VoucherType::Fixed ? (int)$voucher->value : round($orderTotal * (int)$voucher->value / 100);

                $discountAmount = min($discountAmount, $orderTotal);
            }
        }

        $orderData['voucher_id'] = $voucher?->id;
        $orderData['discount_amount'] =  $discountAmount;
        $orderData['total'] =  $orderTotal - $discountAmount;
        $orderData['sub_total'] =  $orderData['total'];

        $order = $this->orderRepository->createOrder($orderData);

        if ($order && $voucher) {
            try {
                $rs = Voucher::where('id', $voucher->id)->increment('used_count');
            } catch (\Exception $exception) {
                \Log::info('update voucher error', [$exception->getMessage()]);
            }
        }
        //        if($order) {
        //            $this->cartService->clearCart();
        //        }
        return $order;
    }

    public function getOrderByCode($code)
    {
        return $this->orderRepository->findBy(['code' => $code]);
    }

    public function processBankingMethod($transaction)
    {
        $expiredTime = 15;
        $setting = Setting::getAll();
        $bank_account_id = $setting->get('bank_account_id');
        $paymentInfo = [
            'bank_account_no' => $setting->get('bank_account_no'),
            'bank_account_name' => $setting->get('bank_account_name'),
            'bank_account_id' => $bank_account_id,
            'amount' => $transaction->amount,
            'desc' => $transaction->code
        ];

        $responseVietQR = $this->vietQRService->generateQrcode(
            $paymentInfo['bank_account_no'],
            $paymentInfo['bank_account_name'],
            $paymentInfo['bank_account_id'],
            $paymentInfo['amount'],
            $paymentInfo['desc']
        );
        session()->put('vietQR_' . $transaction->code, $responseVietQR);
        session()->put('qr_expire_time_' . $transaction->code, now()->addMinutes($expiredTime)->timestamp);
        return $responseVietQR;
    }

    public function processWalletMethod($user, $order)
    {
        $total = $order->total;
        if (!$user->checkBalanceAvailable($total)) {
            return false;
        }
        try {
            DB::beginTransaction();
            $user->update([
                'available_balance' => DB::raw("available_balance - $total")
            ]);
            $rs = $user->recharge($total * -1, ReferenceType::Order, $order->id, 'Thanh toán ví đơn hàng ' . $order->code);
            DB::commit();
            return $rs;
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function updateMemberLevel($userId)
    {
        $total = Order::where('user_id', $userId)
            ->where('status', OrderStatus::Complete)
            ->sum('total');

        $memberLevel = MemberLevel::where('plain_value', '<=', $total)
            ->orderByDesc('plain_value')
            ->first();

        $user = User::find($userId);

        if ($memberLevel) {
            $user->member_level_id = $memberLevel->id;
            $user->save();
        }
    }
}
