<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    //All api for Products
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/',                             'index')->name('product.index');
        Route::post('/store',                       'store')->name('product.store');
        Route::put('/{id}/update',                  'update')->name('product.update');
        Route::delete('/{id}/delete',               'destroy')->name('product.destroy');
    });
});
