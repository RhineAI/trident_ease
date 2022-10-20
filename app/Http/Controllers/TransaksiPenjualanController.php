<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\DetailPenjualan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF as pdf;


class TransaksiPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $barang = Barang::orderBy('nama')->get();
        //  $diskon = TransaksiPenjualan::first()->diskon ?? 0;
 
        //  $detail = DetailPenjualan::orderBy('id_penjualan_detail', 'DESC');

        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
   
        return view('transaksi-penjualan.index', $data);
         
    }

    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $total_penjualan = TransaksiPenjualan::where('created_at', 'LIKE', "%$tanggal%");
            // $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');


            
            // $penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            // $penjualan = Penjualan::first();
            $penjualan = TransaksiPenjualan::leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
                                            ->select('t_transaksi_penjualan.*', 'P.nama AS nama_pelanggan')
                                            ->orderBy('id', 'desc')->get();
            
            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            // $row['nota'] = 'INV-202005'. $penjualan->kode_penjualan ;
            $row['pembelian'] = 'Rp. '.format_uang($total_pembelian);
            $row['penjualan'] = 'Rp. '.format_uang($total_penjualan);
            // $row['aksi']        = '<div class="btn-group">
            //                         <button onclick="{{ route(`daftarpenjualan.index`) }}" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i> Detail</button>
            //                     </div>';

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'nota' => '',
            'pembelian' => '',
            'penjualan' => '',
            // 'aksi' => '',
        ];

        return $data;
    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function dataTransaksi()
    {
        $penjualan = TransaksiPenjualan::leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
                                        ->select('t_transaksi_penjualan.*', 'P.nama AS nama_pelanggan')
                                        ->orderBy('id', 'desc')->get();

        return datatables()
        ->of($penjualan)
        ->addIndexColumn()
        ->addColumn('invoice', function($penjualan) {
            return '<span class="badge badge-info">'. $penjualan->id .'</span>';
        })
        ->addColumn('total_bayar', function($penjualan) {
            return 'RP. '. format_uang($penjualan->total_harga);
        })
        ->addColumn('action', function ($penjualan) {
            return '
                <button class="btn btn-xs btn-danger rounded delete"><i class="fa-solid fa-file-pdf"></i></button>
            ';
        })
        ->rawColumns(['action', 'invoice'])
        ->make(true);
    }

    public function listTransaksi(Request $request)
    {
        //  $barang = Barang::orderBy('nama')->get();
        //  $diskon = TransaksiPenjualan::first()->diskon ?? 0;
 
        //  $detail = DetailPenjualan::orderBy('id_penjualan_detail', 'DESC');
       
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        }

        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['transaksi'] = TransaksiPenjualan::select('*')->where('id', auth()->user()->id_perusahaan)->get();
   
       return view('transaksi-penjualan.listTransaksi', $data, compact('tanggalAwal', 'tanggalAkhir'));
    }

    

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
     * @param  \App\Http\Requests\StorePenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
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


    public function store(StorePenjualanRequest $request)
    {
        // dd($request); die;
        if($request->kembali < 0){
            return back()->with('error', 'Uang bayar kurang');
        } else {
            $penjualanBaru = new TransaksiPenjualan();
            // "select max(id)+1 as nextid from t_pembayaran where id like '".$tgl."%'"
            // dd(TransaksiPenjualan::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first()); die;
            if(TransaksiPenjualan::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first() == null){
                $indexTransaksi = sprintf("%05d", 1);
                $penjualanBaru->id = date('Ymd'). $indexTransaksi;
            }

            $penjualanBaru->tgl = date('Y-m-d');
            $penjualanBaru->id_pelanggan = $request->id_pelanggan;
            $penjualanBaru->total_harga = ($request->total_bayar);
            if($request->jenis_pembayaran == '1') {
                $penjualanBaru->total_bayar = $request->bayar;
            } else {
                $penjualanBaru->total_bayar = $request->dp;
            }
            $penjualanBaru->kembalian = $request->kembali;
            $penjualanBaru->dp = $request->dp;
            $penjualanBaru->sisa = $request->sisa;
            $penjualanBaru->jenis_pembayaran = $request->jenis_pembayaran;
            $penjualanBaru->id_user = auth()->user()->id;
            $penjualanBaru->id_perusahaan = auth()->user()->id_perusahaan;
            
            foreach($request->item as $barang){
                // dd($barang['discount']); die;
                $penjualanBaru->keuntungan += $barang['keuntungan'];
                $penjualanBaru->save();
                $detPenjualanBaru = new DetailPenjualan(); 
                $detPenjualanBaru->id_penjualan = $penjualanBaru->id;
                $detPenjualanBaru->id_barang = $barang['id_barang'];
                $detPenjualanBaru->qty = $barang['qty'];
                $detPenjualanBaru->diskon = $barang['discount'];
                $detPenjualanBaru->harga_beli = $barang['harga_beli'];
                $detPenjualanBaru->harga_jual = $barang['harga_jual'];
                $detPenjualanBaru->id_perusahaan = auth()->user()->id_perusahaan;
                $detPenjualanBaru->save();
                
                $barangUpdate = Barang::find($barang['id_barang']);
                $barangUpdate->stock -= $barang['qty'];
                $barangUpdate->update();
                
                // $barangUpdate = Barang::select('stock')->where('id', $barang->id_barang)->first();
                // $kurangiStok = $barangUpdate - $barang->qty;
                // Barang::update([
                //     'stock' => $kurangiStok
                // ]);
            }

            $pembayaranBaru = new Pembayaran();
            $pembayaranBaru->id_penjualan = $penjualanBaru->id;
            $pembayaranBaru->tgl = date('Ymd');
            $pembayaranBaru->total_bayar = $request->total_bayar;
            $pembayaranBaru->id_user = auth()->user()->id;
            $pembayaranBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $pembayaranBaru->save();
            // dd($penjualanBaru->id); die;
            

            return redirect('/list-transaksi')->with(['success' => 'Input data Transaksi Berhasil!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPenjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPenjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenjualanRequest  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenjualanRequest $request, TransaksiPenjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPenjualan $penjualan)
    {
        //
    }

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);
        $pdf  = pdf::loadView('reportpembelian.export_pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');
        
        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }
}
