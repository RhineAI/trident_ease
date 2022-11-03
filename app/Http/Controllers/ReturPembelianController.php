<?php

namespace App\Http\Controllers;

use App\Models\ReturPembelian;
use App\Http\Requests\StoreReturPembelianRequest;
use App\Http\Requests\UpdateReturPembelianRequest;
use App\Models\Barang;
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
        // dd($data['pembelian']); die;
        return view('returPembelian.index', $data);
    }

    // original (opsi terakhir)
    // public function data(Request $request){
    //     $detailPembelian = Pembelian::leftJoin('t_detail_pembelian AS DT', 't_transaksi_pembelian.id', 'DT.id_pembelian')
    //     ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
    //     ->select('DT.harga_beli', 'DT.qty', 't_transaksi_pembelian.id AS id_pembelian', 't_transaksi_pembelian.tgl AS tanggal', 'B.nama AS nama_barang', 'B.id AS id_barang', 'B.harga_beli', 'B.kode')
    //     ->where('t_transaksi_pembelian.id', $request->id)     
    //     ->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan)     
    //     ->orderBy('t_transaksi_pembelian.id', 'desc')
    //     ->get();	

    //     $returPembelian = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')->leftJoin('t_transaksi_pembelian AS TP', 'TP.id', 't_retur_pembelian.id')->leftJoin('t_detail_pembelian AS DTP', 'TP.id', 'DTP.id_pembelian')
    //     ->select('DRP.qty AS jumlah_kembali_barang', 'DRP.id_barang AS id_barang_retur', 'TP.id AS id_pembelian',)
    //     ->where('TP.id', $request->id)   
    //     // ->where('DRP.id_barang', 'DTP.id_barang')
    //     ->where('TP.id_perusahaan', auth()->user()->id_perusahaan)     
    //     ->orderBy('TP.id', 'desc')
    //     ->groupBy('DRP.id_barang')
    //     ->get();	
    //     return $returPembelian;
    //     $i=0;
    //     $html="";

    //    if($detailPembelian){
    //        foreach ($detailPembelian as $key => $row) {
    //            $i++;
    //            $subtotal = $row->qty * $row->harga_beli;
    //            $html.="<tr>";
    //            $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i'></td>";
    //            $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i'></td>";
    //            $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
    //            $html.="<td style='text-align:center; width: 8%;'><input class='form-control' type='number' value='$row->qty' readonly='true' id='qty$i'></td>";
    //            $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right'></td>";
    //            $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_jual='$row->harga_jual' data-harga_beli='$row->harga_beli' data-qty='$row->qty'><i class='fas fa-plus'></i></button></td>";
   
    //            $html.="</tr>";
               
    //        }  
    //        return $html;
    //    } else {
    //        return "<tr id='buffer100' height='50px'>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                </tr>";         
    //    }
    //    // $response['data'] = $html;
    //    // return response()->json($response);
    // }

    // Validasi tidak boleh retur barang yang sudah di retur semua (masih ada bug)
    // public function data(Request $request){
    //     // return $request;
    //     $cekRetur = ReturPembelian::find($request->id);
    //     // return $cekRetur;
    //     if($cekRetur){
    //         $cekRetur = 'DT.id_barang';
    //     } else {
    //         $cekRetur = 'B.id';
    //     }
    //     $detailPembelian = Pembelian::leftJoin('t_detail_pembelian AS DT', 'DT.id_pembelian', 't_transaksi_pembelian.id')->leftJoin('t_retur_pembelian AS RP', 'RP.id_pembelian', 't_transaksi_pembelian.id')->leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 'RP.id')
    //     ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
    //     ->select('DT.harga_beli', 'DT.qty AS jumlah_beli_barang', 'DRP.qty AS jumlah_kembali_barang', 'DRP.id_barang AS id_barang_retur', 't_transaksi_pembelian.id AS id_pembelian', 't_transaksi_pembelian.tgl AS tanggal', 'B.nama AS nama_barang', 'DT.id_barang AS id_barang_pembelian', 'B.id AS id_barang', 'B.harga_beli', 'B.kode')
    //     ->where('t_transaksi_pembelian.id', $request->id) 
    //     ->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan) 
    //     // ->where(function($query){
    //     //     $query->where('DRP.qty', 'IS NOT', null)->groupBy('DRP.id_barang')->orWhere('DRP.qty', 'IS', null);
    //     // })   
    //     ->groupBy($cekRetur)
    //     ->orderBy('t_transaksi_pembelian.id', 'desc')
    //     ->get();	
    //     $i=0;
    //     $html="";
    //     return $detailPembelian;
    //    if($detailPembelian){
    //        foreach ($detailPembelian as $row) {
    //            $i++;
    //            $subtotal = $row->jumlah_beli_barang * $row->harga_beli;
    //            $html.="<tr>";
    //            $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i'></td>";
    //            $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i'></td>";
    //            $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
    //            $html.="<td style='text-align:center; width: 8%;'><input class='form-control' type='number' value='$row->jumlah_beli_barang' readonly='true' id='qty$i'></td>";
    //            $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right'></td>";
               
    //         //    return ['id_barang_retur' => $row->id_barang_retur, 'id_barang' => $row->id_barang];
    //         //    if($row->id_barang_retur == $row->id_barang_pembelian){
    //             $cekBarang = $row->jumlah_beli_barang - $row->jumlah_kembali_barang;
    //             if($cekBarang == 0){
    //                 $html.="<td style='text-align:center;'><button type='button' class='btn btn-info restrict-retur'><i class='fas fa-plus'></i></button></td>";
    //             } else {
    //                 $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_beli='$row->harga_beli' data-qty='$row->jumlah_beli_barang'><i class='fas fa-plus'></i></button></td>";
    //             }   
    //         //    } else {
    //         //         $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_beli='$row->harga_beli' data-qty='$row->jumlah_beli_barang'><i class='fas fa-plus'></i></button></td>";
    //         //    }
               
   
    //            $html.="</tr>";
               
    //        }  
    //        return $html;
    //    } else {
    //        return "<tr id='buffer100' height='50px'>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                    <td></td>
    //                </tr>";         
    //    }
    //    // $response['data'] = $html;
    //    // return response()->json($response);
    // }

    public function data(Request $request){
        // return $request;
        $detailPembelian = Pembelian::leftJoin('t_detail_pembelian AS DT', 'DT.id_pembelian', 't_transaksi_pembelian.id')
        ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
        ->select('DT.harga_beli', 'DT.qty AS jumlah_beli_barang', 't_transaksi_pembelian.id AS id_pembelian', 't_transaksi_pembelian.tgl AS tanggal', 'B.nama AS nama_barang', 'DT.id_barang AS id_barang_pembelian', 'B.id AS id_barang', 'B.harga_beli', 'B.kode')
        ->where('t_transaksi_pembelian.id', $request->id) 
        ->where('t_transaksi_pembelian.id_perusahaan', auth()->user()->id_perusahaan) 
        ->orderBy('t_transaksi_pembelian.id', 'desc')
        ->get();	

        $qtyRetur = ReturPembelian::leftJoin('t_detail_retur_pembelian AS DRP', 'DRP.id_retur_pembelian', 't_retur_pembelian.id')->select('DRP.qty AS jumlah_kembali_barang', 'DRP.id_barang AS id_barang_retur', 't_retur_pembelian.id_pembelian', 't_retur_pembelian.tgl')
        ->where('t_retur_pembelian.id_pembelian', $request->id) 
        ->where('t_retur_pembelian.id_perusahaan', auth()->user()->id_perusahaan) 
        ->orderBy('t_retur_pembelian.id_pembelian', 'desc')
        ->get();
        $i=0;
        $html="";
        // return count($qtyRetur);
        if($detailPembelian){
            foreach ($detailPembelian as $key => $row) {
                $i++;
                $subtotal = $row->jumlah_beli_barang * $row->harga_beli;
                $html.="<tr>";
                $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
                $html.="<td style='text-align:center; width: 8%;'><input class='form-control' type='number' value='$row->jumlah_beli_barang' readonly='true' id='qty$i'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right'></td>";
                
            //    return ['id_barang_retur' => $row->id_barang_retur, 'id_barang' => $row->id_barang];
            //    if($row->id_barang_retur == $row->id_barang_pembelian){
                if(count($qtyRetur) != 0){
                    $cekBarang = $row->jumlah_beli_barang - $qtyRetur[$key]->jumlah_kembali_barang;
                    if($cekBarang == 0){
                        $html.="<td style='text-align:center;'><button type='button' class='btn btn-info restrict-retur'><i class='fas fa-plus'></i></button></td>";
                    } else {
                        $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_beli='$row->harga_beli' data-qty='$row->jumlah_beli_barang'><i class='fas fa-plus'></i></button></td>";
                    }
                } else {
                    $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_beli='$row->harga_beli' data-qty='$row->jumlah_beli_barang'><i class='fas fa-plus'></i></button></td>";
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
        // return $request;
        $returBaru = new ReturPembelian();

        if(ReturPembelian::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first() == null){
            $indexTransaksi = sprintf("%05d", 1);
            $returBaru->id = date('Ymd'). $indexTransaksi;
        }

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
            $detReturBaru->sub_total = $barang['harga_beli_retur'] * $barang['qty_retur'];
            $detReturBaru->keuntungan = $barang['harga_beli_retur'] - $barang['harga_beli_retur'];
            $detReturBaru->id_perusahaan = auth()->user()->id_perusahaan;
            $detReturBaru->save();

            $barangUpdate = Barang::find($barang['id_barang_retur']);
            $barangUpdate->stock += $barang['qty_retur'];
            $barangUpdate->update();
        }
        return redirect()->route('list-retur-pembelian.index')->with(['success' => 'Retur Pembelian Berhasil']);
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
