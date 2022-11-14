<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;

class ListTransaksiPenjualanController extends Controller
{
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
        $data['transaksi'] = TransaksiPenjualan::select('*')->where('id', auth()->user()->id_perusahaan)->get();
   
       return view('transaksi-penjualan.listTransaksi', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }

    public function getData($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $penjualan = TransaksiPenjualan::where('tgl', 'Like', '%'.$tanggal.'%')
                                            ->leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
                                            ->select('t_transaksi_penjualan.*', 'P.nama AS nama_pelanggan')
                                            ->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)
                                            ->orderBy('id', 'desc')->get();
                                            // return $penjualan;

            foreach($penjualan as $item) {
                // return $item;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['nama_pelanggan'] = ucfirst($item->nama_pelanggan);
                $row['invoice'] = '<span class="badge badge-info">'. $item->id .'</span>';
                $row['total_harga'] = 'RP. '. format_uang($item->total_harga);
                
                $row['action'] = '<a href="'. route('admin.list-transaksi.print_nota', $item->id) .'" class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></a>';

                $data[] = $row;
            }         
            // return $data;   

        }

        // return $data;


        // $data[] = [
        //     'DT_RowIndex' => '',
        //     'tgl' => '',
        //     'invoice' => '',
        //     'total_harga' => '',
        //     'nama_pelanggan' => '',
        //     'action' => '',
        // ];

        // return $data;

        return datatables()
            ->of($data)
            ->rawColumns(['action', 'invoice'])
            ->make(true);

        return $data;

    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->rawColumns(['action', 'invoice'])
            ->make(true);
    }

    public function printNota($id){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['cPenjualan'] = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 't_transaksi_penjualan.id')->leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')->select('P.nama AS nama_pelanggan', 't_transaksi_penjualan.id AS id_transaksi', 't_transaksi_penjualan.tgl AS tgl_transaksi', 't_transaksi_penjualan.jenis_pembayaran', 't_transaksi_penjualan.total_harga', 't_transaksi_penjualan.total_bayar', 't_transaksi_penjualan.dp', 't_transaksi_penjualan.sisa')->where('t_transaksi_penjualan.id', $id)->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->first();
        $data['cDetailPenjualan'] = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 't_transaksi_penjualan.id')->leftJoin('t_barang AS B', 'B.id', 'DTP.id_barang')->select('DTP.qty', 'DTP.harga_jual', 'DTP.diskon', 'B.nama AS nama_barang')->where('t_transaksi_penjualan.id', $id)->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->get();
        // dd($data['cDetailPenjualan']); die;
        return view('transaksi-penjualan.printNota', $data);
    }

//    public function table($awal, $akhir) {
//         $awal = $request->awal;
//         $akhir = $request->akhir;

//         return $awal;
//    }
}
