<?php

namespace App\Admin\Http\Controllers\ProxyResidentialOrder;

use App\Admin\DataTables\ProxyResidential\ProxyResidentialOrderDataTable;
use App\Admin\DataTables\ProxyResidential\TransactionDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Http\Requests\Request;
use App\Models\ProxyOrder;
use App\Models\ProxyResidentialOrder;
use App\Models\ProxyResidentialProxy;
use App\Services\ProxyResidentialService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProxyResidentialOrderController extends Controller
{

    public function __construct(
        protected ProxyResidentialService $proxyResidentialService,
        public ProxyResidentialOrder      $proxyResidentialOrderModel,
        public ProxyResidentialProxy      $proxyResidentialProxyModel,
    )
    {
    }
    public function transaction(TransactionDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.proxy_residential_order.transactions.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Proxy residential'))->add(trans('Giao dịch'))
        ]);
    }

    public function index(ProxyResidentialOrderDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.proxy_residential_order.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Đơn hàng Proxy Residential'))
        ]);
    }

    public function view($id)
    {
        $availableTypes = config('proxyresidental')['setting']['availableTypes'];
        $order = ProxyResidentialOrder::with(['user','proxies.order.country'])->where('id', $id)->first();
        return view('admin.proxy_residential_order.view')->with('order', $order)->with('availableTypes', $availableTypes)
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Đơn hàng'), 'admin.proxy_residential_order.index')->addByRouteName(trans('Chi tiết'), ''));
    }

    public function changeProtocolProxy(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'protocol' => 'required',
        ]);
        $proxy = $this->proxyResidentialProxyModel->with('order')->where('id', $request->input('id'))->firstOrFail();
        if (!$proxy) {
            return response()->json([
                'success' => false,
                'message' => "Proxy không tồn tại!",
            ]);
        }
        $res = $this->proxyResidentialService->changeProtocol($proxy, $request->protocol);
        if ($res) {
            return response()->json([
                'success' => true,
                'message' => "Cập nhật thành công!",
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => "Có lỗi xãy ra, vui lòng thử lại sau!",
        ]);
    }
}
