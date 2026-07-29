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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_dashboard',
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'view_products', 'create_products', 'edit_products', 'delete_products',
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_subcategories', 'create_subcategories', 'edit_subcategories', 'delete_subcategories',
            'view_orders', 'edit_orders', 'delete_orders',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $manager = Role::create(['name' => 'manager', 'guard_name' => 'web']);
        $editor = Role::create(['name' => 'editor', 'guard_name' => 'web']);

        $admin->givePermissionTo(Permission::all());

        $manager->givePermissionTo([
            'view_dashboard', 'view_products', 'create_products', 'edit_products', 'delete_products',
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_subcategories', 'create_subcategories', 'edit_subcategories', 'delete_subcategories',
            'view_orders', 'edit_orders', 'view_reports'
        ]);

        $editor->givePermissionTo([
            'view_dashboard', 'view_products', 'create_products', 'edit_products',
            'view_categories', 'view_subcategories', 'view_orders', 'edit_orders'
        ]);

        $user = User::create([
            'name' => 'المشرف العام',
            'email' => 'admin@store.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $user->assignRole('admin');
    }
}
