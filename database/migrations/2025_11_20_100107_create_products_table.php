<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * [
     *      "name" => "Produk 3",
     *      "kondisi" => "Baru",
     *      "harga" => "Rp150,000",
     *      "kategori" => "Elektronik" -> relation to category table,
     *      "image_link" => "images/placeholder.png",
     *      "link" => "product-detail.html"
     *  ],
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->enum('kondisi', ['Baru', 'Bekas'])->default('Baru');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('harga');
            $table->string('image_link')->default('images/placeholder.png');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
