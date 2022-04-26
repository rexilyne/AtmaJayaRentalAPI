<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;

class DriverAuthController extends Controller
{
    //
    public function register(Request $request) {
        $registerData = $request->all();

        $drivRegDate = date('ymd');
        $lastDrivId = DB::table('driver')->latest('id')->first();
        if(is_null($lastDrivId)) {
            $lastDrivId = 0;
        } else {
            $lastDrivId = DB::table('driver')->latest('id')->first()->id;
        }
        $drivId = $lastDrivId + 1;
        $registerData['id_driver'] =  'DRV'.$drivRegDate.'-'.$drivId;

        $registerData['status_akun'] = 'Aktif';
        $registerData['status_driver'] = 'Available';
        $registerData['password'] = bcrypt($registerData['tanggal_lahir']);

        $validate = Validator::make($registerData, [
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

        $driver = Driver::create($registerData);
        
        return response([
            'message' => 'Add Driver Success',
            'data' => $driver
        ], 200);
    }

    public function login(Request $request) {
        $loginData = $request->all();
        
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if($validate->fails()) {
            return response([
                'message' => $validate->errors()
            ], 400);
        }

        $email = $loginData['email'];
        $password = $loginData['password'];

        if(!Auth::guard('driver')->attempt([
            'email' => $email,
            'password' => $password
        ])) {
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        /** @var \App\Models\Driver $user **/
        $user = Auth::guard('driver')->user();
        $token = $user->createToken('Authentication Token')->accessToken;

        if($user->status_akun === "Tidak Aktif") {
            return response([
                'message' => 'Akun tidak aktif'
            ], 401);
        }

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

    public function logout(Request $request) {
        if($request->user()) {
            /** @var \App\Models\Customer $user **/
            $user = $request->user();
            
            $user->token()->revoke();

            return response([
                'message' => 'Successfully logged out'
            ]);
        }

        return response([
            'message' => 'Logout failed'
        ]);
    }
}
