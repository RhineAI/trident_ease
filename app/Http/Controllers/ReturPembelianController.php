<?php

namespace App\Http\Controllers;

use App\Models\ReturPembelian;
use App\Http\Requests\StoreReturPembelianRequest;
use App\Http\Requests\UpdateReturPembelianRequest;
use App\Models\DetailReturPembelian;
use App\Models\Pembelian;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class ReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['pembelian'] = Pembelian::leftJoin('t_supplier AS S', 'S.id', 't_transaksi_pembelian.id_supplier')
        ->select('t_transaksi_pembelian.id AS id_pembelian', 't_transaksi_pembelian.tgl AS tanggal', 'S.nama AS nama_supplier', 'S.id AS id_pelanggan', 'S.tlp')
        ->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_transaksi_pembelian.id', 'desc')
        ->get();
        // dd($data['pembelian']);
        return view('returPembelian.index', $data);
    }

    public function data(Request $request){
        $detailPembelian = Pembelian::leftJoin('t_detail_pembelian AS DT', 't_transaksi_pembelian.id', 'DT.id_pembelian')
        ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
        ->select('DT.harga_jual', 'DT.qty', 't_transaksi_pembelian.id AS id_pembelian', 't_transaksi_pembelian.tgl AS tanggal', 'B.nama AS nama_barang', 'B.id AS id_barang', 'B.harga_beli', 'B.kode')
        ->where('t_transaksi_pembelian.id', $request->id)     
        ->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('t_transaksi_pembelian.id', 'desc')
        ->get();	
        $i=0;
        $html="";

       if($detailPembelian){
           foreach ($detailPembelian as $row) {
               $i++;
               $subtotal = $row->qty * $row->harga_beli;
               $html.="<tr>";
               $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i'></td>";
               $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i'></td>";
               $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
               $html.="<td style='text-align:center; width: 8%;'><input class='form-control' type='number' value='$row->qty' readonly='true' id='qty$i'></td>";
               $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right'></td>";
               $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_jual='$row->harga_jual' data-harga_beli='$row->harga_beli' data-qty='$row->qty'><i class='fas fa-plus'></i></button></td>";
   
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
     * @param  \App\Http\Requests\StoreReturPembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturPembelianRequest $request)
    {
        $returBaru = new ReturPembelian();
        $returBaru->id_pembelian = $request->id_pembelian;
        $returBaru->tgl = date('Y-m-d');
        $returBaru->total_retur = $request->total_retur;
        $returBaru->retur_keuntungan = $request->retur_keuntungan; 
        $returBaru->id_user = auth()->user()->id; 
        $returBaru->id_perusahaan = auth()->user()->id_perusahaan;
        $returBaru->save(); 

        foreach($request->item as $barang){
            $detReturBaru = new DetailReturPembelian();
            $detReturBaru->id_retur_pembelian = $returBaru->id;
            $detReturBaru->id_barang = $barang['id_barang_retur'];
            $detReturBaru->qty = $barang['qty_retur'];
            $detReturBaru->harga_beli = $barang['harga_beli_retur'];
            $detReturBaru->harga_jual = $barang['harga_jual_retur'];
            $detReturBaru->sub_total = $barang['harga_jual_retur'] * $barang['qty_retur'];
            $detReturBaru->keuntungan = $barang['harga_jual_retur'] - $barang['harga_beli_retur'];
            $detReturBaru->save();

            $barangUpdate = Barang::find($barang['id_barang']);
            $barangUpdate->stock += $barang['qty_retur'];
            $barangUpdate->update();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPembelian $returPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPembelian $returPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReturPembelianRequest  $request
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReturPembelianRequest $request, ReturPembelian $returPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPembelian $returPembelian)
    {
        //
    }
}
