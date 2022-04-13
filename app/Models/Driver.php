<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Driver extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = "driver";

    protected $fillable = [
        'id_driver',
        'status_akun',
        'nama',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'email',
        'no_telp',
        'bahasa',
        'status_driver',
        'password',
        'tarif_driver',
        'rerata_rating',
        'url_sim',
        'url_surat_bebas_napza',
        'url_surat_kesehatan_jiwa',
        'url_skck'
    ];
}
