<?php

namespace App\Admin\Http\Controllers\ProxyLoginLog;

use App\Admin\DataTables\ProxyLoginLog\ProxyLoginLogDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Facades\UtilitiFacade;
use App\Models\ProxyLoginLog;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProxyLoginLogController extends Controller
{
    public function __construct(
        public ProxyLoginLog $model
    ) {}

    public function index(ProxyLoginLogDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.proxy-login-log.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Proxy Login Logs'))
        ]);
    }

    public function delete($id)
    {
        try {
            $this->model->findOrFail($id)->delete();

            if (request()->ajax()) {
                return UtilitiFacade::responseAjax();
            }

            return UtilitiFacade::toRoute('admin.proxy_login_log.index');
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return UtilitiFacade::responseAjax(error: true, msg: $th->getMessage());
            }

            return UtilitiFacade::responseBack(error: true, msg: $th->getMessage());
        }
    }
}
