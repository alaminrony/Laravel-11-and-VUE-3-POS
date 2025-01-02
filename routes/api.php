<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

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



Route::prefix('v1')->group(function () {
    // Start api for Products
    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/list',                         'index')->name('product.index');
        Route::post('/store',                       'store')->name('product.store');
        Route::put('/{id}/update',                  'update')->name('product.update');
        Route::delete('/{id}/delete',               'delete')->name('product.delete');
    });
    // End api for Products

    //Start api for Supplier
    Route::controller(SupplierController::class)->prefix('supplier')->group(function () {
        Route::get('/list',                         'index')->name('supplier.index');
        Route::post('/store',                       'store')->name('supplier.store');
        Route::put('/{id}/update',                  'update')->name('supplier.update');
        Route::delete('/{id}/delete',               'delete')->name('supplier.delete');
    });
    //End api for Supplier

});
