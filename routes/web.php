<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('experiment', function () {
  return view('bs-experiment', [
    'title' => 'Bootstrap experiment'
  ]);
});
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'goLogin'])->middleware('throttle:login');
Route::group(['middleware' => ['auth:admin']], function ()
{
  Route::get('home', [HomeController::class, 'index']);
  Route::get('/', [HomeController::class, 'index']);
  Route::get('product', [ProductController::class, 'index']);
  Route::get('product/{item:id}', [ProductController::class, 'detail']);
  Route::get('product/edit/{item:id}', [ProductController::class, 'view_edit']);
  Route::post('product/edit', [ProductController::class, 'edit']);
  Route::post('shop/savetransaction', [TokoController::class, 'save_transaction']);
  Route::get('history', [TokoController::class, 'history']);
  Route::get('json/history/{item:id}', [TokoController::class, 'json_detail_history']);
  Route::get('json/history', [TokoController::class, 'json_all_history']);
  Route::get('json/chart/history/{year}/{month}', [TokoController::class, 'json_chart_history']);
  Route::get('json/reseller', [ResellerController::class, 'json_all_reseller']);
  Route::get('json/restock', [ResellerController::class, 'json_all_restock']);
  Route::get('json/restockbystatus/{status}', [ResellerController::class, 'json_restock']);
  Route::get('json/notifications', [TokoController::class, 'json_get_notif']);
  Route::get('json/notifications/countunread', [TokoController::class, 'json_count_notif']);
  Route::get('reseller', [ResellerController::class, 'index']);
  Route::get('reseller/detail/{item:id}', [ResellerController::class, 'view_reseller_detail']);
  Route::get('restock', [ResellerController::class, 'view_restock']);
  Route::get('restock/detail/{item:id_pesanan}', [ResellerController::class, 'view_restock_detail']);
  Route::post('restock/inputresi', [ResellerController::class, 'input_resi']);
  Route::get('report', [TokoController::class, 'view_report']);
  Route::get('logout', [LoginController::class, 'logout_admin']);
});
Route::get('artisan/websockets', function () {
  Artisan::call('websockets:serve');
  return 'Websocket server is running.';
});
Route::get('artisan/cache/config', function () {
  Artisan::call('config:cache');
  return 'Config cache created.';
});
Route::get('artisan/cache/view', function () {
  Artisan::call('view:cache');
  return 'View cache created.';
});
Route::get('json/orderid/generate', [ResellerController::class, 'generate_order_id']);