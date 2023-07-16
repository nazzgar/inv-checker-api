<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailedResource;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product): ProductDetailedResource
    {
        return new ProductDetailedResource($product);
    }

    public function searchAvailableAtWarehouseOnly(Warehouse $warehouse, string $search): ProductCollection
    {
        return new ProductCollection(
            Product::search($search)->where($warehouse->getSearchIndexName(), true)->paginate(15)
        );
    }

    public function searchAll(string $search): ProductCollection
    {
        return new ProductCollection(
            Product::search($search)->paginate(15)
        );
    }
}
