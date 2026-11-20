<?php

namespace App\Admin\Http\Controllers\QA;

use App\Admin\DataTables\QA\QADataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\QA\QARequest;
use App\Core\Enums\DefaultStatus;
use App\Core\Repositories\QA\QARepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class QAController extends Controller
{

    public function __construct(
        protected QARepositoryInterface $repository,
    ) {
    }

    public function index(QADataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.qas.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Q&A'))
        ]);
    }

    public function create(): View
    {
        return view('admin.qas.create')->with('status', DefaultStatus::asSelectArray())
            ->with('breadcrums', $this->breadcrums()->add(trans('Q&A')));
    }

    public function store(QARequest $request)
    {
        try {
            $data = $request->validated();
            $qa = $this->repository->create($data);

            if ($qa) {
                return $request->input('submitter') == 'save'
                    ? to_route('admin.qa.edit', $qa->id)->with('success', __('notifySuccess'))
                    : to_route('admin.qa.index')->with('success', __('notifySuccess'));
            }

        } catch (\Throwable $th) {

            if ($request->ajax()) {
                throw $th;
            }
            return back()->withInput()->withErrors(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id): View
    {
        $qa = $this->repository->findOrFail($id);
        return view('admin.qas.edit')
            ->with('qa', $qa)
            ->with('status', DefaultStatus::asSelectArray())->with('breadcrums', $this->breadcrums()->add(trans('Q&A')));
    }

    public function update(QARequest $request)
    {
        try {
            $data = $request->validated();

            $qa = $this->repository->update($data['id'], $data);

            if ($qa) {
                return $request->input('submitter') == 'save'
                    ? to_route('admin.qa.edit', $qa->id)->with('success', __('notifySuccess'))
                    : to_route('admin.qa.index')->with('success', __('notifySuccess'));
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->repository->delete($id);

            return response()->json([
                'msg' => trans('notifySuccess')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
