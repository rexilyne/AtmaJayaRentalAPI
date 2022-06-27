<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Penyewaan;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Customer;

class PenyewaanController extends Controller
{
    //
    public function index()
    {
        $penyewaans = Penyewaan::all();

        if (count($penyewaans) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $penyewaans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function showNotaPenyewaanAll()
    {
        if (is_null(Penyewaan::all())) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }

        $penyewaans = DB::table('penyewaan')
            ->leftJoin('pegawai', 'penyewaan.id_pegawai', '=', 'pegawai.id_pegawai')
            ->leftJoin('driver', 'penyewaan.id_driver', '=', 'driver.id_driver')
            ->leftJoin('customer', 'penyewaan.id_customer', '=', 'customer.id_customer')
            ->leftJoin('mobil', 'penyewaan.id_mobil', '=', 'mobil.id_mobil')
            ->leftJoin('promo', 'penyewaan.id_promo', '=', 'promo.id_promo')
            ->select('penyewaan.id as id_p', 'penyewaan.*', 'customer.nama as nama_customer', 'driver.nama as nama_driver', 'pegawai.nama as nama_pegawai', 'mobil.nama_mobil', 'promo.kode_promo')
            ->orderBy('penyewaan.id', 'asc')
            ->get();

        return response([
            'message' => 'Retrieve Penyewaan Success',
            'data' => $penyewaans
        ], 200);
    }

    public function showNotaPenyewaanByIdCustomer($id)
    {
        if (is_null(Penyewaan::all())) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }

        $penyewaans = DB::table('penyewaan')
            ->leftJoin('pegawai', 'penyewaan.id_pegawai', '=', 'pegawai.id_pegawai')
            ->leftJoin('driver', 'penyewaan.id_driver', '=', 'driver.id_driver')
            ->leftJoin('customer', 'penyewaan.id_customer', '=', 'customer.id_customer')
            ->leftJoin('mobil', 'penyewaan.id_mobil', '=', 'mobil.id_mobil')
            ->leftJoin('promo', 'penyewaan.id_promo', '=', 'promo.id_promo')
            ->where('penyewaan.id_customer', $id)
            ->select('penyewaan.id as id_p', 'penyewaan.*', 'customer.nama as nama_customer', 'driver.nama as nama_driver', 'pegawai.nama as nama_pegawai', 'mobil.nama_mobil', 'promo.kode_promo')
            ->orderBy('penyewaan.id', 'asc')
            ->get();

        if (is_null($penyewaans)) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }

        return response([
            'message' => 'Retrieve Penyewaan Success',
            'data' => $penyewaans
        ], 200);
    }

    public function showNotaPenyewaanByIdDriver($id)
    {
        if (is_null(Penyewaan::all())) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }

        $penyewaans = DB::table('penyewaan')
            ->leftJoin('pegawai', 'penyewaan.id_pegawai', '=', 'pegawai.id_pegawai')
            ->leftJoin('driver', 'penyewaan.id_driver', '=', 'driver.id_driver')
            ->leftJoin('customer', 'penyewaan.id_customer', '=', 'customer.id_customer')
            ->leftJoin('mobil', 'penyewaan.id_mobil', '=', 'mobil.id_mobil')
            ->leftJoin('promo', 'penyewaan.id_promo', '=', 'promo.id_promo')
            ->where('penyewaan.id_driver', $id)
            ->select('penyewaan.id as id_p', 'penyewaan.*', 'customer.nama as nama_customer', 'driver.nama as nama_driver', 'pegawai.nama as nama_pegawai', 'mobil.nama_mobil', 'promo.kode_promo')
            ->orderBy('penyewaan.id', 'asc')
            ->get();

        if (is_null($penyewaans)) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }

        return response([
            'message' => 'Retrieve Penyewaan Success',
            'data' => $penyewaans
        ], 200);
    }

    public function showByIdPenyewaan($id)
    {
        $penyewaan = Penyewaan::where('id_penyewaan', $id)->first();

        if (!is_null($penyewaan)) {
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

    public function showByIdCustomer($id)
    {
        $penyewaan = Penyewaan::where('id_customer', $id)->get();

        if (!is_null($penyewaan)) {
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

    public function showByIdDriver($id)
    {
        $penyewaan = Penyewaan::where('id_driver', $id)->get();

        if (!is_null($penyewaan)) {
            return response([
                'message' => 'Retrieve Penyewaan Success',
                'data' => $penyewaan,
            ], 200);
        }

        return response([
            'message' => 'Penyewaan Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();

        $orderDate = date('Y-m-d');
        $jenisPenyewaan = 0;
        if ($storeData['jenis_penyewaan'] === 'Penyewaan Mobil + Driver') {
            $jenisPenyewaan = 1;
        } elseif ($storeData['jenis_penyewaan'] === 'Penyewaan Mobil') {
            $jenisPenyewaan = 0;
        }
        //ini salah
        //yg masuk malah string 'tanggal_mulai_sewa' sama 'tanggal_selesai'
        // $dateStart = Carbon::parse('tanggal_mulai_sewa');
        // $dateEnd = Carbon::parse('tanggal_selesai');

        //harusnya gini nat
        //yg masuk tanggal dari storeData
        $dateStart = Carbon::parse($storeData['tanggal_mulai_sewa']);
        $dateEnd = Carbon::parse($storeData['tanggal_selesai']);

        $dayInterval = $dateStart->diffInDays($dateEnd);


        $totalHargaDriver = 0.0;
        $idDriver =  $storeData['id_driver'];
        if ($idDriver != null) {
            $tarifDriver = DB::table('driver')
                ->where('id_driver', $idDriver)->first()->tarif_driver;
            $totalHargaDriver = $dayInterval * $tarifDriver;
        } else {
            $totalHargaDriver = 0.0;
        }

        $idMobil = $storeData['id_mobil'];
        $tarifMobil = DB::table('mobil')
            ->where('id_mobil', $idMobil)->first()->harga_sewa;
        $totalHargaMobil = $dayInterval * $tarifMobil;

        $lastId = Penyewaan::select('id')->orderBy('id', 'desc')->first();
        $lastId = (int)substr($lastId, -3);
        $storeData['id_penyewaan'] = 'TRN' . date('ymd', strtotime($orderDate)) . '0' . $jenisPenyewaan . '-' . $lastId + 1;
        $storeData['tanggal_penyewaan'] = $orderDate;
        $storeData['tanggal_pembayaran'] = null;
        $storeData['id_pegawai'] = null;
        $storeData['status_penyewaan'] = "Belum Diverifikasi";
        $storeData['metode_pembayaran'] = "-";
        $storeData['total_diskon'] = 0;
        $storeData['total_denda'] = 0;
        $storeData['total_harga_bayar'] = 0;
        $storeData['bukti_pembayaran'] = "-";
        $storeData['total_harga_sewa'] = $totalHargaDriver + $totalHargaMobil;
        $storeData['rating_driver'] = 0.0;
        $storeData['performa_driver'] = "-";
        $storeData['rating_perusahaan'] = 0.0;
        $storeData['performa_perusahaan'] = "-";

        $validate = Validator::make($storeData, [
            'id_penyewaan' => 'required|unique:penyewaan',
            //'id_driver' => 'required',
            'id_customer' => 'required',
            'id_mobil' => 'required',
            'jenis_penyewaan' => 'required',
            'tanggal_penyewaan' => 'required|date',
            'tanggal_mulai_sewa' => 'required|date_format:Y-m-d H:i:s',
            'tanggal_selesai' => 'required|date_format:Y-m-d H:i:s',
            //'tanggal_pengembalian' => 'required|date',
            'total_harga_sewa' => 'required',
            'status_penyewaan' => 'required',
            //'tanggal_pembayaran'=> 'required',
            'metode_pembayaran' => 'required',
            'total_diskon' => 'required',
            'total_denda' => 'required',
            'total_harga_bayar' => 'required',
            //'bukti_pembayaran' => 'required',
            //'rating_driver' => 'required',S
            'performa_driver' => 'required',
            //'rating_rental' => 'required',
            //'performa_rental' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $customer = Customer::where('id_customer', $storeData['id_customer'])->first();
        if ($customer->url_sim == "-" && $storeData['jenis_penyewaan'] == "Penyewaan Mobil") {
            return response(['message' => 'Jenis Penyewaan tidak valid karena customer belum memiliki SIM'], 400);
        }

        $penyewaan = Penyewaan::create($storeData);

        return response([
            'message' => 'Add Penyewaan Success',
            'data' => $penyewaan
        ], 200);

        // $storeData = $request->all();

        // $orderDate = date('ymd');
        // $idJenisPenyewaan = 0;
        // if($storeData['jenis_penyewaan'] === 'Penyewaan Mobil + Driver') {
        //     $idJenisPenyewaan = 1;
        // } else if($storeData['jenis_penyewaan'] === 'Penyewaan Mobil') {
        //     $idJenisPenyewaan = 0;
        // }
        // $lastSewaId = DB::table('penyewaan')->latest()->first()->id;
        // if(is_null($lastSewaId)) {
        //     $lastSewaId = 0;
        // }
        // $sewaId = $lastSewaId + 1;
        // $storeData['id_penyewaan'] = 'TRN'.$orderDate.'0'.$idJenisPenyewaan.'-'.$sewaId;


        // $validate = Validator::make($storeData, [
        //     'id_penyewaan' => 'required|unique:penyewaan',
        //     'id_pegawai' => 'required',
        //     'id_driver' => 'required',
        //     'id_customer' => 'required',
        //     'id_mobil' => 'required',
        //     'id_promo' => 'required',
        //     'jenis_penyewaan' => 'required',
        //     'tanggal_penyewaan' => 'required|date',
        //     'tanggal_mulai_sewa' => 'require|date',
        //     'tanggal_selesai' => 'required|date',
        //     'tanggal_pengembalian' => 'required|date',
        //     'total_harga_sewa' => 'required|numeric',
        //     'status_penyewaan' => 'required',
        //     'tanggal_pembayaran' => 'required|date',
        //     'metode_pembayaran' => 'required',
        //     'total_diskon' => 'required|numeric',
        //     'total_denda' => 'required|numeric',
        //     'total_harga_bayar' => 'required|numeric',
        //     'url_bukti_pembayaran' => 'required',
        //     'rating_driver' => 'required|numeric',
        //     'performa_driver' => 'required',
        //     'rating_perusahaan' => 'required|numeric',
        //     'performa_perusahaan' => 'required'
        // ]);

        // if($validate->fails())
        //     return response(['message' => $validate->errors()], 400);

        // $penyewaan = Penyewaan::create($storeData);

        // return response([
        //     'message' => 'Add Penyewaan Success',
        //     'data' => $penyewaan
        // ], 200);
    }

    public function destroy($id)
    {
        $penyewaan = Penyewaan::where('id_penyewaan', $id)->first();

        if (is_null($penyewaan)) {
            return response([
                'message' => 'Penyewaan Not Found',
                'data' => null
            ], 404);
        }

        if ($penyewaan->delete()) {
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

    public function update(Request $request, $id)
    {
        $penyewaan = Penyewaan::where('id_penyewaan', $id)->first();

        if (is_null($penyewaan)) {
            return response([
                'message' => 'Penyewaan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_penyewaan' => ['required', Rule::unique('penyewaan')->ignore($penyewaan)],
            //'id_driver' => 'required',
            'id_customer' => 'required',
            'id_mobil' => 'required',
            'jenis_penyewaan' => 'required',
            'tanggal_penyewaan' => 'required|date',
            'tanggal_mulai_sewa' => 'required|date_format:Y-m-d H:i:s',
            'tanggal_selesai' => 'required|date_format:Y-m-d H:i:s',
            //'tanggal_pengembalian' => 'required|date',
            'total_harga_sewa' => 'required',
            'status_penyewaan' => 'required',
            //'tanggal_pembayaran'=> 'required',
            'metode_pembayaran' => 'required',
            'total_diskon' => 'required',
            'total_denda' => 'required',
            'total_harga_bayar' => 'required',
            //'bukti_pembayaran' => 'required',
            //'rating_driver' => 'required',
            // 'performa_driver' => 'required',
            //'rating_rental' => 'required',
            //'performa_rental' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $customer = Customer::where('id_customer', $updateData['id_customer'])->first();
        if ($customer->url_sim == "-" && $updateData['jenis_penyewaan'] == "Penyewaan Mobil") {
            return response(['message' => 'Jenis Penyewaan tidak valid karena customer belum memiliki SIM'], 400);
        }
        // $penyewaan->nama = $updateData['nama'];

        $penyewaan->id_pegawai = $updateData['id_pegawai'];
        $penyewaan->id_driver = $updateData['id_driver'];
        $penyewaan->id_customer = $updateData['id_customer'];
        $penyewaan->id_mobil = $updateData['id_mobil'];
        $penyewaan->id_promo = $updateData['id_promo'];
        $penyewaan->jenis_penyewaan = $updateData['jenis_penyewaan'];
        $penyewaan->tanggal_penyewaan = $updateData['tanggal_penyewaan'];
        $penyewaan->tanggal_mulai_sewa = $updateData['tanggal_mulai_sewa'];
        $penyewaan->tanggal_selesai = $updateData['tanggal_selesai'];
        $penyewaan->tanggal_pengembalian = $updateData['tanggal_pengembalian'];
        $penyewaan->total_harga_sewa = $updateData['total_harga_sewa'];
        $penyewaan->status_penyewaan = $updateData['status_penyewaan'];
        $penyewaan->tanggal_pembayaran = $updateData['tanggal_pembayaran'];
        $penyewaan->metode_pembayaran = $updateData['metode_pembayaran'];
        $penyewaan->total_diskon = $updateData['total_diskon'];
        $penyewaan->total_denda = $updateData['total_denda'];
        $penyewaan->total_harga_bayar = $updateData['total_harga_bayar'];
        $penyewaan->url_bukti_pembayaran = $updateData['url_bukti_pembayaran'];
        $penyewaan->rating_driver = $updateData['rating_driver'];
        $penyewaan->performa_driver = $updateData['performa_driver'];
        $penyewaan->rating_perusahaan = $updateData['rating_perusahaan'];
        $penyewaan->performa_perusahaan = $updateData['performa_perusahaan'];

        if ($penyewaan->save()) {
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

    public function hitungTotalHarga($id)
    {

        $toBeUpdated = Penyewaan::where('id_penyewaan', $id)->first();
        $totalDiskon = 0.0;
        $idPromo = $toBeUpdated->id_promo;

        if ($idPromo != null) {
            $diskonPromo = DB::table('promo')->where('id_promo', $idPromo)->first()->diskon_promo;
            $totalDiskon = $toBeUpdated->total_harga_sewa * $diskonPromo / 100;
        }

        $totalHarga = $toBeUpdated->total_harga_sewa + $toBeUpdated->total_denda - $totalDiskon;
        $toBeUpdated->total_diskon = $totalDiskon;
        $toBeUpdated->total_harga_bayar = $totalHarga;

        if ($toBeUpdated->save()) {
            return response([
                'message' => 'Update Harga Success',
                'data' => $toBeUpdated
            ], 200);
        }

        return response([
            'message' => 'Update Harga Failed',
            'data' => null
        ], 400);
    }

    public function returnMobil($id)
    {

        $toBeUpdated = Penyewaan::where('id_penyewaan', $id)->first();
        $tanggal_pengembalian = date('Y-m-d h:i:s');

        $toBeUpdated->tanggal_pengembalian = $tanggal_pengembalian;

        $dateStart = Carbon::parse($toBeUpdated->tanggal_mulai_sewa);
        $dateEnd = Carbon::parse($tanggal_pengembalian);
        $hourInterval = $dateStart->diffInHours($dateEnd);

        $idDriver =  $toBeUpdated->id_driver;
        $tarifDriver = 0.0;

        if ($idDriver != null) {
            $tarifDriver = DB::table('driver')->where('id_driver', $idDriver)->first()->tarif_driver;
        }

        $idMobil = $toBeUpdated->id_mobil;

        $tarifMobil = DB::table('mobil')->where('id_mobil', $idMobil)->first()->harga_sewa;
        if ($hourInterval > 3) {
            $toBeUpdated->total_denda = $tarifDriver + $tarifMobil;
        } else {
            $toBeUpdated->total_denda = 0.0;
        }

        if ($toBeUpdated->save()) {
            return response([
                'message' => 'Return Mobil Success',
                'data' => $toBeUpdated
            ], 200);
        }

        return response([
            'message' => 'Return Mobil Failed',
            'data' => null
        ], 400);
    }

    public function penyewaanMobil($bulan, $tahun)
    {
        $laporan = DB::table('penyewaan')
            ->join('mobil', 'penyewaan.id_mobil', "=", "mobil.id_mobil")
            ->select('tipe_mobil', 'nama_mobil', DB::raw('COUNT(penyewaan.id_mobil) AS jumlah_peminjaman'), DB::raw('SUM(total_harga_bayar) AS total_pendapatan'))
            ->whereMonth('tanggal_penyewaan', '=', $bulan)
            ->whereYear('tanggal_penyewaan', '=', $tahun)
            ->groupBy('nama_mobil')
            ->groupBy('tipe_mobil')
            ->orderBy('total_pendapatan', 'desc')
            ->get()
            ->toArray();

        if (!is_null($laporan)) {

            return response([
                'message' => 'Retrieve Data Success',
                'data' => $laporan
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function detailPendapatan($bulan, $tahun)
    {
        $laporan = DB::table('penyewaan')
            ->join('customer', 'penyewaan.id_customer', "=", "customer.id_customer")
            ->join('mobil', 'penyewaan.id_mobil', "=", "mobil.id_mobil")
            ->select('nama', 'nama_mobil', 'jenis_penyewaan', DB::raw('COUNT(penyewaan.id_customer) AS jumlah_penyewaan'), DB::raw('SUM(total_harga_bayar) AS total_pendapatan'))
            ->whereMonth('tanggal_penyewaan', '=', $bulan)
            ->whereYear('tanggal_penyewaan', '=', $tahun)
            ->groupBy('nama')
            ->groupBy('nama_mobil')
            ->groupBy('jenis_penyewaan')
            ->orderBy('jumlah_penyewaan', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        if (!is_null($laporan)) {
            return response([
                'message' => 'Retrieve Data Success',
                'data' => $laporan
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function topDriver($bulan, $tahun)
    {
        $laporan = DB::table('penyewaan')
            ->join('driver', 'penyewaan.id_driver', "=", "driver.id_driver")
            ->select('penyewaan.id_driver AS driver_id', 'nama', DB::raw('COUNT(penyewaan.id_driver) AS jumlah_penyewaan'))
            ->whereMonth('tanggal_penyewaan', '=', $bulan)
            ->whereYear('tanggal_penyewaan', '=', $tahun)
            ->groupBy('penyewaan.id_driver')
            ->groupBy('nama')
            ->orderBy('jumlah_penyewaan', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        if (!is_null($laporan)) {
            return response([
                'message' => 'Retrieve Data Success',
                'data' => $laporan
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function performaDriver($bulan, $tahun)
    {
        $laporan = DB::table('penyewaan')
            ->join('driver', 'penyewaan.id_driver', "=", "driver.id_driver")
            ->select('penyewaan.id_driver AS driver_id', 'nama', DB::raw('COUNT(penyewaan.id_driver) AS jumlah_penyewaan'), 'rerata_rating')
            ->whereNotNull('rating_driver')
            ->where('rating_driver', '!=', 0)
            ->whereMonth('tanggal_penyewaan', '=', $bulan)
            ->whereYear('tanggal_penyewaan', '=', $tahun)
            ->groupBy('penyewaan.id_driver')
            ->groupBy('nama')
            ->groupBy('rerata_rating')
            ->orderBy('jumlah_penyewaan', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        if (!is_null($laporan)) {
            return response([
                'message' => 'Retrieve Data Success',
                'data' => $laporan
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function topCustomer($bulan, $tahun)
    {
        $laporan = DB::table('penyewaan')
            ->join('customer', 'penyewaan.id_customer', "=", "customer.id_customer")
            ->select('nama', DB::raw('COUNT(penyewaan.id_customer) AS jumlah_penyewaan'))
            ->whereMonth('tanggal_penyewaan', '=', $bulan)
            ->whereYear('tanggal_penyewaan', '=', $tahun)
            ->groupBy('nama')
            ->orderBy('jumlah_penyewaan', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        if (!is_null($laporan)) {
            return response([
                'message' => 'Retrieve Data Success',
                'data' => $laporan
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }
}
