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
            //reports
            'view customer report',
            'view service report',
            'view order report',
            'view expense report',
            'view invoice report',
            'view profit loss report',

            //roles
            'create roles',
            'view roles',
            'edit roles',
            'delete roles',

            //users
            'create users',
            'view users',
            'edit users',
            'delete users',

            //Permissions
            'view permissions',

            //Customers
            'create customers',
            'edit customers',
            'view customers',
            'delete customers',

            //service category
            'create service category',
            'edit service category',
            'view service category',
            'delete service category',

            //Services
            'create services',
            'edit services',
            'view services',
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

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
