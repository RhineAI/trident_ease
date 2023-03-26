<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use App\Models\Merek;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Exports\TemplateDownload;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Maatwebsite\Excel\Facades\Excel;


class BarangController extends Controller
{
    public function index()
    {
        $data['categories'] = Kategori::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['supplier'] = Supplier::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['merek'] = Merek::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['satuan'] = Satuan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();
        $data['perusahaan'] = Perusahaan::where('id', auth()->user()->id_perusahaan)->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        // ambil data kategori, supplier, merek, perusahaan dari perusahaan yang sedang login
        return view('barang.index', $data);
        // return tampilan index barang
    }

    public function checkPrice($value)
    {
        // cek jika parameter $value berupa string
        if (gettype($value) == "string") {
            $temp = 0;
            // deklarasi variabel temp
            for ($i = 0; $i < strlen($value); $i++) {
                if ((isset($value[$i]) == true && $value[$i] != ".") && $value[$i] != ",") {
                    $temp = ($temp * 10) + (int)$value[$i];
                }
            }
            // jika iya maka lakukan perulangan untuk menghilangkan tanda titik dan koma kemudia simpan bilangan ke $temp

            return $temp;
        } else {
        // jika parameter bukan string maka return parameter kembali
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
                    ->where('t_barang.keterangan', 'LIKE' ,'%utama%')    
                    ->orderBy('id', 'desc')
                    ->get();
        // Ambil data dari tabel barang yang di join kan dengan tabel supplier, satuan, dan merek dari perusahaan yang sedang login dan dengan kondisi jenis barang = utama

        return datatables()
        ->of($barang)
        // kembalikan data $barang berupa datatable dari variabel barang
            ->addIndexColumn()
            // tambahkan semua properti pada variabel barang ke datatable
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
                ->addColumn('keterangan', function($barang){
                    return '<p>'. ucfirst($barang->keterangan) .'</p>';
                })
                // tambahkan kolom dengan tampilan khusus (html special chars)
            ->rawColumns(['action', 'kode', 'stock', 'status', 'keterangan'])
            // deklarasikan kolom tengan tampilan khusus
            ->make(true);
    }

    // public function dataKonsinyasi()
    // {
    //     $barang = Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
    //                 ->leftJoin('t_supplier AS SP', 'SP.id', 't_barang.id_supplier')
    //                 ->leftJoin('t_satuan AS ST', 'ST.id', 't_barang.id_satuan')
    //                 ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
    //                 ->select('t_barang.*', 'K.nama AS nama_kategori', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek')     
    //                 ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan) 
    //                 ->where('t_barang.keterangan', 'konsinyasi')    
    //                 ->orderBy('id', 'desc')
    //                 ->get();


    //     return datatables()
    //         ->of($barang)
    //         ->addIndexColumn()
    //         ->addColumn('kode', function ($barang) {
    //             return '<span class="badge" style="background-color:#2f3d57; color:white;">'. $barang->kode .'</span>';
    //         })
    //         ->addColumn('harga_beli', function ($barang) {
    //             return 'Rp. '. format_uang($barang->harga_beli);
    //         })
    //         ->addColumn('stock', function ($barang) {
    //             if($barang->stock == 0)
    //             {
    //                 return '<span class="badge badge-danger">Habis</span>';
    //             }
    //             else{
    //                 return format_uang($barang->stock);
    //             }
    //         })
    //         ->addColumn('status', function ($barang) {
    //             if($barang->status == 1) {
    //                 return '<span class="badge badge-primary">Aktif</span>';
    //             } else {
    //                 return '<span class="badge badge-danger">Tidak Aktif</span>';
    //             }
    //         })
    //         ->addColumn('action', function($barang) { 
    //             return '
    //                     <button data-nama="'.$barang->nama.'"
    //                             data-kode="'.$barang->kode.'"
    //                             data-barcode="'.$barang->barcode.'"
    //                             data-id_kategori="'.$barang->id_kategori.'"
    //                             data-id_supplier="'.$barang->id_supplier.'"
    //                             data-id_satuan="'.$barang->id_satuan.'"
    //                             data-id_merek="'.$barang->id_merek.'"
    //                             data-id_perusahaan="'.$barang->id_perusahaan.'"
    //                             data-satuan="'.$barang->id_satuan.'"
    //                             data-stock="'.$barang->stock.'"
    //                             data-stock_minimal="'.$barang->stock_minimal.'"
    //                             data-harga_beli="'.$barang->harga_beli.'"
    //                             data-keuntungan="'.$barang->keuntungan.'"
    //                             data-keterangan="'.$barang->keterangan.'"
    //                             data-status="'.$barang->status.'"
    //                             data-route="'. route('admin.barang.update', $barang->id) .'" 
    //                     class="edit btn btn-xs btn-success"><i class="fa fa-pencil"></i></button>     
    //                     <button onclick="deleteForm(`'. route('admin.barang.destroy', $barang->id) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
    //                 '; 
    //             })
    //             ->addColumn('keterangan', function($barang){
    //                 return '<p>'. ucfirst($barang->keterangan) .'</p>';
    //             })
    //         ->rawColumns(['action', 'kode', 'stock', 'status', 'keterangan'])
    //         ->make(true);
    // }

    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        $barang = new Barang();
        // Deklarasi variabel baru bernama barang yang akan diisi object baru

        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->barcode = $request->barcode;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->id_supplier = $request->id_supplier;
        $barang->id_merek = $request->id_merek;
        $barang->stock = $request->stock;
        $barang->stock_minimal = $request->stock_minimal;
        $barang->keuntungan = $request->keuntungan;
        $barang->status = $request->status;
        $barang->keterangan = $request->keterangan;
        // isi properti kode, nama, barcode, id_kategori, id_satuan, id_supplier, id_merek, stock, stock_minimal, keuntungan, status, dan keterangan pada $barang berdasarkan input dari user

        $barang->id_perusahaan = auth()->user()->id_perusahaan;
        // isi properti id_perusahaan pada $barang berdasarkan id_perusahaan dari user yang sedang login

        $barang->tgl = date('Y-m-d');
        // isi properti tgl pada $barang berdasarkan tanggal user melakukan submit
        
        $barang->harga_beli = $this->checkPrice($request->harga_beli);
        // isi properti harga_beli pada $barang berdasarkan input harga_beli dari user yang telah diperiksa format harga nya 
       
        $perusahaan = Perusahaan::where('id', auth()->user()->id_perusahaan)->first();
        // ambil data perusahaan yang sedang login

        $limit = Barang::whereDate('tgl', date('Y-m-d'))->where('id_perusahaan', auth()->user()->id_perusahaan)->count();
        // hitung jumlah input barang yang telah dilakukan oleh perusahaan yang sedang login
        
        if($perusahaan->grade == 1) {
            // pengecekan level akses perusahaan 
            if($limit < 10 ) {
            // cek jumlah input barang perusahaan yang login jika kurang dari 10 lakukan simpan ke database
                $barang->save();
                if ($barang->keterangan == 'utama' or $barang->keterangan == 'Utama') {
                    return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);
                } elseif ($barang->keterangan == 'konsinyasi' or $barang->keterangan == 'Konsinyasi') {
                    return redirect()->route('admin.barang.indexKonsinyasi')->with(['success' => 'Berhasil Disimpan']);
                }
            } else {
            // jika sudah melebihi 10 makan return false
                return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
            }
        } elseif($perusahaan->grade == 2) {
            if($limit < 50 ) {
            // cek jumlah input barang perusahaan yang login jika kurang dari 50 lakukan simpan ke database
                $barang->save();
                if ($barang->keterangan == 'utama' or $barang->keterangan == 'Utama') {
                    return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);
                } elseif ($barang->keterangan == 'konsinyasi' or $barang->keterangan == 'Konsinyasi') {
                    return redirect()->route('admin.barang.indexKonsinyasi')->with(['success' => 'Berhasil Disimpan']);
                }
            }else {
            // jika sudah melebihi 50 makan return false
                return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
            }
        } elseif($perusahaan->grade == 3) {
            if($limit < 10000 ) {
            // cek jumlah input barang perusahaan yang login jika kurang dari 10000 lakukan simpan ke database
                $barang->save();
                if ($barang->keterangan == 'utama' or $barang->keterangan == 'Utama') {
                    return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);
                } elseif ($barang->keterangan == 'konsinyasi' or $barang->keterangan == 'Konsinyasi') {
                    return redirect()->route('admin.barang.indexKonsinyasi')->with(['success' => 'Berhasil Disimpan']);
                }                    
            }else {
            // jika sudah melebihi 10000 makan return false
                return view('dashboard')->with(['error' => 'Sudah mencapai limit barang, Naikan levelmu terlebih dahulu!']);
            }
        } else{
            // cek jika ada level perusahaan berbeda dengan ketentuan
            return redirect()->route('logout')->with(['error' => 'Anda tidak memiliki akses!']);
        }

        // Jika melewati pengecekan return true
        return redirect()->route('admin.barang.index')->with(['success' => 'Berhasil Disimpan']);
    }

    public function show(Barang $barang)
    {
        //
    }

    public function edit(Barang $barang)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        // cari data barang pada database berdasarkan parameter route
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
        // Update semua properti berdasarkan request

        $barang->update();
        // Simpan perubahan ke database

        return back()->with('success', 'Update Data berhasil');
        // return true
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        // Hapus row data parameter route dari dataabase
        return back()->with('success', 'Update Data berhasil');
        // return true
    }

    public function downloadBarang(){
        $cPerusahaan = auth()->user()->id_perusahaan;
        // Ambil id perusahaan yang sedang login
        $model = Barang::leftJoin('t_kategori AS K', 'K.id', 't_barang.id_kategori')
        ->leftJoin('t_supplier AS SP', 'SP.id', 't_barang.id_supplier')
        ->leftJoin('t_satuan AS ST', 'ST.id', 't_barang.id_satuan')
        ->leftJoin('t_merek AS M', 'M.id', 't_barang.id_merek')
        ->select('t_barang.id', 't_barang.kode', 't_barang.nama', 't_barang.barcode', 'K.nama AS nama_kategori', 'SP.nama AS nama_supplier', 'ST.nama AS nama_satuan', 'M.nama AS nama_merek', 't_barang.stock', 't_barang.stock_minimal', 't_barang.harga_beli', 't_barang.keuntungan', 't_barang.status')     
        ->where('t_barang.id_perusahaan', auth()->user()->id_perusahaan) 
        ->orderBy('id', 'desc')
        ->get();
        // Ambil data dari tabel barang yang di join kan dengan tabel supplier, satuan, dan merek dari perusahaan yang sedang login

        return Excel::download(new BarangExport($cPerusahaan, $model), date('d-m-Y').'_Data-Barang.xlsx');
        // return file fownload excel dari class BarangExport berdasarkan modal
    }
}
