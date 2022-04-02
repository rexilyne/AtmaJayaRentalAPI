<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mobil;

class MobilController extends Controller
{
    //
    public function index() {
        $mobils = Mobil::all();

        if(count($mobils) > 0) {
            return response([
                'message' => 'Retreive All Success',
                'data' => $mobils
            ], 200);

            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
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
        $validate = Validator::make($storeData, [

        ]);

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

        if($mobil->delete()) {
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
        $mobil = Mobil:: find($id);

        if(is_null($mobil)) {
            return response([
                'message' => 'Mobil Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [

        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $mobil->nama = $updateData['nama'];

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
