<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;


    // fillable exactly like your seed/sample: only 'name'
    protected $fillable = [
        'name',
    ];

    /**
     * Category -> many Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
