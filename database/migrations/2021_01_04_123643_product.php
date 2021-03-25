<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $tabsle->id();
            $table->integer('harga');
            $table->string('nama');
            $table->integer('stok');
            $table->string('kondisi')->unique();
            $table->integer('minimal');
            $table->string('deskripsi');
            $table->integer('tokoId');
            $table->string('status');
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
