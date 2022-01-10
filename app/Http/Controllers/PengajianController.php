<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajianController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->nama_masjid;
        $pengajian = DB::table('pengajian')
                    ->join('masjid', 'masjid.id_masjid', '=', 'pengajian.id_masjid')
                    ->where('nama_masjid', 'ILIKE', "%{$keyword}%")
                    ->get();
                return response($pengajian);
    }
    public function detail(Request $request)
    {
        $keyword = $request->id_masjid;
        $pengajian = DB::table('pengajian')
                    ->where('id_masjid', $keyword)
                    ->get();
                return response($pengajian);
    }
    public function add_pf(Request $request)
    {
        $id_users = $request->id_user;
        $id_pengajian = $request->id_pengajian;
        $i = DB::table('pengajian_favorit')->max('id_pf');

        $pf = DB::table('pengajian_favorit')->insert([
            'id_pf'=>$i+1,
            'id_pengajian'=>$id_pengajian,
            'id_user'=>$id_users
        ]);

        $respon = DB::table('pengajian_favorit')
                    ->where('id_user', $id_users)
                    ->get();
                return response($respon);
    }
    public function pf(Request $request)
    {
        $id_user = $request->id_user;
        $pengajian = DB::table('pengajian_favorit')
                    ->join('pengajian', 'pengajian_favorit.id_pengajian', '=', 'pengajian.id_pengajian')
                    ->where('id_user', $id_user)
                    ->get();
                return response($pengajian);
    }
    public function pt(Request $request)
    {
        $id_user = $request->id_user;
        $pt = DB::table('pengajian_favorit')
                    ->join('pengajian', 'pengajian_favorit.id_pengajian', '=', 'pengajian.id_pengajian')
                    ->orderBy('pengajian.tgl_pengajian', 'desc')
                    ->where('id_user', $id_user)
                    ->first();
                return response($pt);
    }
}