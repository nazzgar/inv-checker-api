<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'ean' => $this->ean,
            'sku' => $this->sku,
            'is_in_stock' => $this->is_in_stock,
            'stocks' => StockResource::collection($this->stocks),
            'authors' => AuthorResource::collection($this->authors)
        ];
    }
}
