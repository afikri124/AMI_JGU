<?php

use App\Http\Controllers\AuditPlanController;
use App\Http\Controllers\AuditPlanStatusController;
use App\Http\Controllers\NotificationAuditController;
use App\Http\Controllers\AuditStandardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Audit Plan
Route::group(['prefix' => 'audit_plan'], function () {
    Route::any('/',[AuditPlanController::class, 'index'])->name('audit_plan.index');
    Route::get('/data',[AuditPlanController::class, 'data'])->name('audit_plan.data');
    Route::delete('/delete', [AuditPlanController::class, 'delete'])->name('audit_plan.delete');
});
Route::get('/edit_audit/{id}', [AuditPlanController::class, 'edit'])->name('edit_audit');
Route::put('/update_audit/{id}', [AuditPlanController::class, 'update'])->name('update_audit');

//Audit Plan Status
Route::group(['prefix' => 'audit_status'], function () {
    Route::get('/',[AuditPlanStatusController::class, 'index'])->name('audit_status.index');
    Route::get('/data',[AuditPlanStatusController::class, 'data'])->name('audit_status.data');
});

Route::group(['prefix' => 'notif_audit'], function () {
    Route::any('/', [NotificationAuditController::class, 'index'])->name('notification.index')->middleware('auth');
    Route::get('/data', [NotificationAuditController::class, 'data'])->name('notification.data');
    Route::delete('/delete', [NotificationAuditController::class, 'delete'])->name('notification.delete');
    Route::get('/edit/{id}', [NotificationAuditController::class, 'edit'])->name('notification.edit');
    Route::put('/update/{id}', [NotificationAuditController::class, 'update'])->name('notification.update');
});


Route::middleware('auth')->group(function () {
    Route::any('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware(['can:log-viewers.read']);

Route::group(['prefix' => 'setting','middleware' => ['auth']],function () {
    Route::group(['prefix' => 'manage_account'], function () {
        Route::group(['prefix' => 'users'], function () { //route to manage users
            Route::any('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/data', [UserController::class, 'data'])->name('users.data');
            Route::any('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::any('/reset_password/{id}', [UserController::class, 'reset_password'])->name('users.reset_password');
            Route::delete('/delete', [UserController::class, 'delete'])->name('users.delete');
        });
        Route::group(['prefix' => 'roles'], function () { //route to manage roles
            Route::any('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/data', [RoleController::class, 'data'])->name('roles.data');
            Route::any('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::delete('/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');
        });
        Route::group(['prefix' => 'permissions'], function () { //route to manage permissions
            Route::any('/', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/data', [PermissionController::class, 'data'])->name('permissions.data');
            Route::get('/view/{id}', [PermissionController::class, 'view'])->name('permissions.view');
            Route::get('/view/{id}/users', [PermissionController::class, 'view_users_data'])->name('permissions.view_users_data');
            Route::get('/view/{id}/roles', [PermissionController::class, 'view_roles_data'])->name('permissions.view_roles_data');
        });
    });
    Route::group(['prefix' => 'standard_audit'], function () {
        Route::get('/',[AuditStandardController::class, 'index'])->name('standard_audit.index');
        Route::any('/add_qst',[AuditStandardController::class, 'add_qst'])->name('standard_audit.add_qst');
    });
    Route::group(['prefix' => 'departement'], function () {
        Route::any('/', [DepartmentController::class, 'index'])->name('departement.index');
    });
});

