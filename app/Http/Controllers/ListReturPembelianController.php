<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\ReturPembelian;
use Illuminate\Http\Request;

class ListReturPembelianController extends Controller
{
    public function index(Request $request){
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
        $data['transaksi'] = ReturPembelian::leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_retur_pembelian.id_pembelian')
        ->leftJoin('t_supplier AS P', 'P.id', 'TP.id_supplier')
        ->select('t_retur_pembelian.*', 'P.nama AS nama_supplier')->where('t_retur_pembelian.id_perusahaan', auth()->user()->id_perusahaan)->get();
   
       return view('returPembelian.listRetur', compact('tanggalAwal', 'tanggalAkhir', 'now'))->with($data);
    }

    public function getData($awal, $akhir){
        $no = 1;
        $data = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $retur = ReturPembelian::where('t_retur_pembelian.tgl', 'Like', '%'.$tanggal.'%')
                                            ->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_retur_pembelian.id_pembelian')
                                            ->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')
                                            ->select('t_retur_pembelian.*', 'S.nama AS nama_supplier')
                                            
                                            ->orderBy('t_retur_pembelian.id', 'desc')->get();
                                            // return $retur;

            foreach($retur as $item) {
                // dd($item); die;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['id'] = '<span class="badge badge-info">'. $item->id .'</span>';
                $row['tgl'] = tanggal_indonesia($tanggal, false);
                $row['nama_supplier'] = $item->nama_supplier;
                $row['total_retur'] = 'RP. '. format_uang($item->total_retur);
                
                $row['action'] = '<a href="'. route('list-retur-pembelian.print_nota', $item->id) .'" class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></a>';

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
        $data['cReturPembelian'] = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_retur_pembelian.id_pembelian')->leftJoin('t_supplier AS S', 'S.id', 'TP.id_supplier')->select('S.nama AS nama_supplier', 't_retur_pembelian.id AS id_retur', 't_retur_pembelian.id_pembelian AS id_transaksi', 't_retur_pembelian.tgl AS tgl_retur', 't_retur_pembelian.total_retur', 't_retur_pembelian.retur_keuntungan')->where('t_retur_pembelian.id', $id)->where('t_retur_pembelian.id_perusahaan', auth()->user()->id_perusahaan)->first();
        $data['cDetailReturPembelian'] = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')->leftJoin('t_barang AS B', 'B.id', 'DRP.id_barang')->select('DRP.qty', 'DRP.harga_beli', 'DRP.harga_jual', 'B.nama AS nama_barang')->where('t_retur_pembelian.id', $id)->where('t_retur_pembelian.id_perusahaan', auth()->user()->id_perusahaan)->get();
        // dd($data['cDetailPembelian']); die;
        return view('returPembelian.printNota', $data);
    }
}
