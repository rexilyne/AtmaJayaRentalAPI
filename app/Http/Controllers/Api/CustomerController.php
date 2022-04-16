<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //
    public function index() {
        $customers = Customer::all();

        if(count($customers) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $customers
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id) {
        $customer = Customer::where('id_customer', $id)->get();

        if(!is_null($customer)) {
            return response([
                'message' => 'Retrieve Customer Success',
                'data' => $customer
            ], 200);
        }

        return response([
            'message' => 'Customer Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();

        $custRegDate = date('ymd');
        $lastCustId = DB::table('customer')->latest()->first();
        if(is_null($lastCustId)) {
            $lastCustId = 0;
        }
        $custId = $lastCustId + 1;
        $storeData['id_customer'] =  'CUS'.$custRegDate.'-'.$custId;

        $storeData['status_akun'] = 'Aktif';
        $storeData['password'] = bcrypt($storeData['tanggal_lahir']);

        $validate = Validator::make($storeData, [
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

        $customer = Customer::create($storeData);
        
        return response([
            'message' => 'Add Customer Success',
            'data' => $customer
        ], 200);
    }

    public function destroy($id) {
        $customer = Customer::where('id_customer', $id)->get();

        if(is_null($customer)) {
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ], 404);
        }

        $customer->status_akun = 'Tidak Aktif';

        if($customer->save()) {
            return response([
                'message' => 'Delete Customer Success',
                'data' => $customer
            ], 200);
        }

        return response([
            'message' => 'Delete Customer Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id) {
        $customer = Customer::where('id_customer', $id)->get();

        if(is_null($customer)) {
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_customer' => ['required', Rule::unique('customer')->ignore($customer)],
            'status_akun' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('customer')->ignore($customer)],
            'no_telp' => ['required', Rule::unique('customer')->ignore($customer)],
            'password' => 'required',
            'url_sim' => 'required',
            'url_kartu_identitas' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $customer->nama = $updateData['nama'];
        $customer->alamat = $updateData['alamat'];
        $customer->tanggal_lahir = $updateData['tanggal_lahir'];
        $customer->jenis_kelamin = $updateData['jenis_kelamin'];
        $customer->email = $updateData['email'];
        $customer->no_telp = $updateData['no_telp'];
        $customer->password = $updateData['password'];
        $customer->url_sim = $updateData['url_sim'];
        $customer->url_kartu_identitas = $updateData['url_kartu_identitas'];

        if($customer->save()) {
            return response([
                'message' => 'Update Customer Success',
                'data' => $customer
            ], 200);
        }

        return response([
            'message' => 'Update Customer Failed',
            'data' => null
        ], 400);
    }
}
