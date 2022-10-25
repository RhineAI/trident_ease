<?php

namespace App\Http\Controllers;

use App\Models\ReturPenjualan;
use App\Http\Requests\StoreReturPenjualanRequest;
use App\Http\Requests\UpdateReturPenjualanRequest;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    public function data(Request $request){
        if($request->id){
         $detailPenjualan = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DT', 't_transaksi_penjualan.id', 'DT.id_penjualan')
         ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
         ->select('B.*', 'P.*', 'DT.harga_jual', 'DT.qty', 't_transaksi_penjualan.id AS id_penjualan', 't_transaksi_penjualan.tgl AS tanggal', 'B.nama AS nama_barang', 'B.id AS id_barang')
         ->where('t_transaksi_penjualan.id', $request->id)     
         ->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)     
         ->orderBy('t_transaksi_penjualan.id', 'desc')
         ->get();	
         $i=0;
         $html="";
         foreach ($detailPenjualan as $row) {
            $i++;
            $subtotal = $row->qty * $row->harga_jual;
            $html.="<tr>";
            $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i'></td>";
            $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i'></td>";
            $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->harga_jual' readonly='true' id='harga_jual$i' style='text-align:right'><input class='form-control' type='hidden' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
            $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->qty' readonly='true' id='qty$i'></td>";
            $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right'></td>";
            $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' ><i class='glyphicon glyphicon-plus-sign'></i></button></td>";

            $html.="</tr>";
            
        }  
        return $html;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReturPenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturPenjualanRequest $request)
    {
        //
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
