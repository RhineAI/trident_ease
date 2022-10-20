<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // $data['barang'] = Barang::count();
        // ->where('id_perusahaan', auth()->user()->id_perushaan)->first();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('dashboard', $data);
    }
}
