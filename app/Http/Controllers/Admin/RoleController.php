<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleRepositoryInterface $roleRepo;
    private PermissionRepositoryInterface $permissionRepo;

    public function __construct(
        RoleRepositoryInterface $roleRepo,
        PermissionRepositoryInterface $permissionRepo
    ) {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }

    public function index()
    {
        $roles = $this->roleRepo->getAllRoles();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionRepo->getAllPermissions();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        $this->roleRepo->createRole($request->all());
        return redirect()->route('admin.roles.index')->with('success', __('messages.created_successfully'));
    }

    public function edit($id)
    {
        $role = $this->roleRepo->getRoleById($id);
        $permissions = $this->permissionRepo->getAllPermissions();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'required|array',
        ]);

        $this->roleRepo->updateRole($id, $request->all());
        return redirect()->route('admin.roles.index')->with('success', __('messages.updated_successfully'));
    }

    public function destroy($id)
    {
        $this->roleRepo->deleteRole($id);
        return redirect()->route('admin.roles.index')->with('success', __('messages.deleted_successfully'));
    }
}
