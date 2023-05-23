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
       /*  Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']); */


        /* $role = Role::create(['name' => 'employee'])
        ->givePermissionTo(['view product', 'create product','edit product']);
        
        $role = Role::create(['name' => 'administrador']);
        $role->givePermissionTo(Permission::all()); */
    }
}
