<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Symfony\Component\Routing\Exception\RouteNotFoundException: Route [login] not defined. in file C:\Users\artyo\Desktop\test task\server\vendor\laravel\framework\src\Illuminate\Routing\UrlGenerator.php on line 479
//Illuminate\Contracts\Container\BindingResolutionException: Target class [admin] does not exist. in file C:\Users\artyo\Desktop\test task\server\vendor\laravel\framework\src\Illuminate\Container\Container.php on line 914
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/current', [UserController::class, 'currentUser']);
    Route::middleware([AdminMiddleware::class])->get('admin/users', [AdminController::class, 'users']);
    Route::middleware([AdminMiddleware::class])->patch('admin/giveAdminRole/{id}', [AdminController::class, 'giveAdminRole']);

    Route::get('location/getAll', [LocationController::class, 'getAllLocations']);
    Route::post('location/create', [LocationController::class, 'createLocation']);
    Route::delete('location/delete/{id}', [LocationController::class, 'deleteLocation']);
    Route::patch('location/update', [LocationController::class, 'updateLocation']);
});


Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/registration', [AuthController::class, 'registration']);
Route::middleware('auth:sanctum')->post('auth/logout', [AuthController::class, 'logout']);


