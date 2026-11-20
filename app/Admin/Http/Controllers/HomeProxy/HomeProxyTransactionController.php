<?php

namespace App\Admin\Http\Controllers\HomeProxy;

use App\Admin\DataTables\HomeProxy\HomeProxyTransactionDataTable;
use App\Admin\Http\Controllers\Controller;

class HomeProxyTransactionController extends Controller
{
    public function index(HomeProxyTransactionDataTable $dataTable)
    {
        return $dataTable->render('admin.homeproxy.transactions.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Home proxy'))->add(trans('Giao dịch'))
        ]);
    }
}