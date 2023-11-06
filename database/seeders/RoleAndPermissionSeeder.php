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
        // CLIENTS 
        Permission::create(['name' => 'view clients']);
        Permission::create(['name' => 'show client']);
        Permission::create(['name' => 'create client']);
        Permission::create(['name' => 'edit client']);
        Permission::create(['name' => 'delete client']);
        Permission::create(['name' => 'restore client']);
        Permission::create(['name' => 'update client password']);

        Permission::create(['name' => 'create client_system']);
        Permission::create(['name' => 'edit client_system']);
        Permission::create(['name' => 'delete client_system']);
        
        Permission::create(['name' => 'create client suscription']);
        Permission::create(['name' => 'cancel client suscription']);

        Permission::create(['name' => 'assign client training_sessions']);
        Permission::create(['name' => 'register client atendance_date training_session']);
        Permission::create(['name' => 'delete client training_session']);

        Permission::create(['name' => 'create client purchase']);
        Permission::create(['name' => 'cancel client purchase']);

        //PRODUCTS
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'show product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'restore product']);

        //COACHES
        Permission::create(['name' => 'view coaches']);
        Permission::create(['name' => 'show coach']);
        Permission::create(['name' => 'create coach']);
        Permission::create(['name' => 'edit coach']);
        Permission::create(['name' => 'delete coach']);
        Permission::create(['name' => 'restore coach']);
        Permission::create(['name' => 'update coach password']);

        //TRAINING SESSIONS
        Permission::create(['name' => 'view training sessions']);
        Permission::create(['name' => 'show training session']);
        Permission::create(['name' => 'create training session']);
        Permission::create(['name' => 'edit training session']);
        Permission::create(['name' => 'delete training session']);
        
        //EXERCISE
        Permission::create(['name' => 'view exercises']);
        Permission::create(['name' => 'show exercise']);
        Permission::create(['name' => 'create exercise']);
        Permission::create(['name' => 'edit exercise']);
        Permission::create(['name' => 'delete exercise']);

        //SUSCRIPTIONS 
        Permission::create(['name' => 'view suscriptions']);
        Permission::create(['name' => 'show suscription']);
        Permission::create(['name' => 'create suscription']);
        Permission::create(['name' => 'edit suscription']);
        Permission::create(['name' => 'delete suscription']);
        Permission::create(['name' => 'cancel suscription']);
        
        //PLANS
        Permission::create(['name' => 'view plans']);
        Permission::create(['name' => 'show plan']);
        Permission::create(['name' => 'create plan']);
        Permission::create(['name' => 'edit plan']);
        Permission::create(['name' => 'delete plan']);
        
        //USERS
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'show user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'restore user']);
        Permission::create(['name' => 'update user password']);
        
       /*  Role::create(['name' => 'client']);
        Role::create(['name' => 'coach']); */
        //Permission::create(['name' => 'restoreAll clients']); create client_system
        //Permission::create(['name' => 'force-delete client']); 

        Role::create(['name' => 'receptionist'])
        ->givePermissionTo(['view clients','show client','create client','edit client']);
        
        Role::create(['name' => 'manager'])
        ->givePermissionTo(['view clients' ,'create client','edit client','delete client','restore client']);

        Role::create(['name' => 'administrator'])
        ->givePermissionTo(Permission::all());
        
        
    }
}
