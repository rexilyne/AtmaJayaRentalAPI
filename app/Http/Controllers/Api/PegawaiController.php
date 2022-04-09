<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;
use Illuminate\Validation\Rule;

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
            'status_akun' => 'required',
            'id_role' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email:rfc,dns|unique:pegawai',
            'no_telp' => 'required|unique:pegawai',
            'password' => 'required',
            'url_foto' => 'required'
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
            'status_akun' => 'required',
            'id_role' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'email' => ['required', 'email:rfc,dns' , Rule::unique('pegawai')->ignore($pegawai)],
            'no_telp' => ['required', Rule::unique('pegawai')->ignore($pegawai)],
            'password' => 'required',
            'url_foto' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pegawai->id_role = $updateData['id_role'];
        $pegawai->nama = $updateData['nama'];
        $pegawai->alamat = $updateData['alamat'];
        $pegawai->tanggal_lahir = $updateData['tanggal_lahir'];
        $pegawai->jenis_kelamin = $updateData['jenis_kelamin'];
        $pegawai->email = $updateData['email'];
        $pegawai->no_telp = $updateData['no_telp'];
        $pegawai->password = $updateData['password'];
        $pegawai->url_foto = $updateData['url_foto'];

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
