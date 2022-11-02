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
                
                $row['action'] = '<button class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></button>';

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
}
