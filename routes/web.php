<?php

use App\Http\Controllers\AuditPlanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyAuditController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\StandardCategoryController;
use App\Http\Controllers\StandardCriteriaController;
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
    return view('home');
})->name('index');
// Route::get('/', [SendEmailController::class, 'index']);

require __DIR__ . '/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/documentation', [DashboardController::class, 'documentation'])->name('documentation');

//Audit Plan
Route::group(['prefix' => 'audit_plan'], function () {
    Route::any('/', [AuditPlanController::class, 'index'])->name('audit_plan.index');
    Route::get('/data', [AuditPlanController::class, 'data'])->name('audit_plan.data');
    Route::delete('/delete', [AuditPlanController::class, 'delete'])->name('audit_plan.delete');
    Route::any('/add', [AuditPlanController::class, 'add'])->name('audit_plan.add');
    Route::post('/approve', [AuditPlanController::class, 'approve'])->name('audit_plan.approve');
    Route::post('/revised', [AuditPlanController::class, 'revised'])->name('audit_plan.revised');
});
Route::get('/edit_audit/{id}', [AuditPlanController::class, 'edit'])->name('edit_audit');
Route::put('/update_audit/{id}', [AuditPlanController::class, 'update'])->name('update_audit');

Route::get('/get_standard_categories_id', [AuditPlanController::class, 'geStandardCategoriesById'])->name('DOC.get_standard_categories_by_id');
Route::get('/get_standard_criterias_by_id', [AuditPlanController::class, 'getStandardCriteriasById'])->name('DOC.get_standard_criterias_by_id');

Route::group(['prefix' => 'observations'], function () {
    Route::get('/', [ObservationController::class, 'index'])->name('observations.index');
    Route::get('/data', [ObservationController::class, 'data'])->name('observations.data');
    Route::get('/make/{id}', [ObservationController::class, 'make'])->name('observations.make');
    Route::any('/edit/{id}', [ObservationController::class, 'edit'])->name('observations.edit');
    Route::put('/update/{id}', [ObservationController::class, 'update'])->name('observations.update');
});

Route::group(['prefix' => 'my_audit'], function () {
    Route::get('/', [MyAuditController::class, 'index'])->name('my_audit.index');
    Route::get('/data', [MyAuditController::class, 'data'])->name('my_audit.data');
    Route::delete('/delete', [MyAuditController::class, 'delete'])->name('my_audit.delete');
    Route::get('/add/{id}', [MyAuditController::class, 'add'])->name('my_audit.add');
    Route::put('/update/{id}', [MyAuditController::class, 'update'])->name('my_audit.update');
    Route::get('/edit/{id}', [MyAuditController::class, 'edit'])->name('my_audit.edit');
    Route::put('/update_doc/{id}', [MyAuditController::class, 'update_doc'])->name('my_audit.update_doc');
    Route::get('/show/{id}', [MyAuditController::class, 'show'])->name('my_audit.show');
});

Route::middleware('auth')->group(function () {
    Route::any('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware(['can:log-viewers.read']);

Route::group(['prefix' => 'setting', 'middleware' => ['auth']], function () {
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
    //route category
    Route::group(['prefix' => 'manage_standard'], function () {
        Route::group(['prefix' => 'category'], function () {
            Route::any('/', [StandardCategoryController::class, 'category'])->name('standard_category.category');
            Route::any('/category_add', [StandardCategoryController::class, 'category_add'])->name('standard_category.category_add');
            Route::get('/data', [StandardCategoryController::class, 'data'])->name('standard_category.data');
            Route::get('/category_edit/{id}', [StandardCategoryController::class, 'category_edit'])->name('standard_category.category_edit');
            Route::put('/category_update/{id}', [StandardCategoryController::class, 'category_update'])->name('standard_category.category_update');
            Route::delete('/delete', [StandardCategoryController::class, 'delete'])->name('standard_category.delete');
        });

        //route criteria
        Route::group(['prefix' => 'criteria'], function () {
            Route::any('/', [StandardCriteriaController::class, 'criteria'])->name('standard_criteria.criteria');
            Route::get('/criteria_edit/{id}', [StandardCriteriaController::class, 'criteria_edit'])->name('standard_criteria.criteria_edit');
            Route::get('/data', [StandardCriteriaController::class, 'data'])->name('standard_criteria.data');
            Route::put('/criteria_update/{id}', [StandardCriteriaController::class, 'criteria_update'])->name('standard_criteria.criteria_update');
            Route::delete('/delete', [StandardCriteriaController::class, 'delete'])->name('standard_criteria.delete');

            // Route Indicator
            Route::get('/indicator', [StandardCriteriaController::class, 'indicator'])->name('standard_criteria.indicator');
            Route::any('/standard_criteria.indicator.create', [StandardCriteriaController::class, 'create'])->name('standard_criteria.indicator.create');
            Route::get('/data_indicator', [StandardCriteriaController::class, 'data_indicator'])->name('standard_criteria.indicator.data_indicator');
            Route::get('/show/indicator/{id}', [StandardCriteriaController::class, 'show'])->name('show.indicator');
            Route::get('/edit/indicator/{id}', [StandardCriteriaController::class, 'edit'])->name('edit.indicator');
            Route::put('/update_indicator/indicator/{id}', [StandardCriteriaController::class, 'update_indicator'])->name('update_indicator.indicator');
            Route::delete('/delete_indicator', [StandardCriteriaController::class, 'delete_indicator'])->name('delete_indicator.indicator');

            //Route Sub Indicator
            Route::get('/sub_indicator', [StandardCriteriaController::class, 'sub_indicator'])->name('standard_criteria.sub_indicator');
            Route::get('/data_sub', [StandardCriteriaController::class, 'data_sub'])->name('standard_criteria.data_sub');
            Route::get('/standard_criteria.sub_indicator.create', [StandardCriteriaController::class, 'create_sub'])->name('standard_criteria.sub_indicator.create');
            Route::post('/add/sub_indicator', [StandardCriteriaController::class, 'store_sub'])->name('store_sub.sub_indicator');
            Route::get('/edit/sub_indicator/{id}', [StandardCriteriaController::class, 'edit'])->name('edit.sub_indicator');
            Route::put('/update_sub/sub_indicator/{id}', [StandardCriteriaController::class, 'update_sub'])->name('update_sub.sub_indicator');
            Route::delete('/delete_sub', [StandardCriteriaController::class, 'delete_sub'])->name('delete_sub.sub_indicator');

            // Route::post('/add/indicator', [StandardCriteriaController::class, 'create'])->name('create.indicator');
            // Route::get('/data', [StandardCriteriaController::class, 'data'])->name('standard_criteria.data');
            // Route::get('/sub_indicator', [StandardCriteriaController::class, 'sub_indicator'])->name('standard_criteria.sub_indicator');
            // Route::get('/data/indicator/{id}', [StandardCriteriaController::class, 'data_indicator'])->name('data.indicator');
        });
    });
});
