<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateEditRoleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function __construct(){
        $this->authorizeResource(Role::class,'role');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //no xd
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Users/Roles/CreateEditRole',[
            'permissions' => Permission::all('id','name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditRoleRequest $request)
    {
        $permissions = Permission::whereIn('id', $request->validatedPermissionsIds())->get(); // Retrieve Role objects based on role IDs
        $role = Role::create($request->validatedRole())->syncPermissions($permissions);

        return redirect()->route('roles.show',$role->id)->with([
            'level' => 'success',
            'message' => 'Role Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return Inertia::render('User/Users/Roles/Show',[
            'role' => $role->load('permissions:id,name'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return Inertia::render('User/Users/Roles/CreateEditRole',[
            'role' => $role,
            'selected_permissions' => $role->permissions->pluck('id')->toArray(),
            'permissions' => Permission::all('id','name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditRoleRequest $request, Role $role)
    {
        $permissions = Permission::whereIn('id', $request->validatedPermissionsIds())->get(); // Retrieve Role objects based on role IDs
        $role->update($request->validatedRole());
        $role->syncPermissions($permissions);

        return redirect()->route('roles.show',$role->id)->with([
            'level' => 'success',
            'message' => 'Role Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->syncPermissions([]);
        $role->delete();

        return redirect()->route('users.index')->with([
            'level' => 'success',
            'message' => 'Role Deleted Succesfully!'
        ]);
    }
}
