<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [

            // Dashboard
            'dashboard-access',
            'dashboard-v1-access',
        
            // Users
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-view',
        
            // Roles
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-view',
        
            // Orders
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'order-view',
            'order-status-update',
        
            // Products
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'product-view',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Create roles
        $roles = ['superAdmin', 'admin', 'user', 'member'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assign permissions
        Role::findByName('superAdmin')->syncPermissions(Permission::all());
        Role::findByName('admin')->syncPermissions(Permission::all());

        // Assign role to first user
        $user = User::first();
        if ($user) {
            $user->assignRole('superAdmin');
        }
    }
}
