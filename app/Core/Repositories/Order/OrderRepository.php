<?php

namespace App\Core\Repositories\Order;
use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Repositories\EloquentRepository;
use App\Core\Repositories\Proxy\ProxyRepositoryInterface;
use App\Models\Order;
use App\Models\Proxy;
use App\Models\ProxyVariation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderRepository extends EloquentRepository implements OrderRepositoryInterface
{

    public function getModel(){
        return Order::class;
    }

    public function createOrder($data) {
        DB::beginTransaction();
        try {
            $orderStatus = $data['status'];
            $products = [];
            foreach ($data['products'] as $rowId => $cartItem) {
                $product = Proxy::find($cartItem->id);
                $proxy_variation_id = $cartItem->options->proxy_variation_id;
                $proxyVariation = ProxyVariation::find($proxy_variation_id);
                $variation = $proxyVariation->variation;
                $quantity = $cartItem->qty;
                $price = $cartItem->price;
                $totalPrice = $quantity * $price;
                $products[] = [
                    'product_id' => (int) $cartItem->id,
                    'variation_id' => (int) $variation->id,
                    'name_en' => $product->getTranslation('name', 'en') ?? $product->name,
                    'name_vi' => $product->getTranslation('name', 'vi') ?? $product->name,
                    'variation_name' => $variation->name,
                    'quantity' => $quantity,
                    'price' => (float) $price,
                    'total_price' => (float) $totalPrice,
                    'feature_image' => $product->feature_image,
                ];
            }

            $order = Order::create([
                'code' => uniqid_real(),
                'user_id' => $data['user_id'],
                'sub_total' => $data['sub_total'],
                'total' => $data['total'],
                'discount' => $data['discount'],
                'payment_method' => $data['payment_method'],
                'email_notify' => $data['email_notify'],
                'status' => $orderStatus,
                'data' => $products,
                'voucher_id' => $data['voucher_id'],
                'discount_amount' => $data['discount_amount']
            ]);

            foreach ($data['products'] as $rowId => $cartItem) {
                $proxy_variation_id = $cartItem->options->proxy_variation_id;
                $proxyVariation = ProxyVariation::find($proxy_variation_id);
                $variation = $proxyVariation->variation;
                $order->orderDetails()->create([
                    'proxy_id' => $cartItem->id,
                    'variation_id' => $variation->id,
                    'proxy_variation_id' => $proxyVariation->id,
                    'quantity' => $cartItem->qty,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->qty * $cartItem->price
                ]);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::info('createOrder fail ', [ $exception->getMessage() ]);
            throw new \Exception("Đặt hàng không thành công");
        }

        return $order;
    }
}
