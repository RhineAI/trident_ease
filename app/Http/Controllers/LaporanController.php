<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function indexBestPelanggan(Request $request){
        // select count(DTP.id) from t_transaksi_penjualan TP right join t_detail_penjualan DTP on TP.id = DTP.id_penjualan group by id_pelanggan;
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

        $data['bestPelanggan'] = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 't_transaksi_penjualan.id')->select('t_transaksi_penjualan.id_pelanggan', DB::raw('sum(qty) as jumlahBeliBarang'))->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_transaksi_penjualan.id_pelanggan')->get();    
        // dd($data['bestPelanggan']); die;
        $data['transaksi'] = TransaksiPenjualan::select('*')->where('id', auth()->user()->id_perusahaan)->get();
        $data['pelanggan'] = Pelanggan::where('id_perusahaan', auth()->user()->id_perusahaan)->get();    
        // $data['produk'] = Barang::where('stock', '>', 0)->where('status', '==', '1')->get();    
        $data['produk'] = Barang::where('stock', '>', 0)->where('status', '=', '1')->where('id_perusahaan', auth()->user()->id_perusahaan)->get();  
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('laporanPelanggan.index', $data, compact('tanggalAwal', 'tanggalAkhir', 'now'));
    }

    public function getDataBestPelanggan($awal, $akhir)
    {
        // return $awal;
        $no = 1;
        $data = array(); 

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1day", strtotime($awal)));

            $pelangganTerbaik = Pelanggan::leftJoin('t_transaksi_penjualan AS TP', 'TP.id_pelanggan', 't_pelanggan.id')->leftJoin('t_detail_penjualan AS DTP', 'DTP.id_penjualan', 'TP.id')->select('t_pelanggan.id AS id_pelanggan', 't_pelanggan.nama AS nama_pelanggan', 't_pelanggan.tlp AS tlp_pelanggan', 't_pelanggan.alamat AS alamat_pelanggan', DB::raw('sum(DTP.qty) as jumlahBeliBarang'), DB::raw('sum(DTP.qty*DTP.harga_jual) as jumlahBayarBarang'))->where('TP.id_perusahaan', auth()->user()->id_perusahaan)->groupBy('t_pelanggan.id')->orderBy('jumlahBayarBarang', 'DESC')->get();
            // return $pelangganTerbaik;

            foreach($pelangganTerbaik as $item) {
                // return $key;
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['id_pelanggan'] = $item['id_pelanggan'];
                $row['nama_pelanggan'] = $item['nama_pelanggan'];
                $row['tlp_pelanggan'] = $item['tlp_pelanggan'];
                $row['alamat_pelanggan'] = $item['alamat_pelanggan'];
                $row['jumlahBeliBarang'] = $item['jumlahBeliBarang'];
                $row['jumlahBayarBarang'] = $item['jumlahBayarBarang'];

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
            ->rawColumns(['action'])
            ->make(true);

        return $data;

    }

    public function exportPDFBestPelanggan($awal, $akhir)
    {

    }
}
