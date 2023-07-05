<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Warehouse
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductStock> $stocks
 * @property-read int|null $stocks_count
 * @method static \Database\Factories\WarehouseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductStock> $stocks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductStock> $stocks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductStock> $stocks
 * @mixin \Eloquent
 */
class Warehouse extends Model
{
    use HasFactory;

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }
}
