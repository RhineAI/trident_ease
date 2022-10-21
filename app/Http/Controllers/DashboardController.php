<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Barang;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['barang'] = Barang::where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        $data['penjualan'] = TransaksiPenjualan::sum('total_harga');
        $data['total_penjualan'] = TransaksiPenjualan::count();
        $data['pegawai'] = User::count();
        // return $brg;
        // $data['barang'] = $brg->count();
        // $data['barang'] = Barang::count();
        // ->where('id_perusahaan', auth()->user()->id_perushaan)->first();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

        // return $data;
        return view('dashboard', $data);
    }
}
