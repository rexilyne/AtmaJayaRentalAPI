<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PemilikMobil;

class PemilikMobilController extends Controller
{
    //
    public function index() {
        $pemilikMobils = PemilikMobil::all();

        if(count($pemilikMobils) > 0) {
            return response([
                'message' => 'Retreive All Success',
                'data' => $pemilikMobils
            ], 200);

            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
    }

    public function show($id) {
        $pemilikMobil = PemilikMobil::find($id);

        if(!is_null($pemilikMobil)) {
            return response([
                'message' => 'Retrieve Pemilik Mobil Success',
                'data' => $pemilikMobil
            ], 200);
        }

        return response([
            'message' => 'Pemilik Mobil Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pemilikMobil = PemilikMobil::create($storeData);
        
        return response([
            'message' => 'Add Pemilik Mobil Success',
            'data' => $pemilikMobil
        ], 200);
    }

    public function destroy($id) {
        $pemilikMobil = PemilikMobil::find($id);

        if(is_null($pemilikMobil)) {
            return response([
                'message' => 'Pemilik Mobil Not Found',
                'data' => null
            ], 404);
        }

        if($pemilikMobil->delete()) {
            return response([
                'message' => 'Delete Pemilik Mobil Success',
                'data' => $pemilikMobil
            ], 200);
        }

        return response([
            'message' => 'Delete Pemilik Mobil Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id) {
        $pemilikMobil = PemilikMobil:: find($id);

        if(is_null($pemilikMobil)) {
            return response([
                'message' => 'Pemilik Mobil Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pemilikMobil->nama = $updateData['nama'];

        if($pemilikMobil->save()) {
            return response([
                'message' => 'Update Pemilik Mobil Success',
                'data' => $pemilikMobil
            ], 200);
        }

        return response([
            'message' => 'Update Pemilik Mobil Failed',
            'data' => null
        ], 400);
    }
}
