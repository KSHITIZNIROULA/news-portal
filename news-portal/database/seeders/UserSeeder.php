<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'cheetez',
            'email' => 'cheetez@gmail.com',
            'password' => Hash::make('123123123'),
        ]);
        $role = Role::firstOrCreate(['name' => 'admin']); // Ensure the role exists
        $user->assignRole($role);
    }
}
