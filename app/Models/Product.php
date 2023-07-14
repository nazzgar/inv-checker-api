<?php

namespace App\Models;

use App\Collections\ProductCollection;
use Database\Factories\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

/**
 * App\Models\Product
 *
 * @link https://stackoverflow.com/questions/51793756/phpstorm-cant-recognize-custom-laravel-facades
 * @link https://github.com/barryvdh/laravel-ide-helper
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $ean
 * @property string $sku
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ProductStock> $stocks
 * @property-read int|null $stocks_count
 * @method static ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereEan($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static ProductCollection<int, static> all($columns = ['*'])
 * @method static ProductCollection<int, static> get($columns = ['*'])
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory, Searchable;

    //TODO: add 'bestseller' option. Maybe the amount of sold copies in the last two months
    //TODO: add author do model and search index
    protected $appends = ['is_in_stock'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['stocks', 'authors'];

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * Get the value used to index the model.
     */
    public function getScoutKey(): string
    {
        return $this->ean;
    }

    /**
     * Get the key name used to index the model.
     */
    public function getScoutKeyName(): string
    {
        return 'ean';
    }


    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'ean' => $this->ean,
            'sku' => $this->sku,
        ];
    }


    public function getIsInStockAttribute(): bool
    {
        return $this->stocks->pluck('stock')->some(function (int $value) {
            return $value > 0;
        });
    }

    /**
     * Create a new Eloquent Collection instance.
     * @link https://martinjoo.dev/custom-eloquent-collections-in-laravel
     * @link https://laravel.com/docs/10.x/eloquent-collections#custom-collections
     * @param array<int, Model> $models
     * @return ProductCollection<int, Product>
     */
    public function newCollection(array $models = []): ProductCollection
    {
        return new ProductCollection($models);
    }
}
