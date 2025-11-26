<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // fillables matching your arrays / seeder / migration
    protected $fillable = [
        'category_id',   // relation
        'name',          // you used "name" in your arrays / seeders
        'kondisi',       // 'Baru' / 'Bekas'
        'harga',         // stored as string in your migration
        'image_link',    // default 'images/placeholder.png'
        'link',          // optional front-end link like 'product-detail.html'
    ];

    /**
     * Product -> belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Helper accessor: returns a usable public URL for the image.
     * - If image_link starts with 'images/' we assume it's in public/images/
     * - Otherwise assume it's stored via storage (storage/app/public/...), so serve via /storage/
     *
     * Usage in Blade: <img src="{{ $product->image_url }}" />
     */
    public function getImageUrlAttribute(): string
    {
        if (! $this->image_link) {
            return asset('images/placeholder.png');
        }

        // if starts with images/ it's a public file
        if (Str::startsWith($this->image_link, 'images/')) {
            return asset($this->image_link);
        }

        // otherwise assume stored in storage/app/public
        return asset('storage/' . ltrim($this->image_link, '/'));
    }
}
