<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik & Gadget',
            'Fashion & Aksesoris',
            'Kecantikan & Perawatan',
            'Rumah & Taman',
            'Olahraga & Outdoor',
            'Hobi & Mainan',
            'Otomotif',
            'Makanan & Minuman',
            'Kesehatan & Obat',
            'Digital & Layanan',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
