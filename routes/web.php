<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {

//     // return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [DashboardController::class, 'index'])
  ->middleware(['auth', 'verified'])
  ->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  //Settings
  Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
  Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
 
  //Reports
  Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

  //users
  Route::get('/users', [UserController::class, 'index'])->name('users.index');
  Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
  Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
  Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

  //permissions
  Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

  //Roles
  Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
  Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
  Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
  Route::delete('/roles', [RoleController::class, 'destroy'])->name('roles.destroy');

  //customers
  Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
  Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
  Route::post('/customers/OrderCustomerStore', [CustomerController::class, 'OrderCustomerStore'])->name('customers.OrderCustomerStore');
  Route::post('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
  Route::delete('/customers', [CustomerController::class, 'destroy'])->name('customers.destroy');

  //services
  Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
  Route::post('/services/store', [ServicesController::class, 'store'])->name('services.store');
  Route::post('/services/{id}', [ServicesController::class, 'update'])->name('services.update');
  Route::delete('/services', [ServicesController::class, 'destroy'])->name('services.destroy');

  //services
  Route::get('/service_category', [ServiceCategoryController::class, 'index'])->name('service_category.index');
  Route::post('/service_category/store', [ServiceCategoryController::class, 'store'])->name('service_category.store');
  Route::post('/service_category/{id}', [ServiceCategoryController::class, 'update'])->name('service_category.update');
  Route::delete('/service_category', [ServiceCategoryController::class, 'destroy'])->name('service_category.destroy');

  //expense_categories 
  Route::get('/expense_categories', [ExpenseCategoryController::class, 'index'])->name('expense_categories.index');
  Route::post('/expense_categories/store', [ExpenseCategoryController::class, 'store'])->name('expense_categories.store');
  Route::post('/expense_categories/{id}', [ExpenseCategoryController::class, 'update'])->name('expense_categories.update');
  Route::delete('/expense_categories', [ExpenseCategoryController::class, 'destroy'])->name('expense_categories.destroy');

  //expenses
  Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
  Route::post('/expenses/store', [ExpenseController::class, 'store'])->name('expenses.store');
  Route::post('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
  Route::delete('/expenses', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

  //Orders
  Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
  Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
  Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
  Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
  Route::post('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
  Route::delete('/orders', [OrderController::class, 'destroy'])->name('orders.destroy');
  Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update.status');

  //Invoice
  Route::post('/invoices/process-payment', [InvoiceController::class, 'processPayment'])->name('invoices.process-payment');
  Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
  Route::delete('/invoices', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
  Route::get('/invoices/{id}', [InvoiceController::class, 'viewInvoice'])->name('invoices.view');
  Route::get('/invoices/{id}/generate', [InvoiceController::class, 'generateInvoice'])->name('invoices.generate');
});

require __DIR__ . '/auth.php';
