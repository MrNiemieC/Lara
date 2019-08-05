<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'status-list',
            'orders-list',
            'orders-create',
            'orders-filter-employee',
            'orders-filter-client',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'address-list',
            'address-create',
            'address-edit',
            'address-delete',
            'orders-edit',
            'orders-delete',
            'orders-status',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
