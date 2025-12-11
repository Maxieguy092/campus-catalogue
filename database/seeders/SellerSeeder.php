<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sellers')->insert([
            [
                'store_name'         => 'Warung Maju Jaya',
                'store_description'  => 'Menjual kebutuhan sehari-hari dan produk UMKM lokal.',

                'pic_name'           => 'Budi Santoso',
                'pic_phone'          => '081234567890',
                'pic_email'          => 'budi@example.com',

                'pic_street'         => 'Jl. Melati No. 12',
                'pic_rt'             => '01',
                'pic_rw'             => '02',
                'pic_village'        => 'Tlogosari',
                'pic_city'           => 'Semarang',
                'pic_province'       => 'Jawa Tengah',

                'pic_ktp_number'     => '3378123456789001',
                'pic_photo_path'     => 'uploads/photos/budi.jpg',
                'pic_ktp_file_path'  => 'uploads/ktp/budi_ktp.jpg',

                'password'           => Hash::make('password123'),

                'status'             => 'accepted',

                'created_at'         => now(),
                'updated_at'         => now(),
            ],

            [
                'store_name'         => 'Toko Sumber Rejeki',
                'store_description'  => 'Toko sembako dan perlengkapan rumah tangga.',

                'pic_name'           => 'Siti Aminah',
                'pic_phone'          => '089876543210',
                'pic_email'          => 'siti@example.com',

                'pic_street'         => 'Jl. Kenanga No. 9',
                'pic_rt'             => '03',
                'pic_rw'             => '04',
                'pic_village'        => 'Pedurungan',
                'pic_city'           => 'Semarang',
                'pic_province'       => 'Jawa Tengah',

                'pic_ktp_number'     => '3378987654321002',
                'pic_photo_path'     => 'uploads/photos/siti.jpg',
                'pic_ktp_file_path'  => 'uploads/ktp/siti_ktp.jpg',

                'password'           => Hash::make('password123'),

                'status'             => 'pending',

                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}
