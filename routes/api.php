<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
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

/** Staff Routes */
Route::get('viewstaff', [StaffController::class, 'ViewStaff']);
Route::get('viewstaff/{id}', [StaffController::class, 'StaffById']);
Route::post('addstaff', [StaffController::class, 'AddStaff']);
Route::put('updatestaff/{id}', [StaffController::class, 'UpdateStaff']);
Route::delete('deletestaff/{id}', [StaffController::class, 'DeleteStaff']);
 
/** Alerts Routes */
Route::get('viewalerts', [AlertController::class, 'ViewAlerts']);
Route::get('viewalert/{id}', [AlertController::class, 'AlertById']);
Route::post('addalert', [AlertController::class, 'AddAlert']);
Route::put('updatealert/{id}', [AlertController::class, 'UpdateAlert']);
Route::delete('deletealert/{id}', [AlertController::class, 'DeleteAlert']);

/**Banner Routes */
Route::get('viewbanner', [BannerController::class, 'ViewBanner']);
Route::get('viewbanner/{id}', [BannerController::class, 'BannerById']);
Route::post('addbanner', [BannerController::class, 'AddBanner']);
Route::put('updatebanner/{id}', [BannerController::class, 'UpdateBanner']);
Route::delete('deletebanner/{id}', [BannerController::class, 'DeleteBanner']);