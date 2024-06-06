<?php

use App\Http\Controllers\AuditDocController;
use App\Http\Controllers\AuditPlanController;
use App\Http\Controllers\AuditStandardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\UserController;
use App\Models\AuditQuesition;
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

// Route::group(['prefix' => 'audit_observation'], function () {
//     Route::get('/',[AuditDocController::class, 'index'])->name('audit_observation.index');
//     Route::get('/data',[AuditDocController::class, 'data'])->name('audit_observation.data');
//     Route::delete('/delete', [AuditDocController::class, 'delete'])->name('audit_doc.delete');
// });
// Route::get('/edit_doc/{id}', [AuditDocController::class, 'edit'])->name('edit_doc');
// Route::put('/update_doc/{id}', [AuditDocController::class, 'update'])->name('update_doc');

Route::group(['prefix' => 'audit_doc'], function () {
    Route::get('/',[AuditDocController::class, 'index'])->name('audit_doc.index');
    Route::get('/data',[AuditDocController::class, 'data'])->name('audit_doc.data');
    Route::delete('/delete', [AuditDocController::class, 'delete'])->name('audit_doc.delete');
});
Route::get('/edit_doc/{id}', [AuditDocController::class, 'edit'])->name('edit_doc');
Route::put('/update_doc/{id}', [AuditDocController::class, 'update'])->name('update_doc');

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
    Route::group(['prefix' => 'manage_standard'], function () {
        Route::group(['prefix' => 'standard_audit'], function () {
            Route::any('/', [StandardController::class, 'index'])->name('standard_audit.index');
            Route::get('/data', [StandardController::class, 'data'])->name('standard_audit.add_std');
        });
        Route::group(['prefix' => 'question_categories'], function () {
            Route::any('/', [QuestionController::class, 'question'])->name('question.index');
            Route::get('/data', [QuestionController::class, 'data'])->name('question.add_qst');
        });
    });
});