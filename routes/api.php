<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\TokoController;
use App\Models\Produk;
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

Route::post('reseller/register', [LoginController::class, 'api_register_reseller']);
Route::post('reseller/login', [LoginController::class, 'api_login_reseller']);
Route::post('transaction/notifhandler', [ResellerController::class, 'handle_midtrans_notifications']);
Route::get('province', [RegionController::class, 'get_provinsi']);
Route::get('city/{item:province_id}', [RegionController::class, 'get_kota']);
Route::get('subdistrict/{item:city_id}', [RegionController::class, 'get_kecamatan']);
Route::get('ongkir/{city_id}/{item:id}', [RegionController::class, 'get_ongkir']);
Route::group(['middleware' => 'auth:sanctum'], function () {
  Route::get('product/{item:id}', [ProductController::class, 'get_product_by_id']);
  Route::post('reseller/logout', [LoginController::class, 'logout_reseller']);
  Route::post('reseller/transaction/save', [ResellerController::class, 'save_transaction']);
  Route::get('reseller/transactions', [ResellerController::class, 'get_all_transactions']);
  Route::get('reseller/transaction/detail/{id_pesanan}', [ResellerController::class, 'get_detail_transaction']);
  Route::get('reseller/transaction/action/{action}/{id_pesanan}', [ResellerController::class, 'process_transaction']);
  Route::get('reseller/profile/details', [ResellerController::class, 'get_user_details']);
  Route::post('reseller/profile/edit', [ResellerController::class, 'edit_profile']);
  Route::post('reseller/profile/uploadphoto', [ResellerController::class, 'upload_profile_pic']);
});

