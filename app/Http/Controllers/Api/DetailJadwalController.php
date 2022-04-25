<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DetailJadwal;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class DetailJadwalController extends Controller
{
    //
    public function index() {
        if(is_null(DetailJadwal::all())) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
        // $detailJadwals = DetailJadwal::all();
        $detailJadwals = DB::table('detail_jadwal')
                            ->join('pegawai', 'detail_jadwal.id_pegawai', '=', 'pegawai.id_pegawai')
                            ->join('jadwal', 'detail_jadwal.id_jadwal', '=', 'jadwal.id_jadwal')
                            ->get();


        if(count($detailJadwals) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $detailJadwals
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function showByIdPegawai($id) {
        if(DetailJadwal::where('id_pegawai', $id)->get()->isEmpty()) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
        // $detailJadwal = DetailJadwal::where('id_pegawai', $id)->get();
        $detailJadwal = DB::table('detail_jadwal')
                            ->join('pegawai', 'detail_jadwal.id_pegawai', '=', 'pegawai.id_pegawai')
                            ->join('jadwal', 'detail_jadwal.id_jadwal', '=', 'jadwal.id_jadwal')
                            ->where('pegawai.id_pegawai', $id)
                            ->get();

        if($detailJadwal->isNotEmpty()) {
            return response([
                'message' => 'Retrieve Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Detail Jadwal Not Found',
            'data' => null
        ], 404);
    }

    public function showByIdJadwal($id) {
        if(DetailJadwal::where('id_jadwal', $id)->get().isEmpty()) {
            return response([
                'message' => 'Empty',
                'data' => null
            ], 400);
        }
        // $detailJadwal = DetailJadwal::where('id_jadwal', $id)->get();
        $detailJadwal = DB::table('detail_jadwal')
                            ->join('pegawai', 'detail_jadwal.id_pegawai', '=', 'pegawai.id_pegawai')
                            ->join('jadwal', 'detail_jadwal.id_jadwal', '=', 'jadwal.id_jadwal')
                            ->where('jadwal.id_jadwal', $id)
                            ->get();

        if($detailJadwal->isNotEmpty()) {
            return response([
                'message' => 'Retrieve Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Detail Jadwal Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $cekJumlahShift = DetailJadwal::where('id_pegawai', $storeData['id_pegawai'])->count();
        
        if($cekJumlahShift == 6) {
            return response([
                'message' => '1 Pegawai maksimal 6 shift',
            ], 400);
        }

        $validate = Validator::make($storeData, [
            'id_jadwal' => ['required', Rule::unique('detail_jadwal', 'id_jadwal')->where(
                function ($query) use ($storeData) {
                    return $query->where([
                        ["id_jadwal", "=", $storeData['id_jadwal']],
                        ["id_pegawai", "=", $storeData['id_pegawai']]
                    ]
                );
            })],
            'id_pegawai' => ['required', Rule::unique('detail_jadwal', 'id_pegawai')->where(
                function ($query) use ($storeData) {
                    return $query->where([
                        ["id_jadwal", "=", $storeData['id_jadwal']],
                        ["id_pegawai", "=", $storeData['id_pegawai']]
                    ]
                );
            })]
        ]);


        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $detailJadwal = DetailJadwal::create($storeData);
        
        return response([
            'message' => 'Add Detail Jadwal Success',
            'data' => $detailJadwal
        ], 200);
    }

    public function destroy($id_pegawai, $id_jadwal) {
        $detailJadwal = DetailJadwal::where('id_pegawai', $id_pegawai)->where('id_jadwal', $id_jadwal)->first();

        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }

        if(DetailJadwal::where('id_pegawai', $id_pegawai)->where('id_jadwal', $id_jadwal)->delete()) {
            return response([
                'message' => 'Delete Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Delete Detail Jadwal Failed',
            'data' => null
        ], 400);
    }

    // public function destroyByIdJadwal($id) {
    //     $detailJadwal = DetailJadwal::where('id_jadwal', $id)->first();

    //     if(is_null($detailJadwal)) {
    //         return response([
    //             'message' => 'Detail Jadwal Not Found',
    //             'data' => null
    //         ], 404);
    //     }

    //     if($detailJadwal->delete()) {
    //         return response([
    //             'message' => 'Delete Detail Jadwal Success',
    //             'data' => $detailJadwal
    //         ], 200);
    //     }

    //     return response([
    //         'message' => 'Delete Detail Jadwal Failed',
    //         'data' => null
    //     ], 400);
    // }

    public function update(Request $request, $id_pegawai, $id_jadwal) {
        $updateData = $request->all();
        $detailJadwal = DetailJadwal::where('id_pegawai', $id_pegawai)->where('id_jadwal', $id_jadwal)->first();
// dd($updateData['id_pegawai']);
        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }

        $validate = Validator::make($updateData, [
            'id_jadwal' => ['required', Rule::unique('detail_jadwal', 'id_jadwal')->where(
                function ($query) use ($updateData) {
                    return $query->where([
                        ["id_jadwal", "=", $updateData['id_jadwal']],
                        ["id_pegawai", "=", $updateData['id_pegawai']]
                    ]
                );
            })->ignore($detailJadwal)],
            'id_pegawai' => ['required', Rule::unique('detail_jadwal', 'id_pegawai')->where(
                function ($query) use ($updateData) {
                    return $query->where([
                        ["id_jadwal", "=", $updateData['id_jadwal']],
                        ["id_pegawai", "=", $updateData['id_pegawai']]
                    ]
                );
            })->ignore($detailJadwal)]
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        // $detailJadwal->id_jadwal = $updateData['id_jadwal'];
        // $detailJadwal->id_pegawai = $updateData['id_pegawai'];

        if(DetailJadwal::where('id_pegawai', $id_pegawai)
                        ->where('id_jadwal', $id_jadwal)
                        ->update([
                            'id_pegawai' => $updateData['id_pegawai'],
                            'id_jadwal' => $updateData['id_jadwal']
                        ])) {
            return response([
                'message' => 'Update Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        if($detailJadwal->save()) {
            return response([
                'message' => 'Update Detail Jadwal Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Update Detail Jadwal Failed',
            'data' => null
        ], 400);
    }

    // public function updateByIdJadwal(Request $request, $id) {
    //     $detailJadwal = DetailJadwal::where('id_jadwal', $id)->first();

    //     if(is_null($detailJadwal)) {
    //         return response([
    //             'message' => 'Detail Jadwal Not Found',
    //             'data' => null
    //         ], 404);
    //     }

    //     $updateData = $request->all();
    //     $validate = Validator::make($updateData, [
    //         'id_jadwal' => ['required', Rule::unique('detail_jadwal', 'id_jadwal')->where(
    //             function ($query) use ($updateData) {
    //                 return $query->where([
    //                     ["id_jadwal", "=", $updateData['id_jadwal']],
    //                     ["id_pegawai", "=", $updateData['id_pegawai']]
    //                 ]
    //             );
    //         })->ignore($detailJadwal)],
    //         'id_pegawai' => ['required', Rule::unique('detail_jadwal', 'id_pegawai')->where(
    //             function ($query) use ($updateData) {
    //                 return $query->where([
    //                     ["id_jadwal", "=", $updateData['id_jadwal']],
    //                     ["id_pegawai", "=", $updateData['id_pegawai']]
    //                 ]
    //             );
    //         })->ignore($detailJadwal)]
    //     ]);

    //     if($validate->fails())
    //         return response(['message' => $validate->errors()], 400);

    //     $detailJadwal->id_jadwal = $updateData['id_jadwal'];
    //     $detailJadwal->id_pegawai = $updateData['id_pegawai'];

    //     if($detailJadwal->save()) {
    //         return response([
    //             'message' => 'Update Detail Jadwal Success',
    //             'data' => $detailJadwal
    //         ], 200);
    //     }

    //     return response([
    //         'message' => 'Update Detail Jadwal Failed',
    //         'data' => null
    //     ], 400);
    // }

    public function cekSyaratPenjadwalan(Request $request) {
        $cekData = $request->all();

        $cekJumlahShift = DetailJadwal::where('id_pegawai', $cekData['id_pegawai'])->count();
        
        if($cekJumlahShift == 6) {
            return response([
                'message' => '1 Pegawai maksimal 6 shift',
            ], 400);
        }

        return response([
            'message' => 'OK'
        ], 200);
    }
}
