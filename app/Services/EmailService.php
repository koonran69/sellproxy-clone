<?php

namespace App\Services;

use App\Models\CDkey;
use App\Models\Order;
use App\Models\ProxyOrder;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendCdkeys($orderId)
    {
        $order = Order::find($orderId);
        $order_details = $order->data->toArray();
        $items = [];
        $user_id = $order->user_id;
        $user = User::find($user_id);
        foreach ($order_details as $detail) {
            $proxy_id = $detail['product_id'];
            $quantity = $detail['quantity'];
            $variation_id = $detail['variation_id'];

            $item['quantity']  = $quantity;
            $item['proxy_name'] = $detail['name_vi'];
            $item['variant_name'] = $detail['variation_name'];

            $item['cdkeys'] = $this->getListCDkey($proxy_id, $variation_id, $quantity, $user_id, $orderId);

            $items[] = $item;
        }

        Mail::send('emails.send_cdkeys', [ 'items' => $items, 'user' => $user ], function ($message) use ($user){
            $message->to($user->email, $user->name)->subject('Thông tin CDKey proxy của bạn');
        });
    }

    public function getListCDkey($proxy_id, $variation_id, $quantity, $user_id, $orderId) {
        $cdKeys = CDkey::where('proxy_id', $proxy_id)
            ->where('variation_id', $variation_id)
            ->where('is_use', '!=', 1)->limit($quantity)->get();
        $list = [];
        $listIdCdKey = [];
        foreach ($cdKeys as $cdKey) {
            $list[] = $cdKey->cdkey;
            CDkey::where('id', $cdKey->id)->update(['is_use' => 1, 'is_notify' => 1, 'user_id' => $user_id, 'order_id' => $orderId ]);
        }
        return $list;
    }

    public function sendProxy($orderId)
    {
        $order = ProxyOrder::find($orderId);
        $user = $order->user;
        $proxies = $order->proxyInstances;
        $orderUrl = route('account.proxyLineList', ['order_id' => $order->code]);
        Mail::send('emails.proxy_purchased_email', [ 'proxies' => $proxies, 'user' => $user, 'orderUrl' => $orderUrl ], function ($message) use ($user){
            $message->to($user->email, $user->name)
                ->subject('Thông tin đơn hàng của bạn');
        });
    }
}
