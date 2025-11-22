<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();

            // Store information
            $table->string('store_name');
            $table->text('store_description');

            // PIC (Person in Charge)
            $table->string('pic_name');
            $table->string('pic_phone');
            $table->string('pic_email')->unique();

            // Address
            $table->string('pic_street');
            $table->string('pic_rt');
            $table->string('pic_rw');
            $table->string('pic_village');
            $table->string('pic_city');
            $table->string('pic_province');

            // Documents
            $table->string('pic_ktp_number');
            $table->string('pic_photo_path');
            $table->string('pic_ktp_file_path');

            // Auth
            $table->string('password');

            // Status
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                  ->default('pending');

            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};


