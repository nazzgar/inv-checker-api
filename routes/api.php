<?php


use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


Route::name('products.')->prefix('products')->group(function () {
    Route::get('/search/{search}', [ProductController::class, 'searchAll']);
    Route::get('/{product:sku}', [ProductController::class, 'show']);
});

Route::get('/{warehouse:name}/products/{search}', [ProductController::class, 'searchAvailableAtWarehouseOnly']);
