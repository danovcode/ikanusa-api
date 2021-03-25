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
            $table->id();
            $table->integer('harga');
            $table->string('nama');
            $table->integer('stok');
            $table->string('kondisi')->unique();
            $table->integer('minimal');
            $table->string('deskripsi');
            $table->string('image');
            $table->integer('tokoId');
            $table->string('status');
            $table->integer('user_id');
            $table->boolean('accepted')->default(0);
            $table->integer('nelayanId')->nullable();
            $table->time('expired_on');
            $table->string('is_active')->default('Y');
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
