<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Promo;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    //
    public function index() {
        $promos = Promo::all();

        if(count($promos) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $promos
            ], 200);

            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
    }

    public function show($id) {
        $promo = Promo::find($id);

        if(!is_null($promo)) {
            return response([
                'message' => 'Retrieve Promo Success',
                'data' => $promo
            ], 200);
        }

        return response([
            'message' => 'Promo Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'kode_promo' => 'required|unique:promo',
            'jenis_promo' => 'required',
            'keterangan' => 'required',
            'diskon_promo' => 'required',
            'status_promo' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $promo = Promo::create($storeData);
        
        return response([
            'message' => 'Add Promo Success',
            'data' => $promo
        ], 200);
    }

    public function destroy($id) {
        $promo = Promo::find($id);

        if(is_null($promo)) {
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }

        $promo->status_promo = 'Tidak Aktif';

        if($promo->save()) {
            return response([
                'message' => 'Delete Promo Success',
                'data' => $promo
            ], 200);
        }

        return response([
            'message' => 'Delete Promo Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id) {
        $promo = Promo::find($id);

        if(is_null($promo)) {
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'kode_promo' => ['required', Rule::unique('promo')->ignore($promo)],
            'jenis_promo' => 'required',
            'keterangan' => 'required',
            'diskon_promo' => 'required',
            'status_promo' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
            
        $promo->kode_promo = $updateData['kode_promo'];
        $promo->jenis_promo = $updateData['jenis_promo'];
        $promo->keterangan = $updateData['keterangan'];
        $promo->diskon_promo = $updateData['diskon_promo'];
        $promo->status_promo = $updateData['status_promo'];

        if($promo->save()) {
            return response([
                'message' => 'Update Promo Success',
                'data' => $promo
            ], 200);
        }

        return response([
            'message' => 'Update Promo Failed',
            'data' => null
        ], 400);
    }

    public function showActive() {
        $promo = Promo::where('status_promo', 'Aktif')->get();

        if(!is_null($promo)) {
            return response([
                'message' => 'Retrieve Promo Success',
                'data' => $promo
            ], 200);
        }

        return response([
            'message' => 'Promo Not Found',
            'data' => null
        ], 404);
    }
}
