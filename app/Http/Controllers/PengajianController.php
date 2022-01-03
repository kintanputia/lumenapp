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
                    ->where('id', $keyword)
                    ->get();
                return response($pengajian);
    }
}