<?php

namespace App\Http\Controllers;

use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Deposit\Type;
use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Enums\WithdrawalStatus;
use App\Core\Repositories\Deposit\DepositRepositoryInterface;
use App\Models\MemberLevel;
use App\Models\Order;
use App\Models\ProxyCategory;
use App\Models\ProxyInstance;
use App\Models\ProxyOrder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Withdrawal;
use App\Services\OrderService;
use App\Services\ProxyService;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    private $depositRepository;
    private $orderService;

    public function __construct(
        DepositRepositoryInterface $depositRepository,
        OrderService $orderService
    ) {
        $this->depositRepository = $depositRepository;
        $this->orderService = $orderService;
    }

    public function profile(Request $request) {
        $data['userProfile'] =  Auth::user();
        return view("public.account.profile")->with($data);
    }

    public function updateProfile(Request $request) {
        $user_id = Auth::user()->id;

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user_id,
        ],[
            'name.required' => 'Họ tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
        ]);

        $data = $request->only('name', 'email', 'phone');
        $user = User::where('id', $user_id)->update($data);

        return redirect()->back();
    }

    public function resetPassForm(Request $request) {
        $data['userProfile'] =  Auth::user();
        return view("public.account.resetPass")->with($data);
    }

    public function resetPass(Request $request) {
        $user_id = Auth::user()->id;

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ],[
            'current_password.required' => 'Mật khẩu là bắt buộc',
            'new_password.required' => 'Mật khẩu mới là bắt buộc',
            'new_password.min' => 'Mật khẩu mới ít nhất 6 ký tự',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Mật khẩu đã được cập nhật thành công!');
    }

    public function orders(Request $request) {
        $data = [];
        $user_id = Auth::user()->id;
        $data['orders'] = Order::select("*")->where('user_id', $user_id)->orderBy('id','desc')->get();
        return view("public.account.orders")->with($data);
    }

    public function walletHistory(Request $request) {
        $user = Auth::user();
        $deposits = $user->deposits()->orderBy('id', 'desc')->get();
        $data['deposits'] = $deposits;
        $data['user'] = $user;
        return view("public.account.deposits")->with($data);
    }

    public function wallet(Request $request) {
        $data = [];
        $user_id = Auth::user()->id;
        $data['user'] = Auth::user();
        return view("public.account.wallet")->with($data);
    }

    public function walletPost(Request $request) {

        $request->validate([
            'amount' => 'required|numeric|min:50000|max:100000000'
        ]);

        $data = [];
        $user_id = Auth::user()->id;
        $amount = $request->amount;

        DB::beginTransaction();

        try {
            $data = [
                'user_id' => $user_id,
                'amount' => $amount,
                'code' => 'RC' . uniqid_real(),
                'type' => Type::Banking,
                'status' => Status::Pending
            ];
            $deposit = $this->depositRepository->create($data)->load('user');
            $transaction = Transaction::create([
                'user_id' => $user_id,
                'code' => 'PRX' . uniqid_real(6),
                'amount' => $amount,
                'status' => TransactionStatus::PendingPayment,
                'reference_id' => $deposit->id,
                'reference_type' => get_class($deposit),
                'note' => 'Nạp tiền vào ví'
            ]);

            $this->orderService->processBankingMethod($transaction);

            DB::commit();

            return [
                'success' => true,
                'redirect_url' => route('transaction.show', [ 'code' => $transaction->code ])
            ];
        } catch (\Exception $th) {
            \Log::info('error walletPost', [ $th->getMessage() ]);
            DB::rollBack();
            return [ 'success' => false];
        }

    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $user = auth()->user();

        $orderTotal = Cart::content()->sum(function ($item) {
            return $item->price * $item->qty;
        });

        $voucher = Voucher::where('code', $request->code)
            ->where('status', VoucherStatus::Used)
            ->where(function($q) use ($user) {
                $q->whereNull('member_level_id')->orWhere('member_level_id', $user->member_level_id)
                ->orWhere('user_id', $user->id);
            })
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where(function($q) {
                $q->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
            })
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không hợp lệ hoặc không còn áp dụng.'
            ], 422);
        }

        $discountAmount = $voucher->type == VoucherType::Fixed ? (int)$voucher->value : round($orderTotal * (int)$voucher->value / 100);
        $discountAmount = min($discountAmount, $orderTotal);
        $finalAmount = $orderTotal - $discountAmount;

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng voucher thành công!',
            'discount' => number_format($discountAmount),
            'total_after_discount' => number_format($finalAmount),
            'voucher' => $voucher->only(['code', 'value', 'type'])
        ]);
    }

    public function levelShow(Request $request) {
        $data = [];
        $user = auth()->user();
        $data['listLevels'] = MemberLevel::orderBy('plain_value','asc')->get();
        $data['coupons'] = $user->vouchers;

        $total = Order::where('user_id', $user->id)
            ->where('status', OrderStatus::Complete)
            ->sum('total');

        $data["total_order"] = $total;

        $memberLevel = MemberLevel::where('plain_value', '>', $total)
            ->orderBy('plain_value','asc')
            ->first();

        $data['memberLevelNext'] = $memberLevel;
        $data['user'] = $user;
        $data['percent'] = $memberLevel->plain_value > 0 ? ($total / $memberLevel->plain_value) * 100 : 0;

        return view("public.account.levelShow")->with($data);
    }

    public function withdrawal(Request $request) {
        $data = [];
        $user_id = Auth::user()->id;
        $data['user'] = Auth::user();
        return view("public.account.withdrawal")->with($data);
    }

    public function postWithdrawal(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'method' => 'required|in:bank,momo',
            'account_name' => 'required|string|min:3',
            'account_number' => 'required|string|min:5',
            'bank_name' => 'required_if:method,bank|string|nullable',
        ]);

        $user = Auth::user();

        if ($user->available_balance < $request->amount) {
            return back()->withErrors(['error' => 'Số dư khả dụng không đủ để rút tiền']);
        }

        $lastWithdraw = Withdrawal::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if ($lastWithdraw && $lastWithdraw->created_at->diffInMinutes(Carbon::now()) < 5) {
            return back()->withErrors(['error' => 'Bạn chỉ được rút tiền 1 lần mỗi 5 phút. Vui lòng thử lại sau.']);
        }

        $ip_address = $request->getClientIp();

        DB::beginTransaction();
        try {
            $user->available_balance -= $request->amount;
            $user->save();

            $account_info = [
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name
            ];

            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'method' => $request->method,
                'account_info' => $account_info,
                'status' => WithdrawalStatus::Pending,
                'ip_address' => $ip_address
            ]);

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'code' => 'PRX' . uniqid_real(6),
                'amount' => $withdrawal->amount,
                'status' => TransactionStatus::Paid,
                'reference_id' => $withdrawal->id,
                'reference_type' => get_class($withdrawal),
                'note' => 'Rút tiền từ số dư khả dụng'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Yêu cầu rút tiền đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Đã có lỗi xảy ra. Vui lòng thử lại.']);
        }
    }

    public function proxyLineOrder(Request $request)
    {
        $user_id = Auth::user()->id;
        $orders = ProxyOrder::with(['proxyInstances', 'country', 'proxyType', 'ipVersion'])->withCount('proxyInstances')->where('user_id', $user_id)->orderBy('id','desc')->get();
        return view("public.account.proxyLineOrder")->with('orders', $orders);
    }

    public function proxyLineList(Request $request)
    {
        $user_id = Auth::user()->id;
        $order = ProxyOrder::where('user_id', $user_id)->where('code', $request->order_id)->first();
        if(!$order) {
            abort(404);
        }

        $orderBy = request('order_by', 'date-buy-desc');

        $map = [
            'date-buy-asc'       => ['date_start', 'asc'],
            'date-buy-desc'      => ['date_start', 'desc'],
            'date-expired-asc'   => ['date_end', 'asc'],
            'date-expired-desc'  => ['date_end', 'desc'],
        ];

        [$column, $direction] = $map[$orderBy] ?? $map['date-buy-desc'];

        $limit = (int) request('limit', 50);
        $allowed = [50, 100, 200];
        if (!in_array($limit, $allowed, true)) {
            $limit = 50;
        }
        $proxies = $order->proxyInstances()
            ->orderBy($column, $direction)
            ->paginate($limit)
            ->appends(request()->except('page'));

        return view("public.account.proxyLineList")
            ->with('order', $order)
            ->with('proxies', $proxies);
    }

    public function updateComment(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'nullable|string|max:5000',
        ]);

        $proxy = ProxyInstance::find($request->id);
        $proxy->comment = $validated['comment'] ?? '';
        $proxy->save();

        return response()->json([
            'status' => 'ok',
            'message' => 'Đã lưu comment.',
            'comment' => $proxy->comment,
        ]);
    }
}
