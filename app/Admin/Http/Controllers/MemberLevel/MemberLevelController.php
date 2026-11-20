<?php

namespace App\Admin\Http\Controllers\MemberLevel;

use App\Admin\DataTables\MemberLevel\MemberLevelDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\MemberLevel\MemberLevelRequest;
use App\Models\MemberLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MemberLevelController extends Controller
{
    public function __construct(
        public MemberLevel $model
    ) {

    }
    public function index(MemberLevelDataTable $dataTable)
    {
        return $dataTable->render('admin.member_levels.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Hạng thành viên'))
        ]);
    }

    public function create(): View
    {
        return view('admin.member_levels.modals.create');
    }

    public function store(MemberLevelRequest $request)
    {
        try {

            $this->model->create($request->validated());

            if ($request->ajax()) {
                return utilities()->responseAjax();
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id): View
    {
        return view('admin.member_levels.modals.edit', [
            'member_level' => $this->model->findOrFail($id)
        ]);
    }

    public function update(MemberLevelRequest $request)
    {
        try {

            $this->model->findOrFail($request->input('id'))->update($request->validated());

            if ($request->ajax()) {
                return utilities()->responseAjax();
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->model->findOrFail($id)->delete();

            return response()->json([
                'msg' => trans('notifySuccess')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}