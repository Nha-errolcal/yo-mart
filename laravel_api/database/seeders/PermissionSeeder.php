<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // employees
            ['name' => 'View Employee', 'code' => 'employee.view'],
            ['name' => 'Create Employee', 'code' => 'employee.create'],
            ['name' => 'Update Employee', 'code' => 'employee.update'],
            ['name' => 'Delete Employee', 'code' => 'employee.delete'],

            // category
            ['name' => 'View Category', 'code' => 'category.view'],
            ['name' => 'Create Category', 'code' => 'category.create'],
            ['name' => 'Update Category', 'code' => 'category.update'],
            ['name' => 'Delete Category', 'code' => 'category.delete'],

            // product
            ['name' => 'View Product', 'code' => 'product.view'],
            ['name' => 'Create Product', 'code' => 'product.create'],
            ['name' => 'Update Product', 'code' => 'product.update'],
            ['name' => 'Delete Product', 'code' => 'product.delete'],

            // customer
            ['name' => 'View Customer', 'code' => 'customer.view'],
            ['name' => 'Create Customer', 'code' => 'customer.create'],
            ['name' => 'Update Customer', 'code' => 'customer.update'],
            ['name' => 'Delete Customer', 'code' => 'customer.delete'],

            // role
            ['name' => 'View Role', 'code' => 'role.view'],
            ['name' => 'Create Role', 'code' => 'role.create'],
            ['name' => 'Update Role', 'code' => 'role.update'],
            ['name' => 'Delete Role', 'code' => 'role.delete'],

            // permission
            ['name' => 'View Permission', 'code' => 'permission.view'],
            ['name' => 'Create Permission', 'code' => 'permission.create'],
            ['name' => 'Update Permission', 'code' => 'permission.update'],
            ['name' => 'Delete Permission', 'code' => 'permission.delete'],

            // order
            ['name' => 'View Order', 'code' => 'order.view'],
            ['name' => 'Create Order', 'code' => 'order.create'],
            ['name' => 'Update Order', 'code' => 'order.update'],
            ['name' => 'Delete Order', 'code' => 'order.delete'],

            // dashboard
            ['name' => 'View Dashboard', 'code' => 'dashboard.view'],
            ['name' => 'Create Dashboard', 'code' => 'dashboard.store'],
            ['name' => 'Update Dashboard', 'code' => 'dashboard.update'],
            ['name' => 'Delete Dashboard', 'code' => 'dashboard.delete'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['code' => $permission['code']],
                ['name' => $permission['name']]
            );
        }
    }
}
