<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mobil;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MobilController extends Controller
{
    //
    public function index() {
        $mobils = Mobil::all();

        if(count($mobils) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $mobils
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id) {
        $mobil = Mobil::find($id);

        if(!is_null($mobil)) {
            return response([
                'message' => 'Retrieve Mobil Success',
                'data' => $mobil
            ], 200);
        }

        return response([
            'message' => 'Mobil Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $storeData['status_mobil'] = 'Aktif';
        $validate = null;
        if($storeData['kategori_aset'] === "Aset Mitra") {
            $validate = Validator::make($storeData, [
                'status_mobil' => 'required',
                'id_pemilik_mobil' => 'required',
                'nama_mobil' => 'required',
                'tipe_mobil' => 'required',
                'jenis_transmisi' => 'required',
                'jenis_bahan_bakar' => 'required',
                'warna_mobil' => 'required',
                'volume_bagasi' => 'required',
                'fasilitas' => 'required',
                'kapasitas_penumpang' => 'required|numeric',
                'plat_nomor' => 'required',
                'nomor_stnk' => 'required',
                'kategori_aset' => 'required',
                'harga_sewa' =>'required|numeric',
                'status_sewa' => 'required',
                'tanggal_terakhir_kali_servis' => 'required|date',
                'periode_kontrak_mulai' => 'required|date',
                'periode_kontrak_akhir' => 'required|date',
                'url_foto' => 'required'
            ]);
        } else {
            $storeData['id_pemilik_mobil'] = NULL;
            $storeData['periode_kontrak_mulai'] = NULL;
            $storeData['periode_kontrak_akhir'] = NULL;
            $validate = Validator::make($storeData, [
                'status_mobil' => 'required',
                'nama_mobil' => 'required',
                'tipe_mobil' => 'required',
                'jenis_transmisi' => 'required',
                'jenis_bahan_bakar' => 'required',
                'warna_mobil' => 'required',
                'volume_bagasi' => 'required',
                'fasilitas' => 'required',
                'kapasitas_penumpang' => 'required|numeric',
                'plat_nomor' => 'required',
                'nomor_stnk' => 'required',
                'kategori_aset' => 'required',
                'harga_sewa' =>'required|numeric',
                'status_sewa' => 'required',
                'tanggal_terakhir_kali_servis' => 'required|date',
                'url_foto' => 'required'
            ]);
        }

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $mobil = Mobil::create($storeData);
        
        return response([
            'message' => 'Add Mobil Success',
            'data' => $mobil
        ], 200);
    }

    public function destroy($id) {
        $mobil = Mobil::find($id);

        if(is_null($mobil)) {
            return response([
                'message' => 'Mobil Not Found',
                'data' => null
            ], 404);
        }

        $mobil->status_mobil = 'Tidak Aktif';

        if($mobil->save()) {
            return response([
                'message' => 'Delete Mobil Success',
                'data' => $mobil
            ], 200);
        }

        return response([
            'message' => 'Delete Mobil Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id) {
        $mobil = Mobil::find($id);

        if(is_null($mobil)) {
            return response([
                'message' => 'Mobil Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = null;
        if($updateData['kategori_aset'] === "Aset Mitra") {
            $validate = Validator::make($updateData, [
                'id_pemilik_mobil' => 'required',
                'nama_mobil' => 'required',
                'tipe_mobil' => 'required',
                'jenis_transmisi' => 'required',
                'jenis_bahan_bakar' => 'required',
                'warna_mobil' => 'required',
                'volume_bagasi' => 'required',
                'fasilitas' => 'required',
                'kapasitas_penumpang' => 'required|numeric',
                'plat_nomor' => 'required',
                'nomor_stnk' => 'required',
                'kategori_aset' => 'required',
                'harga_sewa' =>'required|numeric',
                'status_sewa' => 'required',
                'tanggal_terakhir_kali_servis' => 'required|date',
                'periode_kontrak_mulai' => 'required|date',
                'periode_kontrak_akhir' => 'required|date',
                'url_foto' => 'required'
            ]);
        } else {
            $validate = Validator::make($updateData, [
                'nama_mobil' => 'required',
                'tipe_mobil' => 'required',
                'jenis_transmisi' => 'required',
                'jenis_bahan_bakar' => 'required',
                'warna_mobil' => 'required',
                'volume_bagasi' => 'required',
                'fasilitas' => 'required',
                'kapasitas_penumpang' => 'required|numeric',
                'plat_nomor' => 'required',
                'nomor_stnk' => 'required',
                'kategori_aset' => 'required',
                'harga_sewa' =>'required|numeric',
                'status_sewa' => 'required',
                'tanggal_terakhir_kali_servis' => 'required|date',
                'url_foto' => 'required'
            ]);
        }

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $mobil->id_pemilik_mobil = $updateData['id_pemilik_mobil'];
        $mobil->nama_mobil = $updateData['nama_mobil'];
        $mobil->tipe_mobil = $updateData['tipe_mobil'];
        $mobil->jenis_transmisi = $updateData['jenis_transmisi'];
        $mobil->jenis_bahan_bakar = $updateData['jenis_bahan_bakar'];
        $mobil->warna_mobil = $updateData['warna_mobil'];
        $mobil->volume_bagasi = $updateData['volume_bagasi'];
        $mobil->fasilitas = $updateData['fasilitas'];
        $mobil->kapasitas_penumpang = $updateData['kapasitas_penumpang'];
        $mobil->plat_nomor = $updateData['plat_nomor'];
        $mobil->nomor_stnk = $updateData['nomor_stnk'];
        $mobil->kategori_aset = $updateData['kategori_aset'];
        $mobil->harga_sewa = $updateData['harga_sewa'];
        $mobil->status_sewa = $updateData['status_sewa'];
        $mobil->tanggal_terakhir_kali_servis = $updateData['tanggal_terakhir_kali_servis'];
        $mobil->periode_kontrak_mulai = $updateData['periode_kontrak_mulai'];
        $mobil->periode_kontrak_akhir = $updateData['periode_kontrak_akhir'];
        $mobil->url_foto = $updateData['url_foto'];

        if($mobil->save()) {
            return response([
                'message' => 'Update Mobil Success',
                'data' => $mobil
            ], 200);
        }

        return response([
            'message' => 'Update Mobil Failed',
            'data' => null
        ], 400);
    }

    public function showAvailable() {
        $mobil = Mobil::where('status_mobil', 'Aktif')->where('status_sewa', 'Available')->get();

        if($mobil->isNotEmpty()) {
            return response([
                'message' => 'Retrieve Mobil Success',
                'data' => $mobil
            ], 200);
        }

        return response([
            'message' => 'Mobil Not Found',
            'data' => null
        ], 404);
    }

    public function showKontrakAkanHabis() {
        $mobil = Mobil::where('kategori_aset', 'Aset Mitra')->whereRaw('DATEDIFF(periode_kontrak_akhir, now()) < ?', [120])->get();

        if($mobil->isNotEmpty()) {
            return response([
                'message' => 'Retrieve Mobil Success',
                'data' => $mobil
            ], 200);
        }

        return response([
            'message' => 'Mobil Not Found',
            'data' => null
        ], 404);
    }

    public function updatePeriodeKontrak(Request $request, $id) {
        $mobil = Mobil::find($id);

        if(is_null($mobil)) {
            return response([
                'message' => 'Mobil Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'periode_kontrak_mulai' => 'required|date',
            'periode_kontrak_akhir' => 'required|date',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $mobil->periode_kontrak_mulai = $updateData['periode_kontrak_mulai'];
        $mobil->periode_kontrak_akhir = $updateData['periode_kontrak_akhir'];

        if($mobil->save()) {
            return response([
                'message' => 'Update Mobil Success',
                'data' => $mobil
            ], 200);
        }

        return response([
            'message' => 'Update Mobil Failed',
            'data' => null
        ], 400);
    }
}
