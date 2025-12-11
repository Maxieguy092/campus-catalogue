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
<<<<<<< HEAD
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
=======
            ['Laptop Pro 15', 'Laptop high-end untuk kebutuhan profesional.', 15000000, 5, 'laptoppro15.jpg', 1],
            ['Smartphone X', 'Smartphone flagship dengan fitur terbaru.', 8000000, 10, 'smartphonex.jpg', 1],
            ['Jaket Hoodie', 'Jaket hoodie nyaman untuk gaya kasual.', 350000, 20, 'hoodie.jpg', 2],
            ['Lipstik Matte', 'Lipstik matte tahan lama dan warna cerah.', 120000, 30, 'lipstik.jpg', 3],
            ['Set Alat Taman', 'Perlengkapan taman lengkap untuk rumah.', 250000, 15, 'alat_taman.jpg', 4],
            ['Sepatu Lari', 'Sepatu lari ringan dan nyaman.', 500000, 12, 'sepatu_lari.jpg', 5],
            ['Mainan Robot', 'Mainan robot edukatif untuk anak.', 180000, 25, 'robot.jpg', 6],
            ['Oli Motor', 'Oli motor kualitas terbaik.', 90000, 40, 'oli.jpg', 7],
            ['Coklat Premium', 'Coklat premium rasa lezat.', 75000, 50, 'coklat.jpg', 8],
            ['Vitamin C', 'Suplemen vitamin C untuk daya tahan tubuh.', 60000, 60, 'vitamin_c.jpg', 9],
            ['Paket Internet', 'Paket internet bulanan murah.', 100000, 100, 'internet.jpg', 10],
        ];

        foreach ($products as $p) {
            Product::create([
                'name'          => $p[0],
                'description'   => $p[1],
                'kondisi'       => 'Baru',
                'harga'         => $p[2],
                'stock'         => $p[3],
                'category_id'   => $p[5],
                'image_link'    => $p[4],
                'seller_id'     => 1, // Default seller
>>>>>>> master
            ]);
        }
    }
}
