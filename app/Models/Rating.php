<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'email',
        'phone',
        'province',
        'rating',
        'comment',
    ];

    /**
     * Rating belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
