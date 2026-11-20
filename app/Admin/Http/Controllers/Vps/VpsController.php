<?php

namespace App\Admin\Http\Controllers\Vps;


use App\Admin\DataTables\Vps\ProxyOrderDataTable;
use App\Admin\DataTables\Vps\TransactionDataTable;
use App\Admin\DataTables\Vps\TransactionProxyDataTable;
use App\Admin\DataTables\Vps\VpsOrderDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Models\ProxySellvps247Order;
use App\Models\VpsOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class VpsController extends Controller
{
    //=================================PROXY=================================
    public function viewProxy($id)
    {
        $order = ProxySellvps247Order::with(['user','proxies'])->where('id', $id)->first();
        return view('admin.vps.proxy.view')->with('order', $order)
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Đơn hàng'), 'admin.vps.proxy.indexProxy')->addByRouteName(trans('Chi tiết'), ''));
    }
    public function indexProxy(ProxyOrderDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.vps.proxy.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Đơn hàng proxy'))
        ]);
    }
    public function transactionProxy(TransactionProxyDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.vps.proxy.transactions.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Proxy'))->add(trans('Giao dịch'))
        ]);
    }
    //=================================VPS===================================
    public function transaction(TransactionDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.vps.transactions.index', [
            'breadcrums' => $this->breadcrums()->add(trans('VPS'))->add(trans('Giao dịch'))
        ]);
    }
    public function index(VpsOrderDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.vps.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Đơn hàng VPS'))
        ]);
    }
    public function view($id)
    {
        $order = VpsOrder::with(['user','vps'])->where('id', $id)->first();
        return view('admin.vps.view')->with('order', $order)
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Đơn hàng'), 'admin.vps.index')->addByRouteName(trans('Chi tiết'), ''));
    }
}
