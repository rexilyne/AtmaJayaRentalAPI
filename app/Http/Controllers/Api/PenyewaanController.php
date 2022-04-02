<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Penyewaan;

class PenyewaanController extends Controller
{
    //
    public function index() {
        $penyewaans = Penyewaan::all();

        if(count($penyewaans) > 0) {
            return response([
                'message' => 'Retreive All Success',
                'data' => $penyewaans
            ], 200);

            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
    }

    public function show($id) {
        $penyewaan = Penyewaan::find($id);

        if(!is_null($penyewaan)) {
            return response([
                'message' => 'Retrieve Penyewaan Success',
                'data' => $penyewaan
            ], 200);
        }

        return response([
            'message' => 'Penyewaan Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $penyewaan = Penyewaan::create($storeData);
        
        return response([
            'message' => 'Add Penyewaan Success',
            'data' => $penyewaan
        ], 200);
    }

    public function destroy($id) {
        $penyewaan = Penyewaan::find($id);

        if(is_null($penyewaan)) {
            return response([
                'message' => 'Penyewaan Not Found',
                'data' => null
            ], 404);
        }

        if($penyewaan->delete()) {
            return response([
                'message' => 'Delete Penyewaan Success',
                'data' => $penyewaan
            ], 200);
        }

        return response([
            'message' => 'Delete Penyewaan Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id) {
        $penyewaan = Penyewaan:: find($id);

        if(is_null($penyewaan)) {
            return response([
                'message' => 'Penyewaan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $penyewaan->nama = $updateData['nama'];

        $penyewaan->id_pegawai = $updateData['id_pegawai'];
        $penyewaan->id_driver = $updateData['id_driver'];
        $penyewaan->id_customer = $updateData['id_customer'];
        $penyewaan->id_mobil = $updateData['id_mobil'];
        $penyewaan->id_promo = $updateData['id_promo'];
        $penyewaan->jenis_penyewaan = $updateData['jenis_penyewaan'];
        $penyewaan->tanggal_penyewaan = $updateData['tanggal_penyewaan'];
        $penyewaan->tanggal_mulai_sewa = $updateData['tanggal_mulai_sewa'];
        $penyewaan->tanggal_selesai = $updateData['tanggal_selesai'];
        $penyewaan->tanggal_pengembalian = $updateData['tanggal_pengembalian'];
        $penyewaan->total_harga_sewa = $updateData['total_harga_sewa'];
        $penyewaan->status_penyewaan = $updateData['status_penyewaan'];
        $penyewaan->tanggal_pembayaran = $updateData['tanggal_pembayaran'];
        $penyewaan->metode_pambayaran = $updateData['metode_pambayaran'];
        $penyewaan->total_diskon = $updateData['total_diskon'];
        $penyewaan->total_denda = $updateData['total_denda'];
        $penyewaan->total_harga_bayar = $updateData['total_harga_bayar'];
        $penyewaan->url_bukti_pembayaran = $updateData['url_bukti_pembayaran'];
        $penyewaan->rating_driver = $updateData['rating_driver'];
        $penyewaan->performa_driver = $updateData['performa_driver'];
        $penyewaan->rating_perusahaan = $updateData['rating_perusahaan'];
        $penyewaan->performa_perusahaan = $updateData['performa_perusahaan'];

        if($penyewaan->save()) {
            return response([
                'message' => 'Update Penyewaan Success',
                'data' => $penyewaan
            ], 200);
        }

        return response([
            'message' => 'Update Penyewaan Failed',
            'data' => null
        ], 400);
    }
}
