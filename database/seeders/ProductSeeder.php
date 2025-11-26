<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                "name" => "Veni",
                "kondisi" => "Baru",
                "harga" => "Rp60,000",
                "kategori" => "Elektronik",
                "image_link" => "images/placeholder.png",
            ],
            [
                "name" => "Thus Spake Zarathustra",
                "kondisi" => "Bekas",
                "harga" => "Rp120,000",
                "kategori" => "Elektronik",
                "image_link" => "images/placeholder.png",
            ],
            [
                "name" => "Beyond Good and Evil",
                "kondisi" => "Baru",
                "harga" => "Rp150,000",
                "kategori" => "Elektronik",
                "image_link" => "images/placeholder.png",
            ],
            [
                "name" => "The Gay Science",
                "kondisi" => "Bekas",
                "harga" => "Rp120,000",
                "kategori" => "Elektronik",
                "image_link" => "images/placeholder.png",
            ],
        ];

        foreach ($products as $p) {
            $category = Category::where('name', $p['kategori'])->first();

            Product::create([
                'name'        => $p['name'],
                'kondisi'     => $p['kondisi'],
                'harga'       => $p['harga'],
                'category_id' => $category->id,
                'image_link'  => $p['image_link'],
            ]);
        }
    }
}
