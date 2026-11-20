<?php

namespace App\Admin\Http\Controllers\Admin;

use App\Admin\DataTables\Admin\AdminDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Admin\AdminRequest;
use App\Core\Repositories\Permission\PermissionRepositoryInterface;
use App\Core\Repositories\Role\RoleRepositoryInterface;
use App\Core\Facades\UtilitiFacade;
use App\Core\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct(
        public AdminRepositoryInterface $repository,
        public RoleRepositoryInterface $repoRole,
        public PermissionRepositoryInterface $repoPermission
    )
    {
    }

    public function index(AdminDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.admins.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Admin'))
        ]);
    }

    public function create(): View
    {
        $roles = $this->repoRole->getAll();

        $permissions = $this->repoPermission->getAll();

        return view('admin.admins.create')
        ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Admin'), 'admin.admin.index')->add(trans('Add')))
        ->with('roles', $roles)
        ->with('permissions', $permissions);
    }

    public function store(AdminRequest $request): RedirectResponse
    {
        try {

            $data = $request->validated();

            $admin = $this->repository->createHasRoleAndPermission($data['admin'], $data['roles'] ?? [], $data['permissions'] ?? []);

            if($admin)
            {
                return $request->input('submitter') == 'save' 
                    ? to_route('admin.admin.edit', $admin->id)->with('success', __('notifySuccess')) 
                    : to_route('admin.admin.index')->with('success', __('notifySuccess'));
            }

            return UtilitiFacade::responseBack();

        } catch (\Throwable $th) {

            // throw $th;
            return UtilitiFacade::responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function edit($id): View
    {
        $admin = $this->repository->findOrFail($id, ['roles', 'permissions']);

        $roles = $this->repoRole->getAll();

        $permissions = $this->repoPermission->getAll();
        
        return view('admin.admins.edit')
        ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Admin'), 'admin.admin.index')->add(trans('Edit')))
        ->with('admin', $admin)
        ->with('roles', $roles)
        ->with('permissions', $permissions)
        ->with('admin_has_roles', $admin->roles->pluck('id')->toArray())
        ->with('admin_has_permissions', $admin->permissions->pluck('id')->toArray());
    }

    public function update(AdminRequest $request)
    {
        try {

            $data = $request->validated();

            $admin = $this->repository->updateHasRoleAndPermission($request->id, $data['admin'], $data['roles'] ?? [], $data['permissions'] ?? []);

            if($admin)
            {
                return $request->input('submitter') == 'save' 
                    ? UtilitiFacade::responseBack()
                    : UtilitiFacade::toRoute('admin.admin.index');
            }

            return UtilitiFacade::responseBack();

        } catch (\Throwable $th) {

            // throw $th;

            return UtilitiFacade::responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function delete($id)
    {
        try {
            
            $this->repository->delete($id);

            if(request()->ajax())
            {
                return UtilitiFacade::responseAjax();
            }
            
            return UtilitiFacade::toRoute('admin.admin.index');

        } catch (\Throwable $th) {

            //throw $th;

            if(request()->ajax())
            {
                return UtilitiFacade::responseAjax(error: true, msg: $th->getMessage());
            }

            return UtilitiFacade::responseBack(error: true, msg: $th->getMessage());
        }
    }
}