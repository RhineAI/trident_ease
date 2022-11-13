<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\ReturPenjualan;
use Illuminate\Http\Request;

class ListReturPenjualanController extends Controller
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
        
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['transaksi'] = ReturPenjualan::leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_retur_penjualan.id_penjualan')
        ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
        ->select('t_retur_penjualan.*', 'P.nama AS nama_pelanggan')->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->get();
   
       return view('returPenjualan.listRetur', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }

    public function getData($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $retur = ReturPenjualan::where('t_retur_penjualan.tgl', 'Like', '%'.$tanggal.'%')
                                            ->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_retur_penjualan.id_penjualan')
                                            ->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')
                                            ->select('t_retur_penjualan.*', 'P.nama AS nama_pelanggan')
                                            
                                            ->orderBy('t_retur_penjualan.id', 'desc')->get();
                                            // return $retur;

            foreach($retur as $item) {
                // dd($item); die;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['id'] = '<span class="badge badge-info">'. $item->id .'</span>';
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['nama_pelanggan'] = $item->nama_pelanggan;
                $row['total_retur'] = 'RP. '. format_uang($item->total_retur);
                
                $row['action'] = '<a href="'. route('admin.list-retur-penjualan.print_nota', $item->id) .'" class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></a>';

                $data[] = $row;
            }         
            // return $data;   

        }

        return datatables()
            ->of($data)
            ->rawColumns(['action', 'id'])
            ->make(true);

        return $data;

    }

    public function printNota($id){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['cReturPenjualan'] = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')->leftJoin('t_transaksi_penjualan AS TP', 'TP.id', 't_retur_penjualan.id_penjualan')->leftJoin('t_pelanggan AS P', 'P.id', 'TP.id_pelanggan')->select('P.nama AS nama_pelanggan', 't_retur_penjualan.id AS id_retur', 't_retur_penjualan.id_penjualan AS id_transaksi', 't_retur_penjualan.tgl AS tgl_retur', 't_retur_penjualan.total_retur', 't_retur_penjualan.retur_keuntungan')->where('t_retur_penjualan.id', $id)->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->first();
        $data['cDetailReturPenjualan'] = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')->select('DRP.qty', 'DRP.harga_beli', 'DRP.harga_jual', 'B.nama AS nama_barang')->where('t_retur_penjualan.id', $id)->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->get();
        // dd($data['cDetailPenjualan']); die;
        return view('returPenjualan.printNota', $data);
    }
}
