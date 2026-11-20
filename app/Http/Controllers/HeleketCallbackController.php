<?php

namespace App\Http\Controllers;

use App\Core\Enums\Order\OrderStatus;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\HeleketService;
use App\Jobs\SendCdKeyJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HeleketCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $data = $request->all();

        Log::info('Heleket Callback Received', [
            'data' => $data,
        ]);

        $heleketService = new HeleketService();
        if (!$heleketService->verifyWebhookSignature($data)) {
            Log::warning('Heleket Callback Signature Invalid');
            return response()->json(['error' => 'Invalid signature'], 400);
        }


        $paymentStatus = $data['status'] ?? '';

        if (in_array($paymentStatus, ['paid', 'paid_over'])) {
            $orderCode = $data['order_id'] ?? null;
            if ($orderCode) {
                $order = Order::where('code', $orderCode)->first();
                if ($order && $order->status == OrderStatus::PendingPayment) {
                    $order->status = OrderStatus::Complete;
                    $order->save();

                    app(OrderService::class)->updateMemberLevel($order->user_id);
                    dispatch(new SendCdKeyJob($order->id));

                    Log::info("Order #{$order->code} updated to Complete via Heleket");
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
