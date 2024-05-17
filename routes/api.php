<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserJWTAuthController;
use App\Http\Controllers\API\AdminController;
/*===================================*/
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
/*===================================*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [UserJWTAuthController::class, 'register']);
    Route::post('login', [UserJWTAuthController::class, 'login']);
    Route::post('logout', [UserJWTAuthController::class, 'logout']);
    Route::post('refresh', [UserJWTAuthController::class, 'refresh']);
    Route::get('user-profile', [UserJWTAuthController::class, 'Profile']);
});
/*==============================================*/
// Route::middleware(['admin'])->group(function () {
// Route::group(['middleware' => 'admin'], function () {
//     Route::get('/users', [AdminController::class, 'index']);
//     Route::post('/users', [AdminController::class, 'store']);
//     Route::get('/users/{user}', [AdminController::class, 'show']);
//     Route::put('/users/{user}', [AdminController::class, 'update']);
//     Route::delete('/users/{user}', [AdminController::class, 'destroy']);
// });



Route::middleware('auth:api')->group(function () {
    Route::post('/admin/users', [AdminController::class, 'addUser']);
    Route::get('/users', [AdminController::class, 'index']);Route::get('/users', [AdminController::class, 'index']);
    Route::get('/admin/users/{id}', [AdminController::class, 'showUser']);
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
});