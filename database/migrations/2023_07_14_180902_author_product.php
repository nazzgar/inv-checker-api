<?php

use App\Models\Author;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * @link: https://laravel.com/docs/10.x/eloquent-relationships#many-to-many-table-structure
     * The author_product table is derived from the alphabetical order of the related model names
     */
    public function up(): void
    {
        Schema::create('author_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Author::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_author');
    }
};
