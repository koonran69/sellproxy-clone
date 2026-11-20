<?php

namespace App\Admin\Http\Controllers\Permission;

use App\Admin\DataTables\Permission\PermissionDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Permission\PermissionRequest;
use App\Core\Repositories\Permission\PermissionRepositoryInterface;
use App\Admin\Services\Route\RouteService;
use App\Core\Responses\Response;

class PermissionController extends Controller
{
    public function __construct(
        public PermissionRepositoryInterface $repository,
        public RouteService $routeService
    )
    {

    }

    public function index(PermissionDataTable $datatable)
    {
        return $datatable->render('admin.permissions.index', [
            'breadcrums' => $this->breadcrums()->addByRouteName(trans('Quyền'), '')
        ]);
    }

    public function create()
    {
        $routeNames = $this->routeService->getRoutesByName(
            config('admin.roles_permissions.route_name_prefix'), 
            config('admin.roles_permissions.whitelist_routes_name')
        );

        if(request()->ajax())
        {
            return view('admin.permissions.modals.create')->with('route_names', $routeNames);
        }

        return view('admin.permissions.create')
        ->with('breadcrums', $this->breadcrums()->addByRouteName(trans('Quyền'), 'admin.permission.index')->addByRouteName(trans('Add')))
        ->with('route_names', $routeNames);
    }

    public function store(PermissionRequest $request)
    {
        $this->repository->create($request->validated());
        return utilities()->responseAjax();
    }

    public function edit($id)
    {
        $routeNames = $this->routeService->getRoutesByName(
            config('admin.roles_permissions.route_name_prefix'), 
            config('admin.roles_permissions.whitelist_routes_name')
        );

        $permission = $this->repository->findOrFail($id);

        return view('admin.permissions.modals.edit')->with('permission', $permission)->with('route_names', $routeNames);
    }

    public function update(PermissionRequest $request)
    {
        $this->repository->update($request->id, $request->validated());
        
        return Response::responseAjax();
    }

    public function delete($id)
    {
        $this->repository->delete($id);

        if(request()->ajax())
        {
            return Response::responseAjax();
        }
    
        return Response::toRoute('admin.permission.index');
    }
}