<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Perusahaan;
use App\Models\Satuan;
use App\Models\Supplier;
use Illuminate\Http\Request;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = Kategori::get();
        $data['supplier'] = Supplier::get();
        $data['merek'] = Merek::get();
        $data['satuan'] = Satuan::get();
        $data['perusahaan'] = Perusahaan::get();
        // $data['produk'] = Barang::get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['barang'] = Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
        ->leftJoin('t_supplier AS SP', 'SP.id', 't_barang.id_supplier')
        ->leftJoin('t_satuan AS ST', 'ST.id', 't_barang.id_satuan')
        ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
        ->leftJoin('t_perusahaan AS P', 'P.id', 't_barang.id_perusahaan')
        ->select('t_barang.*', 'K.nama AS nama_kategori', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek', 'P.nama AS nama_perusahaan')
        ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_barang.id', 'desc')
        ->get();

        // $brg = Barang::all();
        // return $brg;
        // $cek = Merek::where('id', $brg->id_merek)->get();
        // return $cek;
        
        // dd($data['barang']); die;
        return view('barang.index', $data);
    }

    public function index2(){
        $data['categories'] = Kategori::get();
        $data['supplier'] = Supplier::get();
        $data['merek'] = Merek::get();
        $data['satuan'] = Satuan::get();
        $data['perusahaan'] = Perusahaan::get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('barang.tambah', $data);
    }


    public function checkPrice($value)
    {
        if (gettype($value) == "string") {
            $temp = 0;
            for ($i = 0; $i < strlen($value); $i++) {
                if ((isset($value[$i]) == true && $value[$i] != ".") && $value[$i] != ",") {
                    $temp = ($temp * 10) + (int)$value[$i];
                }
            }
            return $temp;
        } else {
            return $value;
        }
    }

    public function data()
    {
        $barang = Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
                    ->leftJoin('t_supplier AS SP', 'SP.id', 't_barang.id_supplier')
                    ->leftJoin('t_satuan AS ST', 'ST.id', 't_barang.id_satuan')
                    ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
                    ->select('t_barang.*', 'K.nama AS nama_kategori', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek')     
                    ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan)     
                    ->orderBy('id', 'desc')
                    ->get();


        return datatables()
            ->of($barang)
            ->addIndexColumn()
            ->addColumn('kode', function ($barang) {
                return '<span class="badge" style="background-color:#2f3d57; color:white;">'. $barang->kode .'</span>';
            })
            ->addColumn('harga_beli', function ($barang) {
                return 'Rp. '. format_uang($barang->harga_beli);
            })
            ->addColumn('stock', function ($barang) {
                if($barang->stock == 0)
                {
                    return '<span class="badge badge-danger">Habis</span>';
                }
                else{
                    return format_uang($barang->stock);
                }
            })
            ->addColumn('status', function ($barang) {
                if($barang->status == 1) {
                    return '<span class="badge badge-primary">Aktif</span>';
                } else {
                    return '<span class="badge badge-danger">Tidak Aktif</span>';
                }
            })
            ->addColumn('action', function($barang) { 
                return '
                        <button data-nama="'.$barang->nama.'"
                                data-kode="'.$barang->kode.'"
                                data-barcode="'.$barang->barcode.'"
                                data-id_kategori="'.$barang->id_kategori.'"
                                data-id_supplier="'.$barang->id_supplier.'"
                                data-id_satuan="'.$barang->id_satuan.'"
                                data-id_merek="'.$barang->id_merek.'"
                                data-id_perusahaan="'.$barang->id_perusahaan.'"
                                data-satuan="'.$barang->id_satuan.'"
                                data-stock="'.$barang->stock.'"
                                data-stock_minimal="'.$barang->stock_minimal.'"
                                data-harga_beli="'.$barang->harga_beli.'"
                                data-keuntungan="'.$barang->keuntungan.'"
                                data-keterangan="'.$barang->keterangan.'"
                                data-status="'.$barang->status.'"
                                data-route="'. route('admin.barang.update', $barang->id) .'" 
                        class="edit btn btn-xs btn-success"><i class="fa fa-pencil"></i></button>     
                        <button onclick="deleteForm(`'. route('admin.barang.destroy', $barang->id) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                    '; 
                })
            ->rawColumns(['action', 'kode', 'stock', 'status'])
            ->make(true);
    }

    // <button onclick="editData(`'. route('barang.update', $barang->id).'`)" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></button>
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        // dd($request); die;
        // $input['harga_beli'] = $this->checkPrice($request->harga_beli);
        // $input['id_perusahaan'] =  auth()->user()->id_perusahaan;
        // $input = $request->all();

        // $input = Barang::create($request->all());
        $barang = new Barang();
        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->barcode = $request->barcode;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->id_supplier = $request->id_supplier;
        $barang->id_merek = $request->id_merek;
        $barang->id_perusahaan = auth()->user()->id_perusahaan;
        $barang->tgl = date('Y-m-d');
        $barang->stock = $request->stock;
        $barang->stock_minimal = $request->stock_minimal;
        $barang->harga_beli = $this->checkPrice($request->harga_beli);
        $barang->keuntungan = $request->keuntungan;
        $barang->status = $request->status;
        $barang->keterangan = $request->keterangan;

        // $now = now();
        // $tglBarang = Barang::all();
        $now = date('Y-m-d');
        // return $tglBarang;
        // $perusahaan = Perusahaan::all()->where('id', auth()->user()->id_perusahaan);
        $perusahaan = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        $limit = Barang::whereDate('created_at', $now)->where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        
        // $c = Barang::all();
        // return $limit;
            if($perusahaan->grade == 1) {
                if($limit < 10 ) {
                    $barang->save();
                    return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);
                }else {
                    return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                }
            } elseif($perusahaan->grade == 2) {
                if($limit < 50 ) {
                    $barang->save();
                    return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);
                }else {
                    return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                }
            } elseif($perusahaan->grade == 3) {
                if($limit < 10000 ) {
                    $barang->save();
                    return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);                    
                }else {
                    return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
                }
            } else{
                return redirect()->route('logout')->with(['error' => 'Lu siapa??']);
            }

        return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarangRequest  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $barang = Barang::find($id);
        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->barcode = $request->barcode;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->id_supplier = $request->id_supplier;
        $barang->id_merek = $request->id_merek;
        $barang->id_perusahaan = auth()->user()->id_perusahaan;
        $barang->tgl = now();
        $barang->stock = $request->stock;
        $barang->stock_minimal = $request->stock_minimal;
        $barang->harga_beli = $this->checkPrice($request->harga_beli);
        $barang->keuntungan = $request->keuntungan;
        $barang->status = $request->status;
        $barang->keterangan = $request->keterangan;
        $barang->update();
        // return $barang;

        return back()->with('success', 'Update Data berhasil');
        // return redirect('/barang')->with('success', 'Update Data berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return back()->with('success', 'Update Data berhasil');
        // return redirect('/barang')->with('delete', 'Delete Data berhasil');
    }
}
