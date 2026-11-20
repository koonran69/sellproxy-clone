<?php

namespace App\Admin\Http\Controllers\HomeProxy;

use App\Admin\DataTables\HomeProxy\HomeProxyDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Models\ProxyHomeOrder;
use App\Models\ProxyHomeProxy;
use App\Services\HomeKeyRotateOrderService;
use App\Services\HomeProxyAuthService;
use App\Services\ProxyHomeSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeProxyController extends Controller
{
    public function __construct(
        public HomeProxyAuthService $service,
        private readonly HomeKeyRotateOrderService $homeKeyRotateOrderService,
    )
    {

    }

    public function handleSyncProxiesForOrder(Request $request)
    {
        $request->validate([
            'partner_order_id' => 'required|string',
        ]);
        $partnerOrderId = $request->partner_order_id;
        $orderModel = ProxyHomeOrder::query()
            ->where('partner_order_id', $partnerOrderId)
            ->first();
        if (!$orderModel) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng với partner_order_id này trong hệ thống.',
                'partner_order_id' => $partnerOrderId
            ], 404);
        }
        try {
            $syncService = app(ProxyHomeSyncService::class);
            $synced = false;
            $retryCount = 3;
            while ($retryCount > 0 && !$synced) {
                $synced = $syncService->syncProxiesForOrder($orderModel);
                if (!$synced && $retryCount > 1) {
                    sleep(2);
                }
                $retryCount--;
            }
            if (!$synced) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã gọi đồng bộ nhưng bên thứ 3 chưa trả về dữ liệu proxy. Vui lòng thử lại sau ít phút.',
                    'partner_order_id' => $partnerOrderId
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Đồng bộ proxy thủ công thành công!',
                'partner_order_id' => $partnerOrderId,
                'proxies_count' => $orderModel->proxies()->count() ?? 0,
            ]);

        } catch (\Exception $e) {
            Log::error("Sync proxies failed for order {$partnerOrderId}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống khi đồng bộ proxy: ' . $e->getMessage(),
                'partner_order_id' => $partnerOrderId
            ], 500);
        }
    }

    public function generateTokenKeyRotate(Request $request, $id)
    {
        $proxy = ProxyHomeProxy::find($id);

        if (!$proxy) {
            return response()->json([
                'status' => false,
                'message' => "Proxy không tồn tại",
            ], 422);
        }

        try {
            $result = $this->homeKeyRotateOrderService->generateToken($proxy->partner_item_id);

            $newToken = $result['token'] ?? ($result['data']['token'] ?? null);

            return response()->json([
                'status' => true,
                'message' => 'Lấy token thành công',
                'token' => $newToken,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function index(HomeProxyDataTable $dataTable)
    {
        return $dataTable->render('admin.homeproxy.index', [
            'merchant' => $this->service->getMerchant(),
            'breadcrums' => $this->breadcrums()->add(trans('Home proxy'))
        ]);
    }

    public function charge()
    {
        return view('admin.homeproxy.modal.add');
    }

    public function handleCharge(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000'
        ]);

        $res = $this->service->charge($request->input('amount'));

        if($res == null)
        {
            return response()->json([
                'status' => false,
                'msg' => trans('Nạp tiền thất bại!')
            ]);
        }

        return response()->json([
            'status' => true,
            'html' => view('admin.homeproxy.partials.charge-success', [
                'qrcode' => $res->qrCode,
                'acc_name' => $res->accountName,
                'bank_name' => $res->bankName,
                'acc_number' => $res->accountNumber,
                'desc' => $res->description,
                'amount' => $res->amount
            ])->render()
        ]);
    }
}
