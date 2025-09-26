<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view dashboard',
            'view settings',
            //reports
            'view customer report',
            'view service report',
            'view order report',
            'view expense report',
            'view invoice report',
            'view profit loss report',
            

            //roles
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            //users
            'view users',
            'create users',
            'edit users',
            'delete users',

            //Customers
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            //service category
            'view service category',
            'create service category',
            'edit service category',
            'delete service category',

            //Services
            'view services',
            'create services',
            'edit services',
            'delete services',

            //Expense Categories
            'view expense categories',
            'create expense categories',
            'edit expense categories',
            'delete expense categories',

            //Expenses
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',

            //Orders
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',

            //Invoices
            'view invoices',
            'payment invoices',
            'view permissions',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
