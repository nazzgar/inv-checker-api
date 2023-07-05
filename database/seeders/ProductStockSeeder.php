<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_count = Product::all()->count();

        /**@var Collection<int, Product> $random_products */
        $random_products = DB::table('products')->inRandomOrder()->limit(round(0.1 * $product_count))->get();

        $random_products = Product::inRandomOrder()->limit(round(0.8 * $product_count))->get();


        //print($random_products);

        foreach ($random_products as $product) {

            $warehouse_count = rand(1, Warehouse::all()->count());

            $random_warehouses_id = DB::table('warehouses')->inRandomOrder()->limit($warehouse_count)->get()->pluck('id');


            $new_stocks = [];


            foreach ($random_warehouses_id as $warehouse_id) {
                $stock = rand(0, 200);
                $new_stocks[] = new ProductStock(['stock' => $stock, 'warehouse_id' => $warehouse_id]);
            }


            $product->stocks()->saveMany($new_stocks);
        }

        /*$random_products2 = DB::table('products')->inRandomOrder()->limit(round(0.8 * $product_count))->get();

        foreach ($random_products2 as $product) {
            $product->
        }*/
        //TODO: ustalić czemu $rr ma typ Model. W Product mam zdefiniowaną metodę zwracającą odpowiednią collection. IDE powinno widzieć, że elementy po których iteruje to Product
        /*foreach(Product::all() as $rr) {
            $rr-
        }*/
    }
}
