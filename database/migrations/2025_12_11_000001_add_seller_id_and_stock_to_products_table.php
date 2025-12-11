<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add seller_id and stock to products table
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add seller_id (foreign key to sellers)
            $table->foreignId('seller_id')
                  ->nullable()
                  ->constrained('sellers')
                  ->cascadeOnDelete();
            
            // Add stock field
            $table->integer('stock')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // SQLite doesn't support dropping foreign keys easily, so we'll just drop the columns
        // and let the foreign key constraint be ignored
        Schema::table('products', function (Blueprint $table) {
            // For SQLite, we need to handle this differently
            if (DB::getDriverName() === 'sqlite') {
                // SQLite doesn't support dropping columns with constraints directly
                // So we'll just skip the rollback or handle manually
                return;
            }
            
            $table->dropForeignIdFor('Seller');
            $table->dropColumn(['seller_id', 'stock']);
        });
    }
};


