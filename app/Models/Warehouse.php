<?php

namespace App\Models;

use Database\Factories\WarehouseFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\Warehouse
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ProductStock> $stocks
 * @property-read int|null $stocks_count
 * @method static WarehouseFactory factory($count = null, $state = [])
 * @method static Builder|Warehouse newModelQuery()
 * @method static Builder|Warehouse newQuery()
 * @method static Builder|Warehouse query()
 * @method static Builder|Warehouse whereCreatedAt($value)
 * @method static Builder|Warehouse whereId($value)
 * @method static Builder|Warehouse whereName($value)
 * @method static Builder|Warehouse whereUpdatedAt($value)
 * @property-read Collection<int, ProductStock> $stocks
 * @property-read Collection<int, ProductStock> $stocks
 * @property-read Collection<int, ProductStock> $stocks
 * @property-read Collection<int, ProductStock> $stocks
 * @property-read Collection<int, \App\Models\ProductStock> $stocks
 * @mixin Eloquent
 */
class Warehouse extends Model
{
    use HasFactory;

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function getSearchIndexName(): string
    {
        return 'is_in_stock_' . Str::slug($this->name);
    }
}
