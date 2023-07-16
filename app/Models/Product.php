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
use Illuminate\Support\Str;
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
 * @property-read Collection<int, Author> $authors
 * @property-read int|null $authors_count
 * @property-read bool $is_in_stock
 * @property-read Collection<int, ProductStock> $stocks
 * @method static ProductCollection<int, static> all($columns = ['*'])
 * @method static ProductCollection<int, static> get($columns = ['*'])
 * @property-read Collection<int, \App\Models\Author> $authors
 * @property-read Collection<int, \App\Models\ProductStock> $stocks
 * @method static ProductCollection<int, static> all($columns = ['*'])
 * @method static ProductCollection<int, static> get($columns = ['*'])
 * @property-read Collection<int, \App\Models\Author> $authors
 * @property-read Collection<int, \App\Models\ProductStock> $stocks
 * @method static ProductCollection<int, static> all($columns = ['*'])
 * @method static ProductCollection<int, static> get($columns = ['*'])
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory, Searchable;

    //TODO: add 'bestseller' option. Maybe the amount of sold copies in the last two months
    protected $appends = [
        'is_in_stock',
        'is_in_stock_warszawa',
        'is_in_stock_krakow',
        'is_in_stock_wroclaw',
        'is_in_stock_gdynia',
        'is_in_stock_poznan'
    ];

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

    //https://stackoverflow.com/questions/67895460/laravel-scout-meilisearch-filter-by-a-non-searchable-column
    public function isInStockAtWarehouse(Warehouse|int $warehouse): bool
    {
        if (is_int($warehouse)) {
            return !$this->stocks()->where('warehouse_id', $warehouse)->get()->isEmpty();
        }


        return !$this->stocks()->whereHas('warehouse', function ($query) use ($warehouse) {
            $query->where('name', '=', $warehouse->name);
        })->get()->isEmpty();
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

        $base = [
            'name' => $this->name,
            'ean' => $this->ean,
            'sku' => $this->sku,
            'authors.name' => $this->authors->pluck('name'),
        ];

        $stocks_all = Warehouse::all()->mapWithKeys(function (Warehouse $warehouse) {
            return [$warehouse->getSearchIndexName() => false];
        })->toArray();

        $stocks_available = ($this->stocks)->filter(fn(ProductStock $stock) => $stock->stock > 0)
            ->mapWithKeys(function (ProductStock $stock, int $key) {
                return [$stock->warehouse->getSearchIndexName() => true];
            })->toArray();

        return array_merge($base, $stocks_all, $stocks_available);

    }

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     * TODO: Spójrz na to, to chyba nie jest potrzebne
     * @link https://laravel.com/docs/10.x/scout#modifying-the-import-query
     */
    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with(['authors', 'stocks']);
    }

    /**
     * Modify the collection of models being made searchable.
     */
    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load(['authors', 'stocks']);
    }


    public function getIsInStockAttribute(): bool
    {
        return $this->stocks->pluck('stock')->some(function (int $value) {
            return $value > 0;
        });
    }

    /*    public function getIsInStockWarszawaAttribute(): bool
        {
            return $this->isInStockAtWarehouse(1);
        }

        public function getIsInStockKrakowAttribute(): bool
        {
            return $this->isInStockAtWarehouse(2);
        }

        public function getIsInStockWroclawAttribute(): bool
        {
            return $this->isInStockAtWarehouse(3);
        }

        public function getIsInStockGdyniaAttribute(): bool
        {
            return $this->isInStockAtWarehouse(4);
        }

        public function getIsInStockPoznanAttribute(): bool
        {
            return $this->isInStockAtWarehouse(5);
        }*/

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
