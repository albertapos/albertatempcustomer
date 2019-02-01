<?php

use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Admin Role Description', 
            'level' => 3
        ]);
        $vendorRole = Role::create([
            'name' => 'Vendor',
            'slug' => 'vendor',
            'description' => 'Vendor Role Description',
            'level' => 2
        ]);
        $salesExecutiveRole = Role::create([
            'name' => 'Sales Executive',
            'slug' => 'salesexecutive',
            'description' => 'Sales Executive Role Description', 
            'level' => 1
        ]);
        $createVendorPermission = Permission::create([
            'name' => 'Create Vendor',
            'slug' => 'create.vendor',
            'description' => 'Permission to create Vendors'
        ]);
        $deleteVendorPermission = Permission::create([
            'name' => 'Delete Vendor',
            'slug' => 'delete.vendor',
            'description' => 'Permission to create Vendors'
        ]);

        $createSalesExecutivePermission = Permission::create([
            'name' => 'Create Sales Executive',
            'slug' => 'create.salesexecutive',
            'description' => 'Permission to create Sales Executive'
        ]);
        $deleteSalesExecutivePermission = Permission::create([
            'name' => 'Delete Sales Executive',
            'slug' => 'delete.salesexecutive',
            'description' => 'Permission to create Sales Executive'
        ]);
        $role = Role::find(1);
        $role->attachPermission($createVendorPermission);
        $role->attachPermission($deleteVendorPermission);
        $role->attachPermission($createSalesExecutivePermission);
        $role->attachPermission($deleteSalesExecutivePermission);
    }
}
