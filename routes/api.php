<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AlertController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [UserController::class, 'Index']);

/**Login Routes */
Route::post('adminlogin', 'LoginController@AdminLogin');
Route::get('adminlogout', 'LoginController@Adminlogout');

/** Staff Routes */
Route::get('staff', [StaffController::class, 'ViewStaff']);
Route::get('staff/{uid}', [StaffController::class, 'StaffById']);
Route::post('staff', [StaffController::class, 'AddStaff']);
Route::put('staff/{uid}', [StaffController::class, 'UpdateStaff']);
Route::delete('staff/{uid}', [StaffController::class, 'DeleteStaff']);
 
/** Alerts Routes */
Route::get('alert', [AlertController::class, 'ViewAlerts']);
Route::get('alert/{id}', [AlertController::class, 'AlertById']);
Route::post('alert', [AlertController::class, 'AddAlert']);
Route::put('alert/{id}', [AlertController::class, 'UpdateAlert']);
Route::delete('alert/{id}', [AlertController::class, 'DeleteAlert']);

/**Banner Routes */
Route::get('banner', [BannerController::class, 'ViewBanner']);
Route::get('banner/{id}', [BannerController::class, 'BannerById']);
Route::post('banner', [BannerController::class, 'AddBanner']);
Route::put('banner/{id}', [BannerController::class, 'UpdateBanner']);
Route::delete('banner/{id}', [BannerController::class, 'DeleteBanner']);