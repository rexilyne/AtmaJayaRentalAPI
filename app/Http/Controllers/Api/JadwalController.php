<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    //
    public function index() {
        $jadwals = Jadwal::all();

        if(count($jadwals) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $jadwals
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($idJadwal) {
        $jadwal = Jadwal::where('id_jadwal', $idJadwal)->first();

        if(!is_null($jadwal)) {
            return response([
                'message' => 'Retrieve Jadwal Success',
                'data' => $jadwal
            ], 200);
        }

        return response([
            'message' => 'Jadwal Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'shift' => ['required', 'numeric'],
            'hari' => ['required', 'string']
        ]);

        if($validate->fails())
            return response([
                'message' => $validate->errors()
            ], 400);

        $jadwal = Jadwal::create($storeData);
        return response([
            'message' => 'Add Jadwal Success',
            'data' => $jadwal
        ], 200);
    }

    public function destroy($id) {
        $jadwal = Jadwal::find($id);

        if(is_null($jadwal)) {
            return response([
                'message' => 'Jadwal Not Found',
                'data' => null
            ], 404);
        }

        if($jadwal->delete()) {
            return response([
                'message' => 'Delete Jadwal Success',
                'data' => $jadwal
            ], 200);
        }

        return response([
            'message' => 'Delete Jadwal Failed',
            'data' => null
        ],400);
    }

    public function update(Request $request, $id) {
        $jadwal = Jadwal::find($id);
        if(is_null($jadwal)) {
            return response([
                'message' => 'Jadwal Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'shift' => ['required', 'numeric'],
            'hari' => ['required', 'string']
        ]);

        if($validate->fails())
            return response([
                'message' => $validate->errors()
            ], 400);

        $jadwal->shift = $updateData['shift'];
        $jadwal->hari = $updateData['hari'];

        if($jadwal->save()) {
            return response([
                'message' => 'Update Jadwal Success',
                'data' => $jadwal
            ], 200);
        }

        return response([
            'message' => 'Update Jadwal Failed',
            'data' => null
        ], 400);
    }
}
