<?php

namespace App\Http\Controllers;

use App\Core\Enums\DefaultStatus;
use App\Models\Coin;
use App\Services\AuthService;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request) {
        $request->validate([
            'proxy_id' => 'required|exists:proxies,id',
            'proxy_variation_id' => 'required|exists:proxy_variations,id',
        ]);
        $data = $request->only(['proxy_id', 'proxy_variation_id']);
        $type = $request->type ?? "add_to_cart";
        $response = $this->cartService->addToCart($data['proxy_id'], $data['proxy_variation_id'] , 1);
        if($type == "buyNow"){
            $response['type'] = 'buyNow';
            $response['redirect_url'] = route('cart.getCart');
        }
        return response()->json($response);
    }

    public function getCart(Request $request) {
        $user = auth()->user();
        $data['cartContent'] = $this->cartService->getCartContent();
        $data['sub_total'] = $this->cartService->getTotalPrice();
        if($user) {
            $available_balance = $user->available_balance ?? 0;
            $data['available_balance'] = $available_balance;
        }

        $privateVouchers = $user->privateVouchers ?? collect();
        $vouchers = $user->vouchers ?? collect();

        if ($privateVouchers->isNotEmpty() && $vouchers->isNotEmpty()) {
            $resultVouchers = $privateVouchers->concat($vouchers)->values();
        } elseif ($privateVouchers->isNotEmpty()) {
            $resultVouchers = $privateVouchers;
        } else {
            $resultVouchers = $vouchers;
        }
        $data['vouchers'] = $resultVouchers;
        $data['coins'] = Coin::where("status", DefaultStatus::Published)->orderBy('position')->get();
        return view("public.cart.cart")->with($data);
    }

    public function updateCartItem(Request $request) {
        $response = $this->cartService->updateCartItem($request->rowId, $request->quantity);
        return response()->json($response);
    }

    public function removeFromCart(Request $request) {
        $response = $this->cartService->removeFromCart($request->rowId);
        return response()->json($response);
    }
}
