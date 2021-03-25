<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'harga', 'nama','kondisi','minimal', 'deskripsi', 'stok', 'tokoId', 'status', 'image', 'user_id', 'expired_on'
    ];


    protected $table = 'product';

}
