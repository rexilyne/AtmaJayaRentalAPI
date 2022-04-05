<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $table = "penyewaan";

    protected $fillable = [
        'id_penyewaan',
        'id_pegawai',
        'id_driver',
        'id_customer',
        'id_mobil',
        'id_promo',
        'jenis_penyewaan',
        'tanggal_penyewaan',
        'tanggal_mulai_sewa',
        'tanggal_selesai',
        'tanggal_pengembalian',
        'total_harga_sewa',
        'status_penyewaan',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'total_diskon',
        'total_denda',
        'total_harga_bayar',
        'url_bukti_pembayaran',
        'rating_driver',
        'performa_driver',
        'rating_perusahaan',
        'performa_perusahaan'
    ];
}
