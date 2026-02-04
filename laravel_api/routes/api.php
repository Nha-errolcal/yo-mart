<?php
use App\Http\Controllers\OrderDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;

Route::prefix('v2')->middleware(['validateToken'])->group(function () {
    // Authenticated routes
    Route::post('/profile', [AuthController::class, 'profile']);
    Route::get('/user', [AuthController::class, 'getUserAll']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ========== employees ==========
    Route::get('/employees', [EmployeesController::class, 'index'])->middleware('permission:employee.view');
    Route::post('/employees', [EmployeesController::class, 'store'])->middleware('permission:employee.create');
    Route::get('/employees/{employee}', [EmployeesController::class, 'show'])->middleware('permission:employee.view');
    Route::put('/employees/{employee}', [EmployeesController::class, 'update'])->middleware('permission:employee.update');
    Route::delete('/employees/{employee}', [EmployeesController::class, 'destroy'])->middleware('permission:employee.delete');

    Route::apiResource('/category', CategoryController::class)->middleware([
        'index' => 'permission:category.view',
        'store' => 'permission:category.create',
        'show' => 'permission:category.view',
        'update' => 'permission:category.update',
        'destroy' => 'permission:category.delete',
    ]);
    Route::apiResource('/product', ProductController::class)->middleware([
        'index' => 'permission:product.view',
        'store' => 'permission:product.create',
        'show' => 'permission:product.view',
        'update' => 'permission:product.update',
        'destroy' => 'permission:product.delete',
    ]);
    Route::apiResource('/customer', CustomerController::class)->middleware([
        'index' => 'permission:customer.view',
        'store' => 'permission:customer.create',
        'show' => 'permission:customer.view',
        'update' => 'permission:customer.update',
        'destroy' => 'permission:customer.delete',
    ]);
    Route::apiResource('/role', RoleController::class);
    Route::apiResource('/payments', PaymentMethodController::class)->middleware([
        'index' => 'permission:payment.view',
        'store' => 'permission:payment.create',
        'show' => 'permission:payment.view',
        'update' => 'permission:payment.update',
        'destroy' => 'permission:payment.delete',
    ]);
    Route::apiResource('/order', OrderController::class)->middleware([
        'index' => 'permission:order.view',
        'store' => 'permission:order.create',
        'show' => 'permission:order.view',
        'update' => 'permission:order.update',
        'destroy' => 'permission:order.delete',
    ]);
    Route::apiResource('/dashboard', DashboardController::class)->middleware([
        'index' => 'permission:dashboard.view',
        'store' => 'permission:dashboard.store',
        'show' => 'permission:dashboard.view',
        'update' => 'permission:dashboard.update',
        'destroy' => 'permission:dashboard.delete',
    ]);
    Route::apiResource('/order_detail', OrderDetailController::class)->middleware([
        'index' => 'permission:order_detail.view',
        'store' => 'permission:order_detail.create',
        'show' => 'permission:order_detail.view',
        'update' => 'permission:order_detail.update',
        'destroy' => 'permission:order_detail.delete',
    ]);
    Route::apiResource('/permission', PermissionController::class)->middleware([
        'index' => 'permission:permission.view',
        'store' => 'permission:permission.create',
        'show' => 'permission:permission.view',
        'update' => 'permission:permission.update',
        'destroy' => 'permission:permission.delete',
    ]);
    Route::post('/role/{roleId}/sync-permissions', [RoleController::class, 'syncPermissions']);
    Route::post('/users/{userId}/sync-roles', [AuthController::class, 'syncRoles']);


});

// public routes
Route::prefix('v2')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
