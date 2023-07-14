<?php

namespace App\Models;

use Database\Factories\ProductStockFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductStock
 *
 * @property int $id
 * @property int $product_id
 * @property int $warehouse_id
 * @property int $stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product|null $product
 * @property-read Warehouse|null $warehouse
 * @method static ProductStockFactory factory($count = null, $state = [])
 * @method static Builder|ProductStock newModelQuery()
 * @method static Builder|ProductStock newQuery()
 * @method static Builder|ProductStock query()
 * @method static Builder|ProductStock whereCreatedAt($value)
 * @method static Builder|ProductStock whereId($value)
 * @method static Builder|ProductStock whereProductId($value)
 * @method static Builder|ProductStock whereStock($value)
 * @method static Builder|ProductStock whereUpdatedAt($value)
 * @method static Builder|ProductStock whereWarehouseId($value)
 * @mixin Eloquent
 */
class ProductStock extends Model
{
    use HasFactory;

    protected $with = ['warehouse'];

    protected $fillable = ['warehouse_id', 'stock'];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
