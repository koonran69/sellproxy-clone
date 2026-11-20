<?php

namespace App\Services;

use App\Core\Repositories\Proxy\ProxyRepositoryInterface;
use App\Models\ProxyVariation;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CartService
{

    private $proxyRepository;

    public function __construct(ProxyRepositoryInterface $proxyRepository)
    {
        $this->proxyRepository = $proxyRepository;
    }

    public function addToCart($proxy_id, $proxy_variation_id, $quantity) {
        $proxy = $this->proxyRepository->find($proxy_id);

        $proxy_variation = ProxyVariation::with('variation')->where("id", $proxy_variation_id)->where("proxy_id", $proxy_id)->first();

        if (!$proxy) {
            return [
                'status'  => false,
                'message' => 'Sản phẩm không tồn tại'
            ];
        }

        $cartItem = Cart::content()->first(function ($cart) use ($proxy_id, $proxy_variation_id) {
            return $cart->id == $proxy_id && $cart->options->proxy_variation_id == $proxy_variation_id;
        });

        $price = $proxy_variation->has_promotion ? $proxy_variation->price_promotion :$proxy_variation->price;
        if ($cartItem) {
            Cart::update($cartItem->rowId, $cartItem->qty + $quantity);
        } else {
            Cart::add([
                'id'      => $proxy->id,
                'name'    => $proxy->name,
                'qty'     => $quantity,
                'price'   => $price,
                'weight'  => 0,
                'options' => [
                    'image'              => $proxy->feature_image ?? '',
                    'proxy_variation_id' => $proxy_variation_id,
                    'variation_name' => $proxy_variation->variation->name
                ]
            ]);
        }

        return [
            'status'  => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'data'    => Cart::content(),
            'count'   => Cart::content()->count()
        ];
    }

    public function getCartContent()
    {
        return Cart::content();
    }

    public function updateCartItem($rowId, $quantity)
    {
        Cart::update($rowId, $quantity);

        return [
            'status'  => true,
            'message' => 'Cập nhật số lượng thành công',
            'data'    => Cart::content(),
            'count'   => Cart::content()->count()
        ];
    }

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);

        return [
            'status'  => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
            'data'    => Cart::content(),
            'count'   => Cart::content()->count()
        ];
    }

    public function clearCart()
    {
        Cart::destroy();

        return [
            'status'  => true,
            'message' => 'Giỏ hàng đã được xóa sạch'
        ];
    }

    public function getTotalPrice()
    {
        $totalPrice = Cart::content()->sum(function ($item) {
            return $item->price * $item->qty;
        });
        return $totalPrice;
    }
}