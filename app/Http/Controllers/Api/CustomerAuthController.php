<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    //
    public function register(Request $request) {
        $registerData = $request->all();

        $custRegDate = date('ymd');
        $lastCustId = DB::table('customer')->latest()->first();
        if(is_null($lastCustId)) {
            $lastCustId = 0;
        } else {
            $lastCustId = DB::table('customer')->latest()->first()->id;
        }
        $custId = $lastCustId + 1;
        $registerData['id_customer'] =  'CUS'.$custRegDate.'-'.$custId;

        $registerData['status_akun'] = 'Aktif';
        $registerData['password'] = bcrypt($registerData['tanggal_lahir']);

        $validate = Validator::make($registerData, [
            'id_customer' => 'required|unique:customer',
            'status_akun' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'email' => 'required|email:rfc,dns|unique:customer',
            'no_telp' => 'required|unique:customer',
            'password' => 'required',
            'url_sim' => 'required',
            'url_kartu_identitas' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $customer = Customer::create($registerData);
        
        return response([
            'message' => 'Add Customer Success',
            'data' => $customer
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

        if(!Auth::guard('customer')->attempt([
            'email' => $email,
            'password' => $password
        ])) {
            return response([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        /** @var \App\Models\Customer $user **/
        $user = Auth::guard('customer')->user();
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
