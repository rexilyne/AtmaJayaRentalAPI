<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;

class PegawaiAuthController extends Controller
{
    //
    public function register(Request $request) {
        $registerData = $request->all();
        $registerData['status_akun'] = 'Aktif';
        $registerData['password'] = bcrypt($registerData['tanggal_lahir']);
        $validate = Validator::make($registerData, [
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

        $pegawai = Pegawai::create($registerData);
        
        return response([
            'message' => 'Add Pegawai Success',
            'data' => $pegawai
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

        if(!Auth::guard('pegawai')->attempt([
            'email' => $email,
            'password' => $password
        ])) {
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        /** @var \App\Models\Pegawai $user **/
        $user = Auth::guard('pegawai')->user();
        $token = $user->createToken('Authentication Token')->accessToken;

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
