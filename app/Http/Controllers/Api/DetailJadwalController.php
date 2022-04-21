<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DetailJadwal;

class DetailJadwalController extends Controller
{
    //
    public function index() {
        $detailJadwals = DetailJadwal::all();

        if(count($detailJadwals) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $detailJadwals
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function showByIdPegawai($id) {
        $detailJadwal = DetailJadwal::where('id_pegawai', $id)->get();

        if(!is_null($detailJadwal)) {
            return response([
                'message' => 'Retrieve Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Detail Jadwal Not Found',
            'data' => null
        ], 404);
    }

    public function showByIdJadwal($id) {
        $detailJadwal = DetailJadwal::where('id_jadwal', $id)->get();

        if(!is_null($detailJadwal)) {
            return response([
                'message' => 'Retrieve Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Detail Jadwal Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_jadwal' => 'required',
            'id_pegawai' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $detailJadwal = DetailJadwal::create($storeData);
        
        return response([
            'message' => 'Add Detail Jadwal Success',
            'data' => $detailJadwal
        ], 200);
    }

    public function destroyByIdPegawai($id) {
        $detailJadwal = DetailJadwal::where('id_pegawai', $id)->first();

        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }

        if($detailJadwal->delete()) {
            return response([
                'message' => 'Delete Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Delete Detail Jadwal Failed',
            'data' => null
        ], 400);
    }

    public function destroyByIdJadwal($id) {
        $detailJadwal = DetailJadwal::where('id_jadwal', $id)->first();

        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }

        if($detailJadwal->delete()) {
            return response([
                'message' => 'Delete Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Delete Detail Jadwal Failed',
            'data' => null
        ], 400);
    }

    public function updateByIdPegawai(Request $request, $id) {
        $detailJadwal = DetailJadwal::where('id_pegawai', $id)->first();

        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_jadwal' => 'required',
            'id_pegawai' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $detailJadwal->id_jadwal = $updateData['id_jadwal'];
        $detailJadwal->id_pegawai = $updateData['id_pegawai'];

        if($detailJadwal->save()) {
            return response([
                'message' => 'Update Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Update Detail Jadwal Failed',
            'data' => null
        ], 400);
    }

    public function updateByIdJadwal(Request $request, $id) {
        $detailJadwal = DetailJadwal::where('id_jadwal', $id)->first();

        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_jadwal' => 'required',
            'id_pegawai' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $detailJadwal->id_jadwal = $updateData['id_jadwal'];
        $detailJadwal->id_pegawai = $updateData['id_pegawai'];

        if($detailJadwal->save()) {
            return response([
                'message' => 'Update Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Update Detail Jadwal Failed',
            'data' => null
        ], 400);
    }

    public function cekSyaratPenjadwalan(Request $request) {
        $cekData = $request->all();

        $cekJumlahShift = DetailJadwal::where('id_pegawai', $cekData['id_pegawai'])->count();
        
        if($cekJumlahShift == 6) {
            return response([
                'message' => '1 Pegawai maksimal 6 shift',
            ], 400);
        }

        return response([
            'message' => 'OK'
        ], 200);
    }
}
