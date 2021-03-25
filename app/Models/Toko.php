<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $fillable = [
        'userId',
        'nama_pemilik',
        'nama_toko',
        'foto_ktp',
        'foto_selfie_ktp',
        'tanda_tangan',
        'lokasi_toko',
        'nama_alamat',
        'saldo_penjualan',
    ];


    protected $table = 'toko';
}
