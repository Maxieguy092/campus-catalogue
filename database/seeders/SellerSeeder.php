<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        // Buat seller dummy untuk testing
        Seller::create([
            'store_name' => 'Toko Utama',
            'store_description' => 'Toko utama untuk produk testing',
            'pic_name' => 'Admin Toko',
            'pic_phone' => '081234567890',
            'pic_email' => 'admin@tokotest.com',
            'pic_street' => 'Jalan Raya No. 1',
            'pic_rt' => '01',
            'pic_rw' => '01',
            'pic_village' => 'Kelurahan Test',
            'pic_city' => 'Jakarta',
            'pic_province' => 'DKI Jakarta',
            'pic_ktp_number' => '1234567890123456',
            'pic_photo_path' => 'sellers/photos/default.jpg',
            'pic_ktp_file_path' => 'sellers/ktp/default.pdf',
            'password' => Hash::make('password123'),
            'status' => 'accepted',
        ]);
    }
}
