<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\OrderCancelController;
use App\Http\Controllers\OrderModifyController;
use App\Http\Controllers\OrderStatusModifyController;
use App\Http\Controllers\ShippingDataDownloadController;
use App\Http\Controllers\StockManagementController;
use App\Http\Controllers\StockHistoryListController;
use App\Http\Controllers\ShippingActualController;
use App\Http\Controllers\LoginCheckController;

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
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::controller(LoginCheckController::class)->group(function(){
    Route::get('/login_check_ng', 'index')->name('login_check_ng.index');
});

// ログインされているかチェック
Route::group(['middleware' => 'auth'], function(){
    // ステータスが問題ないかチェック
    Route::group(['middleware' => 'login.active.check'], function(){
        Route::controller(HomeController::class)->group(function(){
            Route::get('/home', 'index')->name('home.index');
        });

        Route::controller(OrderController::class)->group(function(){
            Route::get('/order', 'index')->name('order.index');
            Route::get('/order_item_search', 'search')->name('order.item_search');
            Route::get('/order_input', 'input')->name('order.input');
            Route::post('/order_confirm', 'confirm')->name('order.confirm');
            Route::post('/cart_in_ajax', 'cart_in_ajax');
            Route::post('/cart_delete_ajax', 'cart_delete_ajax');
            Route::post('/store_search_get_ajax', 'store_search_get_ajax');
            Route::post('/select_store_get_ajax', 'select_store_get_ajax');
            Route::post('/order_quantity_change_ajax', 'order_quantity_change_ajax');
        });

        Route::controller(OrderListController::class)->group(function(){
            Route::get('/order_list', 'index')->name('order_list.index');
            Route::get('/order_list_search', 'search')->name('order_list.search');
            Route::get('/order_detail', 'detail')->name('order_detail.index');
        });

        Route::controller(OrderCancelController::class)->group(function(){
            Route::get('/order_cancel', 'cancel')->name('order.cancel');
        });

        Route::controller(OrderModifyController::class)->group(function(){
            Route::get('/order_modify', 'index')->name('order_modify.index');
            Route::get('/order_modify_item_add', 'item_add')->name('order_modify.item_add');
            Route::get('/order_modify_item_add_search', 'item_add_search')->name('order_modify.item_add_search');
            Route::post('/order_modify_confirm', 'confirm')->name('order_modify.confirm');
        });

        Route::controller(StockController::class)->group(function(){
            Route::get('/stock', 'index')->name('stock.index');
            Route::get('/stock_search', 'search')->name('stock.search');
            Route::get('/stock_download', 'download')->name('stock.download');
        });

        Route::controller(MasterController::class)->group(function(){
            Route::get('/master_menu', 'index')->name('master.index');
        });

        Route::controller(ItemController::class)->group(function(){
            Route::get('/item', 'index')->name('item.index');
            Route::get('/item_search', 'search')->name('item.search');
            Route::post('/item_register_modify', 'register_modify')->name('item.register_modify');
            Route::post('/item_register', 'register')->name('item.register');
            Route::get('/item_delete', 'delete')->name('item.delete');
            Route::post('/item_info_get_ajax', 'item_info_get_ajax');
            Route::get('/item_download', 'download')->name('item.download');
        });

        Route::controller(StoreController::class)->group(function(){
            Route::get('/store', 'index')->name('store.index');
            Route::post('/store_register_modify', 'register_modify')->name('store.register_modify');
            Route::post('/store_register', 'register')->name('store.register');
            Route::get('/store_delete', 'delete')->name('store.delete');
            Route::post('/store_info_get_ajax', 'store_info_get_ajax');
            Route::get('/store_download', 'download')->name('store.download');
        });

        Route::controller(OrderStatusModifyController::class)->group(function(){
            Route::post('/order_status_modify', 'modify')->name('order_status_modify');
        });

        Route::controller(ShippingDataDownloadController::class)->group(function(){
            Route::get('/shipping_data_download', 'download')->name('shipping_data_download');
        });

        Route::controller(ShippingActualController::class)->group(function(){
            Route::get('/shipping_actual', 'index')->name('shipping_actual.index');
            Route::post('/shipping_actual_check', 'check')->name('shipping_actual.check');
            Route::get('/shipping_actual_check', 'upload')->name('shipping_actual.upload');
        });

        Route::controller(StockManagementController::class)->group(function(){
            Route::get('/stock_mgt', 'index')->name('stock_mgt.index');
            Route::get('/stock_mgt_search', 'search')->name('stock_mgt.search');
            Route::post('/stock_mgt_confirm', 'confirm')->name('stock_mgt.confirm');
        });

        Route::controller(StockHistoryListController::class)->group(function(){
            Route::get('/stock_history_list', 'index')->name('stock_history_list.index');
            Route::get('/stock_history_list_detail', 'detail')->name('stock_history_list.detail');
            Route::get('/stock_history_list_search', 'search')->name('stock_history_list.search');
            Route::get('/stock_history_data_download', 'download')->name('stock_history_data_download');
        });
    });
});