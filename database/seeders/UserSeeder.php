<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Role::all()->pluck('name');
        $roles = Role::all()->pluck('name');
        User::factory(8)->create()->each(function ($user) use ($roles){
            $user->assignRole($roles->random(rand(1,$roles->count())));
        });
        
        $user= User::factory()->create([
            'dui' => '06357872-9',
            'name' => 'Josias Isaac',
            'lastname' => 'Romero',
            'phone' => '78085392',
            'email' => 'josias@example.com',
            'gym_id' => 1,
        ]);

        $user->assignRole('administrator');
    }
}
