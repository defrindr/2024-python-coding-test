<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['role:super_admin']);
    }

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('pages.role_permissions.index', compact('roles', 'permissions'));
    }

    public function edit($role)
    {
        $role = Role::find($role);
        $permissions = Permission::all();
        return view('pages.role_permissions.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $role)
    {
        $role = Role::find($role);
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
        $role->syncPermissions($permissions);
        Alert::success('Success', 'Role permissions updated');
        return redirect()->route('permission.index');
    }
}