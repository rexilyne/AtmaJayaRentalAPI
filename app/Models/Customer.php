<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

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
