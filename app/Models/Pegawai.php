<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Pegawai extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = "pegawai";
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'status_akun',
        'id_role',
        'nama',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'email',
        'no_telp',
        'password',
        'url_foto'
    ];
}
