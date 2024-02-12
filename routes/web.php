<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\admin\IndexController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\PermissionsController;

use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');




// Route::prefix('roles')->group(function () {
//     Route::get('/index', '\App\Http\Controllers\admin\RolesController@index');
// });

// Route::group(['prefix' => 'roles', 'as' => 'roles.','middleware' => ['auth']] , function(){

//     Route::get('/index', '\App\Http\Controllers\admin\RolesController@index');
// });

Route::group(['prefix' => 'roles', 'middleware' => ['auth']], function(){
    Route::get('/index', [App\Http\Controllers\admin\RolesController::class, 'index'])->name('roles.index');
    Route::get('/index_permission_list', [App\Http\Controllers\admin\RolesController::class, 'get_permission_list'])->name('roles.index_permission_list');
    Route::post('/store', [App\Http\Controllers\admin\RolesController::class, 'store'])->name('roles.store');
    Route::get('/delete/{id}', [App\Http\Controllers\admin\RolesController::class, 'delete']);
    Route::get('/edit/{id}', [App\Http\Controllers\admin\RolesController::class, 'edit'])->name('roles.compact');;
    // Route::post('/update/{id}', [App\Http\Controllers\admin\RolesController::class, 'update']);
    Route::post('/permissions', [App\Http\Controllers\admin\RolesController::class, 'givePermission']);
});

Route::group(['prefix' => 'permissions', 'middleware' => ['auth']], function(){
    Route::get('/index', [App\Http\Controllers\admin\PermissionsController::class, 'index'])->name('permissions.index');
    Route::post('/store', [App\Http\Controllers\admin\PermissionsController::class, 'store'])->name('permissions.store');
    Route::get('/delete/{id}', [App\Http\Controllers\admin\PermissionsController::class, 'delete']);
});


Route::group(['prefix' => 'users', 'middleware' => ['auth']], function(){
    Route::get('/index', [App\Http\Controllers\admin\UsersController::class, 'index'])->name('users.index');
    Route::get('/user/{id}', [App\Http\Controllers\admin\UsersController::class, 'assign_role_permission']);
    Route::post('/userr', [App\Http\Controllers\admin\UsersController::class, 'assign_roles_to_user']);
});

Route::group(['prefix' => 'drivers', 'middleware' => ['auth']], function(){
    Route::get('/add_driver', [App\Http\Controllers\DriverController::class, 'add_driver']);
    Route::post('/store_driver', [App\Http\Controllers\DriverController::class, 'store_driver']);
    Route::get('/driver_list', [App\Http\Controllers\DriverController::class, 'index'])->name('drivers.index');
    Route::get('/manage_driver_list', [App\Http\Controllers\DriverController::class, 'manage_driver_list'])->name('manage_drivers.index');
    Route::get('/edit/{id}', [App\Http\Controllers\DriverController::class, 'edit']);
    Route::post('/update_driver/{id}', [App\Http\Controllers\DriverController::class, 'update']);
    Route::get('/delete_driver/{id}', [App\Http\Controllers\DriverController::class, 'delete']);
});

Route::group(['prefix' => 'vehicles', 'middleware' => ['auth']], function(){
    Route::get('/add_vehicle', [App\Http\Controllers\VehicleController::class, 'add_vehicle']);
    Route::post('/store_vehicle', [App\Http\Controllers\VehicleController::class, 'store_vehicle']);
    Route::get('/vehicle_list', [App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/manage_vehicle_list', [App\Http\Controllers\VehicleController::class, 'manage_vehicle_list'])->name('manage_vehicles.index');
    Route::get('/edit/{id}', [App\Http\Controllers\VehicleController::class, 'edit']);
    // Route::post('/update_driver/{id}', [App\Http\Controllers\DriverController::class, 'update']);
    // Route::get('/delete_driver/{id}', [App\Http\Controllers\DriverController::class, 'delete']);
});


// Route::prefix('admin')->group(function(){
//     Route::get('/', [IndexController::class, 'index'])->name('index');
//     Route::resource('/roles', '\App\Http\Controllers\admin\RolesController@index');
//     Route::resource('/permissions', '\App\Http\Controllers\admin\PermissionsController@index');
// });


require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');







