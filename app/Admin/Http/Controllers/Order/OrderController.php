<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\OrderDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Order\OrderRequest;
use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Repositories\Order\OrderRepositoryInterface;
use App\Core\Repositories\Proxy\ProxyRepository;
use App\Core\Repositories\User\UserRepositoryInterface;
use App\Models\Attribute;
use App\Models\MemberLevel;
use App\Models\Order;
use App\Models\ProxyVariation;
use App\Models\User;
use App\Models\Variation;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(
        public OrderRepositoryInterface $repository,
        public Attribute $attribute,
        public Variation $variation,
        public UserRepositoryInterface $userRepo,
        public ProxyRepository $proxyRepo,
        public ProxyVariation $proxyVariation,
        public OrderService $orderService
    ) {
    }

    public function index(OrderDataTable $datatable): JsonResponse|View
    {
        return $datatable->render('admin.orders.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Đơn hàng'), ''),
        ]);

    }

    public function create(): View
    {
        return view('admin.orders.create')
            ->with('status', OrderStatus::asSelectArray())
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Đơn hàng'), 'admin.proxy.index')->addByRouteName(trans('add'), ''));
    }

    public function renderInfoUser(OrderRequest $request)
    {
        $user = $this->userRepo->findOrFail($request->input('user_id'));

        return view('admin.orders.partials.info-user', [
            'customer_name' => $user->name,
            'customer_phone' => $user->phone,
        ]);
    }

    public function searchRenderProduct(Request $request)
    {
        $products = $this->proxyRepo->getByColumnsWithRelationsLimit([
            'name' => $request->input('key')
        ], ['variations']);

        return view('admin.orders.partials.list-search-result-product', compact('products'));
    }

    public function addProduct(OrderRequest $request)
    {
        $variation = $this->proxyVariation->findOrFail($request->input('product_variation_id'))->load('variation');
        $proxy = $this->proxyRepo->findOrFail($request->input('product_id'));

        if (!$proxy || !$variation) {
            return response()->json([
                'status' => 400,
                'message' => __('notifyFail'),
            ], 400);
        }

        $response = view('admin.orders.partials.add-item-product', compact('proxy', 'variation'))->render();

        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => $response,
        ], 200);
    }


    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $data['code'] = uniqid_real();
            $data['status'] = OrderStatus::PendingPayment;
            $data['payment_method'] = PaymentMethod::Banking;

            $products = [];
            $subTotal = 0;


            foreach ($data['data']['product_id'] as $key => $productId) {
                $variationId = $data['data']['variation_id'][$key];
                $quantity = $data['data']['quantity'][$key];
                $price = $data['data']['price'][$key];
                $pricePromotion = $data['data']['price_promotion'][$key] ?? $price;
                $totalPrice = $quantity * $pricePromotion;

                $product = $this->proxyRepo->findOrFail($productId);
                $variation = $this->proxyVariation->findOrFail($variationId)->load('variation');

                $products[] = [
                    'product_id' => (int) $productId,
                    'variation_id' => (int) $variationId,
                    'name_en' => $product->getTranslation('name', 'en') ?? $product->name,
                    'name_vi' => $product->getTranslation('name', 'vi') ?? $product->name,
                    'variation_name' => $variation->variation->name,
                    'quantity' => $quantity,
                    'price' => (float) $pricePromotion,
                    'total_price' => (float) $totalPrice,
                    'feature_image' => $product->feature_image,
                ];

                $subTotal += $totalPrice;
            }


            $data['sub_total'] = $subTotal;
            $data['total'] = $subTotal;
            $data['data'] = $products;

            $order = $this->repository->create($data);

            if ($order) {
                DB::commit();
                return $request->input('submitter') == 'save'
                    ? to_route('admin.order.edit', $order->id)->with('success', __('notifySuccess'))
                    : to_route('admin.order.index')->with('success', __('notifySuccess'));
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id): View
    {
        $order = $this->repository->findOrFail($id, ['user']);
        return view('admin.orders.edit')->with('order', $order)
            ->with('status', OrderStatus::asSelectArray())
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Đơn hàng'), 'admin.order.index')->addByRouteName(trans('Chi tiết'), ''));
    }

    public function update(OrderRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $order = $this->repository->find($data['id']);
            $formData = $request->input('data', []);
            $orderData = $order->data;
            foreach ($orderData as &$item) {
                $key = "{$item['product_id']}_{$item['variation_id']}";

                if (isset($formData['account_type'][$key])) {
                    $accountType = $formData['account_type'][$key];

                    if ($accountType === 'cd_key' && !empty($formData['cd_key'][$key])) {
                        $item['account_type'] = 'cd_key';
                        $item['cd_key'] = $formData['cd_key'][$key];

                        unset($item['username'], $item['password']);
                    } elseif ($accountType === 'account_pass' && !empty($formData['username'][$key]) && !empty($formData['password'][$key])) {
                        $item['account_type'] = 'account_pass';
                        $item['username'] = $formData['username'][$key];
                        $item['password'] = $formData['password'][$key];

                        unset($item['cd_key']);
                    } else {
                        unset($item['account_type'], $item['cd_key'], $item['username'], $item['password']);
                    }
                }
            }
            $data['data'] = $orderData;
            $order = $this->repository->update($data['id'], $data);
            if($order->status == OrderStatus::Complete) {
                $transaction = $order->transactions()->where('user_id', $order->user_id)->where('code', $order->code)->first();
                if($transaction) {
                    $transaction->status = TransactionStatus::Paid;
                    $transaction->save();
                }
            }

            if($order->status == OrderStatus::Complete) {
                $this->orderService->updateMemberLevel($order->user_id);
            }

            if ($order) {
                return $request->input('submitter') == 'save'
                    ? back()->with('success', __('notifySuccess'))
                    : to_route('admin.order.index')->with('success', __('notifySuccess'));
            }

            return back()->with('errors', __('notifyFail'));

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id): RedirectResponse|JsonResponse
    {
        try {
            $this->repository->delete($id);

            if (request()->ajax()) {
                return utilities()->responseAjax();
            }

            return to_route('admin.order.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {

            if (request()->ajax()) {
                throw $th;
            }
            return back()->withErrors(['errors' => $th->getMessage()]);
        }
    }
}
