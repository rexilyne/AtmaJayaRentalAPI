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
                'message' => 'Retreive All Success',
                'data' => $detailJadwals
            ], 200);

            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
    }

    public function show($id) {
        $detailJadwal = DetailJadwal::find($id);

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

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $detailJadwal = DetailJadwal::create($storeData);
        
        return response([
            'message' => 'Add Detail Jadwal Success',
            'data' => $detailJadwal
        ], 200);
    }

    public function destroy($id) {
        $detailJadwal = DetailJadwal::find($id);

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

    public function update(Request $request, $id) {
        $detailJadwal = DetailJadwal:: find($id);

        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [

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
}
