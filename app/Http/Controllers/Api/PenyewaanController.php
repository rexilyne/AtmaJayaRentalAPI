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
