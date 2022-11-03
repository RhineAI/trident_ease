<?php

namespace App\Http\Controllers;

use App\Models\ReturPenjualan;
use App\Http\Requests\StoreReturPenjualanRequest;
use App\Http\Requests\UpdateReturPenjualanRequest;
use App\Models\Barang;
use App\Models\DetailReturPenjualan;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReturPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['penjualan'] = TransaksiPenjualan::leftJoin('t_pelanggan AS P', 'P.id', 't_transaksi_penjualan.id_pelanggan')
        ->select('t_transaksi_penjualan.id AS id_penjualan', 't_transaksi_penjualan.tgl AS tanggal', 'P.nama AS nama_pelanggan', 'P.id AS id_pelanggan', 'P.tlp')
        ->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_transaksi_penjualan.id', 'desc')
        ->get();
        // dd($data['penjualan']);
        return view('returPenjualan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function data(Request $request){
         $detailPenjualan = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DT', 't_transaksi_penjualan.id', 'DT.id_penjualan')
         ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
         ->select('DT.harga_jual', 'DT.qty AS jumlah_beli_barang', 't_transaksi_penjualan.id AS id_penjualan', 't_transaksi_penjualan.tgl AS tanggal', 'B.nama AS nama_barang', 'B.id AS id_barang', 'B.harga_beli', 'B.kode')
         ->where('t_transaksi_penjualan.id', $request->id)     
         ->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)     
         ->orderBy('t_transaksi_penjualan.id', 'desc')
         ->get();	

        $qtyRetur = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')->select('DRP.qty AS jumlah_kembali_barang', 'DRP.id_barang AS id_barang_retur', 't_retur_penjualan.id_penjualan', 't_retur_penjualan.tgl')
        ->where('t_retur_penjualan.id_penjualan', $request->id) 
        ->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan) 
        ->orderBy('t_retur_penjualan.id_penjualan', 'desc')
        ->get();


         $i=0;
         $html="";

        if($detailPenjualan){
            foreach ($detailPenjualan as $key => $row) {
                $i++;
                $subtotal = $row->jumlah_beli_barang * $row->harga_jual;
                $html.="<tr>";
                $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$row->harga_jual' readonly='true' id='harga_jual$i' style='text-align:right'><input class='form-control' type='hidden' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
                $html.="<td style='text-align:center; width: 8%;'><input class='form-control' type='number' value='$row->jumlah_beli_barang' readonly='true' id='qty$i'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right'></td>";

                if(count($qtyRetur) != 0){
                    $cekBarang = $row->jumlah_beli_barang - $qtyRetur[$key]->jumlah_kembali_barang;
                    if($cekBarang == 0){
                        $html.="<td style='text-align:center;'><button type='button' class='btn btn-info restrict-retur'><i class='fas fa-plus'></i></button></td>";
                    } else {
                        $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_jual='$row->harga_jual' data-harga_beli='$row->harga_beli' data-qty='$row->qty'><i class='fas fa-plus'></i></button></td>";
                    }
                } else {
                    $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_jual='$row->harga_jual' data-harga_beli='$row->harga_beli' data-qty='$row->qty'><i class='fas fa-plus'></i></button></td>";
                }

                
    
                $html.="</tr>";
                
            }  
            return $html;
        } else {
            return "<tr id='buffer100' height='50px'>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>";         
        }
        // $response['data'] = $html;
        // return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReturPenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturPenjualanRequest $request)
    {
        // dd($request);
        $returBaru = new ReturPenjualan();

        if(ReturPenjualan::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first() == null){
            $indexTransaksi = sprintf("%05d", 1);
            $returBaru->id = date('Ymd'). $indexTransaksi;
        }
        
        $returBaru->id_penjualan = $request->id_penjualan;
        $returBaru->tgl = date('Y-m-d');
        $returBaru->total_retur = $request->total_retur;
        $returBaru->retur_keuntungan = $request->retur_keuntungan; 
        $returBaru->id_user = auth()->user()->id; 
        $returBaru->id_perusahaan = auth()->user()->id_perusahaan;
        $returBaru->save(); 

        foreach($request->item as $barang){
            $detReturBaru = new DetailReturPenjualan();
            $detReturBaru->id_retur_penjualan = $returBaru->id;
            $detReturBaru->id_barang = $barang['id_barang_retur'];
            $detReturBaru->qty = $barang['qty_retur'];
            $detReturBaru->harga_beli = $barang['harga_beli_retur'];
            $detReturBaru->harga_jual = $barang['harga_jual_retur'];
            $detReturBaru->sub_total = $barang['harga_jual_retur'] * $barang['qty_retur'];
            $detReturBaru->keuntungan = $barang['harga_jual_retur'] - $barang['harga_beli_retur'];
            $detReturBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $detReturBaru->save();

            $barangUpdate = Barang::find($barang['id_barang_retur']);
            $barangUpdate->stock += $barang['qty_retur'];
            $barangUpdate->update();

        }
        return redirect()->route('list-retur-penjualan.index')->with(['success' => 'Retur Penjualan Berhasil']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReturPenjualanRequest  $request
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReturPenjualanRequest $request, ReturPenjualan $returPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPenjualan $returPenjualan)
    {
        //
    }
}
