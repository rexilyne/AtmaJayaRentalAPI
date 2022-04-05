<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customer";

    protected $fillable = [
        'id_customer',
        'status_akun',
        'nama',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'email',
        'no_telp',
        'password',
        'url_sim',
        'url_kartu_identitas'
    ];
}
