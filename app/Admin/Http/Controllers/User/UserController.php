<?php

namespace App\Admin\Http\Controllers\User;

use App\Admin\DataTables\User\UserDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\User\UserRequest;
use App\Core\Enums\Gender;
use App\Core\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        public UserRepositoryInterface $repository,
    )
    {
    }

    public function index(UserDataTable $datatable): JsonResponse | View
    {
        return $datatable->render('admin.users.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Khách hàng'), ''),
        ]);

    }

    public function create(): View
    {
        return view('admin.users.create')
        ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Khách hàng'), 'admin.user.index')->addByRouteName(trans('add'), ''))
        ->with('gender', Gender::asSelectArray());
    }

    public function store(UserRequest $request): RedirectResponse
    {
        try {

            $user = $this->repository->create($request->validated());

            if ($user) {
                return $request->input('submitter') == 'save'
                    ? to_route('admin.user.edit', $user->id)->with('success', __('notifySuccess'))
                    : to_route('admin.user.index')->with('success', __('notifySuccess'));
            }

            return utilities()->responseBack();

        } catch (\Throwable $th) {

            // throw $th;
            return back()->withInput()->withErrors(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id): View
    {
        $user = $this->repository->findOrFail($id, []);

        return view('admin.users.edit')->with('user', $user)
            ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Khách hàng'), 'admin.user.index')->addByRouteName(trans('edit'), ''));
    }

    public function update(UserRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            if($data['password'] == null)
            {
                unset($data['password']);
            }
            
            $User = $this->repository->update($request->input('id'), $data);

            if ($User) {
                return $request->input('submitter') == 'save'
                ? back()->with('success', __('notifySuccess'))
                : to_route('admin.user.index')->with('success', __('notifySuccess'));
            }

            return back()->with('errors', __('notifyFail'));

        } catch (\Throwable $th) {

            // throw $th;
            return back()->withInput()->withErrors(['errors' => $th->getMessage()]);
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

            return to_route('admin.user.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {

            if(request()->ajax())
            {
                throw $th;
            }
            return back()->withErrors(['errors' => $th->getMessage()]);
        }
    }
    public function searchSelect(Request $request)
    {
        return [
            'results' => $this->repository->searchSelect($request->input('term', ''))
        ];
    }
}
