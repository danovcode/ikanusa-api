<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Toko extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toko', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('nama_pemilik');
            $table->string('nama_toko');
            $table->string('foto_ktp');
            $table->string('foto_selfie_ktp');
            $table->string('tanda_tangan');
            $table->string('lokasi_toko');
            $table->string('nama_alamat');
            $table->integer('saldo_penjualan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
