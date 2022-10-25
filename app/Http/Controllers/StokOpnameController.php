<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class StokOpnameController extends Controller
{
    public function index(){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['produk'] = Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')->select('t_barang.*', 'K.nama AS nama_kategori', 'M.nama AS nama_merek')->where('stock', '>', 0)->where('status', '=', '1')->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)->get();    
        
        return view('stokOpname.index', $data);
    }

    public function updateStock(Request $request){
        // dd($request); die;
        foreach($request->item as $barang){
            $barangUpdate = Barang::find($barang['id_barang']);
            $barangUpdate->stock = $barang['stock'];
            $barangUpdate->update();
        }
        return back()->with(['success' => 'Update Stok Barang berhasil']);
    }
}
