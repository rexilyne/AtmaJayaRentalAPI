<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemilik_mobil', function (Blueprint $table) {
            $table->increments('id_pemilik_mobil');
            $table->timestamps();
            $table->string('status_pemilik');
            $table->string('nama');
            $table->string('no_ktp');
            $table->string('alamat');
            $table->string('no_telp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemilik_mobil');
    }
};
