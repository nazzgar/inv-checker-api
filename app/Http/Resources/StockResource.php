<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * another approach: setting relationships manualy to counteract lazy loading many records
     * @link https://freek.dev/2311-increase-performance-by-using-eloquents-setrelation-method
     */
    public function toArray(Request $request): array
    {
        return [
            'stock' => $this->stock,
            'warehouse' => $this->warehouse->name
        ];
    }
}
