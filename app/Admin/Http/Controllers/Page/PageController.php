<?php

namespace App\Admin\Http\Controllers\Page;

use App\Admin\DataTables\Coin\CoinDataTable;
use App\Admin\DataTables\Page\PageDataTable;
use App\Admin\DataTables\QA\QADataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Coin\CoinRequest;
use App\Admin\Http\Requests\Page\PageRequest;
use App\Admin\Http\Requests\QA\QARequest;
use App\Core\Enums\DefaultStatus;
use App\Core\Repositories\Coin\CoinRepositoryInterface;
use App\Core\Repositories\Page\PageRepositoryInterface;
use App\Core\Repositories\QA\QARepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PageController extends Controller
{

    public function __construct(
        protected PageRepositoryInterface $repository,
    ) {
    }

    public function index(PageDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.pages.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Page'))
        ]);
    }

    public function edit($id, $lang = 'vi'): View
    {
        $page = $this->repository->findOrFail($id);

        return view('admin.pages.edit', [
            'breadcrums' => $this->breadcrums()->add(trans('Trang'))->addByRouteName(__('Trang'), 'admin.page.index')->add(__('edit')),
            'page' => $page,
            'lang' => $lang,
            'status' => DefaultStatus::asSelectArray(),
        ]);
    }

    public function update(PageRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $page = $this->repository->findOrFail($data['id']);

            $page->fill($data);

            $page->save();

            DB::commit();
            if ($page) {
                return $request->input('submitter') == 'save' ? utilities()->responseBack() : utilities()->toRoute('admin.page.index');
            }

            return utilities()->responseBack();
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return utilities()->responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }
}
