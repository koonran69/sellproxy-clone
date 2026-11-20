<?php

namespace App\Admin\Http\Controllers\Role;

use App\Admin\DataTables\Role\RoleDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Role\RoleRequest;
use App\Core\Repositories\Permission\PermissionRepositoryInterface;
use App\Core\Repositories\Role\RoleRepositoryInterface;
use App\Admin\Services\Route\RouteService;
use App\Core\Responses\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function __construct(
        public RoleRepositoryInterface $repository,
        public PermissionRepositoryInterface $repoPermission,
        public RouteService $routeService
    )
    {

    }

    public function index(RoleDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.roles.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Vai trò'))
        ]);
    }

    public function create()
    {
        $permissions = $this->repoPermission->getAll();

        return view('admin.roles.create')
        ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Vai trò'), 'admin.role.index')->addByRouteName(trans('Add')))
        ->with('permissions', $permissions);
    }

    public function store(RoleRequest $request)
    {
        try {

            $data = $request->validated();

            $role = $this->repository->createHasPermissions($data['role'], $data['permissions']);
        
            if($role)
            {
                return $request->input('submitter') == 'save' 
                    ? to_route('admin.role.edit', $role->id)->with('success', __('notifySuccess')) 
                    : to_route('admin.role.index')->with('success', __('notifySuccess'));

                return $request->input('submitter') == 'save' 
                    ? Response::toRoute('admin.role.edit', $role->id)
                    : Response::toRoute('admin.role.index');
            }

            return Response::responseBack(error: true);

        } catch (\Throwable $th) {

            // throw $th;
            return Response::responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function edit($id): View
    {
        $role = $this->repository->findOrFail($id, ['permissions']);

        $permissions = $this->repoPermission->getAll();
        
        return view('admin.roles.edit')
        ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Vai trò'), 'admin.role.index')->addByRouteName(trans('Edit')))
        ->with('role', $role)
        ->with('permissions', $permissions)
        ->with('role_has_permissions', $role->permissions->pluck('id')->toArray());
    }

    public function update(RoleRequest $request): RedirectResponse
    {
        try {

            $data = $request->validated();

            $role = $this->repository->updateHasPermissions($request->id, $data['role'], $data['permissions']);

            if($role)
            {
                return $request->input('submitter') == 'save' 
                    ? Response::responseBack()
                    : Response::toRoute('admin.role.index');
            }

            return Response::responseBack(error: true);

        } catch (\Throwable $th) {

            // throw $th;
            return Response::responseBack(error: true, msg: $th->getMessage(), withInput: true);
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
            
            $this->repository->delete($id);
        
            if(request()->ajax())
            {
                return Response::responseAjax();
            }
            
            return to_route('admin.role.index')->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {

            if(request()->ajax())
            {
                return Response::responseAjax(error: true, msg: $th->getMessage());
            }
            return Response::responseBack(error: true, msg: $th->getMessage());
        }
    }
}