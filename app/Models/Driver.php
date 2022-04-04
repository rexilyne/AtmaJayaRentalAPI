<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = "driver";
    protected $primaryKey = 'id_driver';

    protected $fillable = [
        'id_driver',
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
