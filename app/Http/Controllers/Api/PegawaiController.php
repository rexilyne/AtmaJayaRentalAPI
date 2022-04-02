<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    //
    public function index() {
        $pegawais = Pegawai::all();

        if(count($pegawais) > 0) {
            return response([
                'message' => 'Retreive All Success',
                'data' => $pegawais
            ], 200);

            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
    }

    public function show($id) {
        $pegawai = Pegawai::find($id);

        if(!is_null($pegawai)) {
            return response([
                'message' => 'Retrieve Pegawai Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Pegawai Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pegawai = Pegawai::create($storeData);
        
        return response([
            'message' => 'Add Pegawai Success',
            'data' => $pegawai
        ], 200);
    }

    public function destroy($id) {
        $pegawai = Pegawai::find($id);

        if(is_null($pegawai)) {
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        }

        if($pegawai->delete()) {
            return response([
                'message' => 'Delete Pegawai Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Delete Pegawai Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id) {
        $pegawai = Pegawai:: find($id);

        if(is_null($pegawai)) {
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pegawai->nama = $updateData['nama'];

        if($pegawai->save()) {
            return response([
                'message' => 'Update Pegawai Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Update Pegawai Failed',
            'data' => null
        ], 400);
    }
}
