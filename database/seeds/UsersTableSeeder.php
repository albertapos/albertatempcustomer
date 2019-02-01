<?php

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User;
        $admin->fname = 'Root';
        $admin->lname = 'Admin';
        $admin->phone = '+18443322951';
        $admin->email = 'admin@test.com';
        $admin->password = bcrypt('admin');
        $admin->save();

        $vendor = new User;
        $vendor->fname = 'Vendor';
        $vendor->lname = 'Vendor';
        $vendor->phone = '+18443322951';
        $vendor->email = 'vendor@test.com';
        $vendor->password = bcrypt('vendor');
        $vendor->save();

        $salesexecutive = new User;
        $salesexecutive->fname = 'Sales Executive';
        $salesexecutive->lname = 'Sales Executive';
        $salesexecutive->email = 'sales@test.com';
        $salesexecutive->password = bcrypt('salesexecutive');
        $salesexecutive->save();

        $adminRole = Role::where('slug', 'admin')->first();
        $vendorRole = Role::where('slug', 'vendor')->first();
        $salesExecutiveRole = Role::where('slug', 'salesexecutive')->first();

        $createVendorPermission = Permission::where('slug', 'create.vendor')->first();
        $deleteVendorPermission = Permission::where('slug', 'delete.vendor')->first();
        $createSalesExecutivePermission = Permission::where('slug', 'create.senders')->first();
        $deleteSalesExecutivePermission = Permission::where('slug', 'delete.senders')->first();
        
        $admin->attachRole($adminRole);
        $vendor->attachRole($vendorRole);
        $salesexecutive->attachRole($salesExecutiveRole);

        $admin->attachPermission($createVendorPermission);
        $admin->attachPermission($deleteVendorPermission);
        $admin->attachPermission($createSalesExecutivePermission);
        $admin->attachPermission($deleteSalesExecutivePermission);

        //fake Users
        factory(User::class, 4)->create();
    }
}
