<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //TODO -> aun no terminado

        // Reset cached roles and permissions
       // app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view clients']);
        Permission::create(['name' => 'show client']);
        Permission::create(['name' => 'create client']);
        Permission::create(['name' => 'edit client']);
        Permission::create(['name' => 'delete client']);
        Permission::create(['name' => 'restore client']);
        Permission::create(['name' => 'restoreAll clients']);
        Permission::create(['name' => 'force-delete client']);

        Role::create(['name' => 'receptionist'])
        ->givePermissionTo(['view clients', 'create client','edit client','delete client']);
        
        Role::create(['name' => 'manager'])
        ->givePermissionTo(['view clients', 'create client','edit client','delete client','restore client','restoreAll clients']);

        Role::create(['name' => 'administrator'])
        ->givePermissionTo(Permission::all());
        
    }
}
