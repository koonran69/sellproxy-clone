<?php

namespace App\Admin\Http\Controllers\ProxylineOrder;

use App\Admin\DataTables\Contact\ContactDataTable;
use App\Admin\DataTables\Proxyline\ProxylineDataTable;
use App\Admin\DataTables\Proxyline\ProxylineOrderDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Http\Requests\Request;
use App\Core\Repositories\Contact\ContactRepositoryInterface;
use App\Core\Repositories\ProxyPackage\ProxyPackageRepositoryInterface;
use App\Models\IpVersion;
use App\Models\ProxyCountry;
use App\Models\ProxyLineType;
use App\Models\ProxyOrder;
use App\Models\ProxyPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProxylineOrderController extends Controller
{
    public function index(ProxylineOrderDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.proxyline_order.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Đơn hàng Proxyline'))
        ]);
    }

    public function view($id)
    {
        $order = ProxyOrder::with('proxyInstances')->where('id', $id)->first();
        return view('admin.proxyline_order.view')->with('order', $order)
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Đơn hàng'), 'admin.proxyline_order.index')->addByRouteName(trans('Chi tiết'), ''));
    }
}
