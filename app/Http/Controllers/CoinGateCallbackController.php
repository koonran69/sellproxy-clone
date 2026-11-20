<?php

namespace App\Http\Controllers;


use App\Core\Enums\Order\OrderStatus;
use App\Core\Http\Requests\Request;
use App\Models\Order;
use App\Services\CoinGateService;

class CoinGateCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $data = $request->all();
        \Log::info('data coingate', $data);
        if ($data['status'] === 'paid') {
            $order = Order::find($data['order_id']);
            $order->status = OrderStatus::Complete;
            $order->save();
        }

        return response()->json(['status' => 'success']);
    }

    public function handleSuccess()
    {
        return redirect()->route('home');
    }

    public function handleCancel()
    {
        return redirect()->route('home');
    }
}
