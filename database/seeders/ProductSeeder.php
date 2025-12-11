<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Seller;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure at least one seller exists
        $seller = Seller::first() ?? Seller::create([
            'store_name'         => 'Default Store',
            'store_description'  => 'Default description',
            'pic_name'           => 'Admin',
            'pic_phone'          => '0800000000',
            'pic_email'          => 'admin@example.com',
            'pic_street'         => 'Street',
            'pic_rt'             => '01',
            'pic_rw'             => '01',
            'pic_village'        => 'Village',
            'pic_city'           => 'City',
            'pic_province'       => 'Province',
            'pic_ktp_number'     => '1111111111111111',
            'pic_photo_path'     => 'uploads/photos/default.jpg',
            'pic_ktp_file_path'  => 'uploads/ktp/default.jpg',
            'password'           => bcrypt('password'),
            'status'             => 'accepted',
        ]);

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

            // Make sure the category exists
            $category = Category::firstOrCreate(
                ['name' => $p['kategori']],
                // ['description' => $p['kategori']]
            );

            Product::create([
                'name'        => $p['name'],
                'kondisi'     => $p['kondisi'],
                'harga'       => $p['harga'],
                'category_id' => $category->id,
                'seller_id'   => $seller->id,   // ← REQUIRED
                'image_link'  => $p['image_link'],
            ]);
        }
    }
}
