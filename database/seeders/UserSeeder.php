<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(8)->create();

        $user= User::factory()->create([
            'dui' => '06357872-9',
            'name' => 'Josias Isaac',
            'lastname' => 'Romero',
            'phone' => '7808 5392',
            'email' => 'josias@example.com',
            'gym_id' => 1,
        ]);

        $user->assignRole('administrator');
    }
}
