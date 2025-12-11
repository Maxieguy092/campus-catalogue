<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends Authenticatable
{
    use HasFactory;

    protected $table = 'sellers';

    protected $fillable = [
        'store_name',
        'store_description',
        'pic_name',
        'pic_phone',
        'pic_email',
        'pic_street',
        'pic_rt',
        'pic_rw',
        'pic_village',
<<<<<<< HEAD
=======
        'pic_kecamatan',
>>>>>>> master
        'pic_city',
        'pic_province',
        'pic_ktp_number',
        'pic_photo_path',
        'pic_ktp_file_path',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

<<<<<<< HEAD
=======
    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

>>>>>>> master
    public function toArray()
    {
        return [
            'id' => $this->id,
            'storeName' => $this->store_name,
            'storeDescription' => $this->store_description,
            'picName' => $this->pic_name,
            'picPhone' => $this->pic_phone,
            'picEmail' => $this->pic_email,
            'picStreet' => $this->pic_street,
            'picRT' => $this->pic_rt,
            'picRW' => $this->pic_rw,
            'picVillage' => $this->pic_village,
            'picCity' => $this->pic_city,
            'picProvince' => $this->pic_province,
            'picKtpNumber' => $this->pic_ktp_number,
            'picPhotoPath' => $this->pic_photo_path,
            'picKtpFilePath' => $this->pic_ktp_file_path,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
