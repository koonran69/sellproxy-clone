<?php

namespace App\Admin\Http\Controllers\CdKey;

use App\Admin\DataTables\CdKey\CdKeyDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Facades\UtilitiFacade;
use App\Core\Http\Requests\Request;
use App\Core\Repositories\CdKey\CdKeyRepositoryInterface;
use App\Models\Attribute;
use App\Models\CDkey;
use App\Models\Variation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CdKeyController extends Controller
{

    public function __construct(
        protected CdKeyRepositoryInterface $repository,
    ) {
    }

    public function index(CdKeyDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.cdkeys.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Coin'))
        ]);
    }

    public function create(): View
    {
        return view('admin.cdkeys.modal.add', []);
    }

    public function getVariationByProxy(Request $request)
    {
        $proxy_id = $request->proxy_id;
        $variations = \App\Models\ProxyVariation::with('variation')->where('proxy_id', $proxy_id)->get();
        $data = [];
        foreach ($variations as $variation)
        {
            $data[] = [ 'id' => $variation->variation->id, 'name' => $variation->variation->name];
        }
        return $data;
    }

    public function import(Request $request)
    {
        try {
            $proxy_id = $request->proxy_id;
            $variation_id = $request->variation_id;
            $variation = Variation::find($variation_id);
            $attr = Attribute::find($variation->attr_id);
            $attr_id = $attr->id;
            $strCdKey = $request->cdkeys;
            $arrCdKey = explode("\n", $strCdKey);
            foreach ($arrCdKey as $cdkey) {
                $cdkey = trim($cdkey);
                CDkey::firstOrCreate([
                    'proxy_id' => $proxy_id,
                    'cdkey' => $cdkey
                ], [
                    'cdkey' => $cdkey,
                    'proxy_id' => $proxy_id,
                    'variation_id' => $variation_id,
                    'attr_id' => $attr_id
                ]);
            }
            return UtilitiFacade::responseAjax();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return UtilitiFacade::responseAjax(error: true, msg: $th->getMessage());
        }
    }

    public function delete($id): RedirectResponse|JsonResponse
    {

        try {

            $this->repository->delete($id);

            if(request()->ajax())
            {
                return utilities()->responseAjax();
            }

            return to_route('admin.cdkey.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {

            if(request()->ajax())
            {
                throw $th;
            }
            return back()->withErrors(['errors' => $th->getMessage()]);
        }
    }
}
