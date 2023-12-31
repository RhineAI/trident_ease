<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class ListTransaksiPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->perusahaan->grade >= 2) {
                // User has super access, allow all actions
                return $next($request);
            } else {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses');
            }
        });
    }
    
    public function index(Request $request)
    {  
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $now = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != $now && $request->has('tanggal_akhir') && $request->tanggal_akhir != "") {
            $tanggalAwal = date('Y-m-d', strtotime($request->tanggal_awal));
            $tanggalAkhir = date('Y-m-d', strtotime($request->tanggal_akhir));
        } else {
            $tanggalAwal = date('Y-m-d', strtotime($now));
            $tanggalAkhir = date('Y-m-d', strtotime($now));
        }

        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['transaksi'] = Pembelian::select('*')->where('id', auth()->user()->id_perusahaan)->get();
   
       return view('transaksi-pembelian.listTransaksi', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }

    public function getData($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $pembelian = Pembelian::where('tgl', 'Like', '%'.$tanggal.'%')
                                            ->leftJoin('t_supplier AS P', 'P.id', 't_transaksi_pembelian.id_supplier')
                                            ->select('t_transaksi_pembelian.*', 'P.nama AS nama_supplier')         
                                            ->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'desc')->get();
                                            // return $pembelian;

            foreach($pembelian as $item) {
                if($item->jenis_pembayaran == 1) {
                    $jenis = '<span class="badge badge-info">Cash</span>';
                } elseif($item->jenis_pembayaran == 2) {
                    $jenis = '<span class="badge badge-danger">Kredit</span>';
                } elseif($item->jenis_pembayaran == 3) {
                    $jenis = '<span class="badge badge-success">Transfer</span>';
                }

                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['nama_supplier'] = ucfirst($item->nama_supplier);
                $row['invoice'] = '<span class="badge badge-info">'. $item->id .'</span>';
                $row['total_pembelian'] = 'RP. '. format_uang($item->total_pembelian);   
                $row['jenis_pembayaran'] = $jenis;   
                $row['action'] = '<a href="'. route('admin.list-pembelian.print_nota', $item->id) .'" class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></a>';

                $data[] = $row;
            }         
            // return $data;   

        }

        return $data;
    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->rawColumns(['action', 'invoice', 'jenis_pembayaran'])
            ->make(true);
    }

    public function printNota($id){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['cPembelian'] = Pembelian::leftJoin('t_detail_pembelian AS DTP', 'DTP.id_pembelian', 't_transaksi_pembelian.id')->leftJoin('t_supplier AS S', 'S.id', 't_transaksi_pembelian.id_supplier')->select('S.nama AS nama_supplier', 't_transaksi_pembelian.id AS id_transaksi', 't_transaksi_pembelian.tgl AS tgl_transaksi', 't_transaksi_pembelian.jenis_pembayaran', 't_transaksi_pembelian.total_pembelian', 't_transaksi_pembelian.bayar', 't_transaksi_pembelian.kembali', 't_transaksi_pembelian.dp', 't_transaksi_pembelian.sisa')->where('t_transaksi_pembelian.id', $id)->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan)->first();
        $data['cDetailPembelian'] = Pembelian::leftJoin('t_detail_pembelian AS DTP', 'DTP.id_pembelian', 't_transaksi_pembelian.id')->leftJoin('t_barang AS B', 'B.id', 'DTP.id_barang')->select('DTP.qty', 'DTP.harga_beli', 'DTP.diskon', 'B.nama AS nama_barang')->where('t_transaksi_pembelian.id', $id)->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan)->get();
        // dd($data['cPembelian']); die;
        return view('transaksi-pembelian.printNota', $data);
    }

//    public function table($awal, $akhir) {
//         $awal = $request->awal;
//         $akhir = $request->akhir;

//         return $awal;
//    }
}
