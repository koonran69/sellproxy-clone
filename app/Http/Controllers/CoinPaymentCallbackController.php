<?php

namespace App\Http\Controllers;


use App\Core\Enums\Order\OrderStatus;
use App\Core\Http\Requests\Request;
use App\Jobs\SendCdKeyJob;
use App\Models\Order;
use App\Services\CoinGateService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Log;

class CoinPaymentCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $data = $request->all();
        \Log::info('data handleCallback', $data);
        if(isset($data['status']) && $data['status'] == 100) {
            $order = Order::where('code', $data['invoice'])->first();
            if ($order->status == OrderStatus::PendingPayment) {
                $order->status = OrderStatus::Complete;
                $order->save();
                app(OrderService::class)->updateMemberLevel($order->user_id);
                dispatch(new SendCdKeyJob($order->id));
            } else {
                Log::warning("Đơn hàng #{$order->id} không ở trạng thái pending, không thể cập nhật.");
            }
        }
        return response()->json(['status' => 'success']);
    }
}
