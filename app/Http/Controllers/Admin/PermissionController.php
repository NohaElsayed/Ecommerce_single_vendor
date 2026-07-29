<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(private PermissionRepositoryInterface $permissionRepo) {}

    public function index()
    {
        $permissions = $this->permissionRepo->all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions']);
        $this->permissionRepo->create(['name' => $request->name]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission created.');
    }

    public function edit($id)
    {
        $permission = $this->permissionRepo->find($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name,' . $id]);
        $this->permissionRepo->update($id, ['name' => $request->name]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated.');
    }

    public function destroy($id)
    {
        $this->permissionRepo->delete($id);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted.');
    }
}
