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
        Schema::create('driver', function (Blueprint $table) {
            $table->id();
            $table->string('id_driver')->unique();
            $table->timestamps();
            $table->string('nama');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('email');
            $table->string('no_telp');
            $table->string('bahasa');
            $table->string('status_driver');
            $table->string('password');
            $table->double('tarif_driver');
            $table->double('rerata_rating');
            $table->string('url_sim');
            $table->string('url_surat_bebas_napza');
            $table->string('url_surat_kesehatan_jiwa');
            $table->string('url_skck');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver');
    }
};
