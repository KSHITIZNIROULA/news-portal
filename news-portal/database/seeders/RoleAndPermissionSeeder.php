<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Clear cached permissions
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        Permission::firstOrCreate(['name' => 'view exclusive articles']);
        Permission::firstOrCreate(['name' => 'publish exclusive articles']);
        Permission::firstOrCreate(['name' => 'manage subscriptions']);

        // Create or update roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $publisher = Role::firstOrCreate(['name' => 'publisher']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions
        $admin->syncPermissions(['view exclusive articles', 'publish exclusive articles', 'manage subscriptions']);
        $publisher->syncPermissions(['view exclusive articles', 'publish exclusive articles']);
        $user->syncPermissions(['view exclusive articles']);
    }
}