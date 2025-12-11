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
        'seller_id',     // relation
        'name',          // you used "name" in your arrays / seeders
        'kondisi',       // 'Baru' / 'Bekas'
        'harga',         // stored as string in your migration
        'image_link',    // image file path
        'stock',         // stock quantity
        'description',   // product description
    ];

    /**
     * Product -> belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product -> belongs to Seller
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Product -> has many Ratings
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Helper: Get average rating
     */
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    /**
     * Helper: Get rating count
     */
    public function getRatingCountAttribute()
    {
        return $this->ratings()->count();
    }

    /**
     * Helper accessor: returns a usable public URL for the image.
     * - If image_link is empty or null, return placeholder
     * - If image_link starts with 'http', it's an external URL (legacy)
     * - Otherwise assume it's stored in storage/app/public/products/
     *
     * Usage in Blade: <img src="{{ $product->image_url }}" />
     */
    public function getImageUrlAttribute(): string
    {
        if (! $this->image_link) {
            return asset('images/placeholder.png');
        }

        // if starts with http/https it's an external URL (legacy)
        if (Str::startsWith($this->image_link, ['http://', 'https://'])) {
            return $this->image_link;
        }

        // if starts with images/ it's a public file
        if (Str::startsWith($this->image_link, 'images/')) {
            return asset($this->image_link);
        }

        // otherwise assume stored in storage/app/public/products
        return asset('storage/products/' . ltrim($this->image_link, '/'));
    }
}

