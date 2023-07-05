<?php


use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products/{id}', function (string $id) {
    return new ProductResource(Product::query()->findOrFail($id));
});

Route::get('/products', function () {
    return new ProductCollection(Product::all());
    //TODO: ustalić czemu to na górze działa a na dole nie
    //return ProductCollection::collection(Product::all());
});

Route::get('/search/{search}', function (string $search) {
    return Product::search($search)->get();
});


Route::get('/test', function () {
    $product_count = Product::all()->count();
    return DB::table('products')->inRandomOrder()->limit(round(0.1 * $product_count))->get();
});
