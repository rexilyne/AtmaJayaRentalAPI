<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    //
    public function index() {
        $drivers = Driver::all();

        if(count($drivers) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $drivers
            ], 200);

            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
    }

    public function show($id) {
        $driver = Driver::where('id_driver', $id)->get();

        if(!is_null($driver)) {
            return response([
                'message' => 'Retrieve Driver Success',
                'data' => $driver
            ], 200);
        }

        return response([
            'message' => 'Driver Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_driver' => 'required|unique:driver',
            'status_akun' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'email' => 'required|email:rfc,dns|unique:driver',
            'no_telp' => 'required|unique:driver',
            'bahasa' => 'required',
            'status_driver' => 'required',
            'password' => 'required',
            'tarif_driver' => 'required',
            'rerata_rating' => 'required',
            'url_sim' => 'required',
            'url_surat_bebas_napza' => 'required',
            'url_surat_kesehatan_jiwa' => 'required',
            'url_skck' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $driver = Driver::create($storeData);
        
        return response([
            'message' => 'Add Driver Success',
            'data' => $driver
        ], 200);
    }

    public function destroy($id) {
        $driver = Driver::where('id_driver', $id)->get();

        if(is_null($driver)) {
            return response([
                'message' => 'Driver Not Found',
                'data' => null
            ], 404);
        }

        if($driver->delete()) {
            return response([
                'message' => 'Delete Driver Success',
                'data' => $driver
            ], 200);
        }

        return response([
            'message' => 'Delete Driver Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id) {
        $driver = Driver::where('id_driver', $id)->get();

        if(is_null($driver)) {
            return response([
                'message' => 'Driver Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_driver' => ['required', Rule::unique('driver')->ignore($driver)],
            'status_akun' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('driver')->ignore($driver)],
            'no_telp' => ['required', Rule::unique('driver')->ignore($driver)],
            'bahasa' => 'required',
            'status_driver' => 'required',
            'password' => 'required',
            'tarif_driver' => 'required',
            'rerata_rating' => 'required',
            'url_sim' => 'required',
            'url_surat_bebas_napza' => 'required',
            'url_surat_kesehatan_jiwa' => 'required',
            'url_skck' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $driver->nama = $updateData['nama'];
        $driver->alamat = $updateData['alamat'];
        $driver->tanggal_lahir = $updateData['tanggal_lahir'];
        $driver->jenis_kelamin = $updateData['jenis_kelamin'];
        $driver->email = $updateData['email'];
        $driver->no_telp = $updateData['no_telp'];
        $driver->bahasa = $updateData['bahasa'];
        $driver->status_driver = $updateData['status_driver'];
        $driver->password = $updateData['password'];
        $driver->tarif_driver = $updateData['tarif_driver'];
        $driver->rerata_rating = $updateData['rerata_rating'];
        $driver->url_sim = $updateData['url_sim'];
        $driver->url_surat_bebas_napza = $updateData['url_surat_bebas_napza'];
        $driver->url_surat_kesehatan_jiwa = $updateData['url_surat_kesehatan_jiwa'];
        $driver->url_skck = $updateData['url_skck'];
 
        if($driver->save()) {
            return response([
                'message' => 'Update Driver Success',
                'data' => $driver
            ], 200);
        }

        return response([
            'message' => 'Update Driver Failed',
            'data' => null
        ], 400);
    }
}
