<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
<<<<<<< HEAD
            'Elektronik',
            'Fashion',
            'Olahraga',
            'Aksesoris',
            'Rumah Tangga'
=======
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
>>>>>>> master
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
