<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class KeuntunganController extends Controller
{
    public function index(){
        // $barang = Barang::where('id_merek', '>', 0)->pluck('id_merek')->toArray();
        $data['kategori'] = Kategori::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['merek'] = Merek::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('keuntungan.index', $data);
    }

    public function store(Request $request){
        if($request->id_merek != 'semua' && $request->id_kategori != 'semua'){
            $cBarang = Barang::where('id_merek', '=', $request->id_merek, 'AND', 'id_kategori', '=', $request->id_kategori)->update([
                'keuntungan' => $request->keuntungan
            ]);
        } else if ($request->id_merek == 'semua' && $request->id_kategori == 'semua'){
            $cBarang = Barang::select('*')->update([
                'keuntungan' => $request->keuntungan
            ]);
        } else if ($request->id_merek == 'semua' && $request->id_kategori != 'semua'){
            $cBarang = Barang::select('*')->update([
                'keuntungan' => $request->keuntungan
            ]);

            $cBarang = Barang::where('id_kategori', $request->id_kategori)->update([
                'keuntungan' => $request->keuntungan
            ]);
        } else if ($request->id_merek != 'semua' && $request->id_kategori == 'semua'){
            $cBarang = Barang::select('*')->update([
                'keuntungan' => $request->keuntungan
            ]);

            $cBarang = Barang::where('id_merek', $request->id_merek)->update([
                'keuntungan' => $request->keuntungan
            ]);
        }

        // return redirect('/keuntungan')->with('success', 'Set Keuntungan Berhasil');
        return redirect()->back()->with(['success' => 'Set Keuntungan berhasil!']);
    }
}
