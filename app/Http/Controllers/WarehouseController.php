<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Str;

class WarehouseController extends Controller
{

    /**
     * Show available products on specified warehouse
     */
    public function searchInAvailableInWarehouseOnly(Warehouse $warehouse, string $search)
    {
        /*return new ProductCollection(Product::search($search)->whereHas('stocks', function($query) using ($warehouse){
            $query->where('name', '=', $warehouse->name);
        })->paginate(15));*/
        //TODO: poprawić poniższe zapytanie
        // https://laravel.com/docs/10.x/scout#configuring-filterable-data-for-meilisearch
        /*return new ProductCollection(Product::whereHas('stocks', function ($query) use ($warehouse) {
            $query->whereHas('warehouse', function ($query) use ($warehouse) {
                $query->where('name', '=', $warehouse->name);
            });
        })->paginate(15));*/

        /*return Product::search($search)
            ->query(function ($query) use ($warehouse) {
                $query->whereHas('stocks', function ($query) use ($warehouse) {
                    $query->where('stock', '>', 0)->where('warehouse_id', '=', $warehouse->id);
                });
            })->get()->count();*/

        //Paginacja nie dziala, rozne ilosci na kazdej stronie. Inaczej należy filtrowac po stocku na magazynie
        //Moze oddzielny indeks dla kazdego sklepu?
        //mooze taka kolejnosc: Product::search()->get()->where....
        //albo filtry "filter": "'in stock warszawa' = true", "'in stock krakow' = true"
        /*return new ProductCollection(
            Product::search($search)
                ->query(function ($query) use ($warehouse) {
                    $query->whereHas('stocks', function ($query) use ($warehouse) {
                        $query->where('stock', '>', 0)->where('warehouse_id', '=', $warehouse->id);
                    });
                })->paginate(15));*/

        /*return new ProductCollection(
            Product::search($search)->get()->filter(function ($product) use ($warehouse) {
                return $product->isInStockAtWarehouse($warehouse);
            })
        );*/

        return new ProductCollection(
            Product::search($search)->where($warehouse->getSearchIndexName(), true)->paginate(15)
        );


    }
}
