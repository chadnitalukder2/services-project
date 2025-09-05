<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            //users
            'create users',
            'view users',
            'edit users',
            'delete users',

            //Permissions
            'view permissions',
            // 'create permissions',
            // 'edit permissions',
            // 'delete permissions',

             //Services
            'create services',
            'edit services',
            'view services',
            'delete services',

             //Customers
            'create customers',
            'edit customers',
            'view customers',
            'delete customers',

             //Expense Categories
            'create expense categories',
            'edit expense categories',
            'view expense categories',
            'delete expense categories',

             //Expenses
            'create expenses',
            'edit expenses',
            'view expenses',
            'delete expenses',

             //Orders
            'create orders',
            'edit orders',
            'view orders',
            'delete orders',

             //Order Items
            'create order items',
            'edit order items',
            'view order items',
            'delete order items',

             //Invoices
            'create invoices',
            'edit invoices',
            'view invoices',
            'delete invoices',

             //invoice_payments
            'create invoice payments',
            'edit invoice payments',
            'view invoice payments',
            'delete invoice payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}