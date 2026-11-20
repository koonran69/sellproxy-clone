<?php

namespace App\Http\Controllers;

use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Jobs\SendCdKeyJob;
use App\Models\Setting;
use App\Models\VietqrBank;
use App\Services\AuthService;
use App\Services\CoinGateService;
use App\Services\HeleketService;
use App\Services\OrderService;
use App\Services\VietQRService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $orderService;
    private $vietQRService;

    public function __construct(OrderService $orderService, VietQRService $vietQRService)
    {
        $this->orderService = $orderService;
        $this->vietQRService = $vietQRService;
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để đặt hàng'], 401);
        }

        $payment_method = $request->payment_method;

        if (!in_array($payment_method, ["banking", "wallet", "coin", "heleket"])) {
            return response()->json([
                'success' => false,
            ], 400);
        }

        $email = $request->email;

        $user = Auth::user();

        try {
            $voucher_code = $request->input('voucher_code', '');

            $order = $this->orderService->placeOrder(Auth::id(), $email, $payment_method, $voucher_code);

            $transaction  = $order->transactions()->create([
                'user_id' => auth()->id(),
                'code' => $order->code,
                'amount' => $order->total,
                'status' => TransactionStatus::PendingPayment,
                'note' => 'Giao dịch đơn hàng ' . $order->code
            ]);

            if ($order->payment_method == PaymentMethod::Banking) {
                $this->orderService->processBankingMethod($transaction);
                $redirect_url = route('transaction.show', ['code' => $transaction->code]);
                Cart::destroy();
            } else if ($order->payment_method == PaymentMethod::Wallet) {
                $payment = $this->orderService->processWalletMethod($user, $order);
                if ($payment) {
                    $order->status = OrderStatus::Complete;
                    $order->save();
                    $this->orderService->updateMemberLevel($order->user_id);
                    dispatch(new SendCdKeyJob($order->id));
                }
                Cart::destroy();
                $redirect_url = route('account.orders');
            } else if ($order->payment_method == PaymentMethod::Heleket) {
                $heleketService = new HeleketService();
                $vnd = $order->total;
                $amountUSD = convert_vnd_to_usd_non_format($vnd);

                $urls = [
                    'url_callback' => url('/heleket/callback'),
                    'url_success'  => route('account.orders'),
                    'url_return'   => route('cart.getCart'),
                ];

                $response = $heleketService->createInvoice($amountUSD, $order->code, 'USD', null, null, $urls);

                if ($response && isset($response['state']) && $response['state'] == 0) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Đặt hàng thành công!',
                        'order' => $order,
                        'payment_method' => 'heleket',
                        'redirect_url' => $response['result']['url']
                    ]);
                } else {
                    $errorMsg = isset($response['message']) ? $response['message'] : 'Không thể tạo hóa đơn thanh toán';
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                        'order' => $order,
                    ]);
                }
            } else if ($order->payment_method == PaymentMethod::Coin) {
                /*
                $coinService = new CoinPaymentsService();
                $vnd = $order->total;
                $crypto = strtoupper($request->crypto);
                $amountUSD = convert_vnd_to_usd_non_format($vnd);
                $response = $coinService->createTransaction($amountUSD, $crypto, $user->email, $order->code);
                if ($response && $response['error'] == "ok") {
                    return response()->json([
                        'success' => true,
                        'message' => 'Đặt hàng thành công!',
                        'order' => $order,
                        'payment_method' => 'coin',
                        'redirect_url' => $response['result']['checkout_url']
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $response["error"],
                        'order' => $order,
                    ]);
                }
                */

                return response()->json([
                    'success' => false,
                    'message' => 'Phương thức thanh toán CoinPayments hiện đã ngừng hỗ trợ!',
                    'order' => $order,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'order' => $order,
                'redirect_url' => $redirect_url
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function checkout(Request $request)
    {
        if (!session()->has('order_code')) {
            abort(404);
        }
        $orderCode = session()->get('order_code');
        $order = $this->orderService->getOrderByCode($orderCode);

        $setting = Setting::getAll();

        $bank_account_id = $setting->get('bank_account_id');
        $bank = VietqrBank::where("bin", $bank_account_id)->first();
        $paymentInfo = [
            'bank_account_no' => $setting->get('bank_account_no'),
            'bank_account_name' => $setting->get('bank_account_name'),
            'bank_account_id' => $bank_account_id,
            'bank_name' => $bank->name,
            'amount' => $order->total,
            'desc' => $orderCode
        ];
        $expiredTime = 15;
        if (session()->has('qr_expire_time') && session('qr_expire_time') > now()->timestamp) {
            $data['vietQR'] = session('vietQR');
        } else {
            $responseVietQR = $this->vietQRService->generateQrcode(
                $paymentInfo['bank_account_no'],
                $paymentInfo['bank_account_name'],
                $paymentInfo['bank_account_id'],
                $paymentInfo['amount'],
                $paymentInfo['desc']
            );
            session()->put('vietQR', $responseVietQR);
            session()->put('qr_expire_time', now()->addMinutes($expiredTime)->timestamp);
            $data['vietQR'] = $responseVietQR;
        }

        $data['remaining_seconds'] = max(0, session('qr_expire_time') - now()->timestamp);
        $data['order'] = $order;
        $data['payment_info'] = $paymentInfo;
        return view("public.checkout.vietQR")->with($data);
    }
}
