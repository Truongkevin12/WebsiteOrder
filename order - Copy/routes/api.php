<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DebtsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\SummaryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserGroupController;
use App\Models\UsersGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('users',UserController::class);
Route::resource('setting',SettingController::class);
Route::resource('products',ProductController::class);
Route::resource('stores',StoresController::class);
Route::resource('groupusers',UserGroupController::class);
Route::resource('order',OrderController::class);
Route::resource('customers',CustomerController::class);
Route::resource('debts',DebtsController::class);
Route::resource('category',CategoryController::class);
Route::resource('status',StatusController::class);
Route::resource('summary',SummaryController::class);
