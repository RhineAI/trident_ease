<?php

namespace App\Http\Controllers;

use App\Models\ReturPenjualan;
use App\Http\Requests\StoreReturPenjualanRequest;
use App\Http\Requests\UpdateReturPenjualanRequest;
use App\Models\Barang;
use App\Models\DetailReturPenjualan;
use App\Models\KasKeluar;
use App\Models\KasMasuk;
use App\Models\Pembelian;
use App\Models\Perusahaan;
use App\Models\TransaksiPenjualan;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

        // $teset = DB::table('t_transaksi_penjualan AS TP')->leftJoin('t_detail_penjualan AS DT', 'TP.id', 'DT.id_penjualan')->leftJoin('t_retur_penjualan AS RP', 'RP.id_penjualan', 'TP.id')->leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 'TP.id')->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
        // ->select('DT.harga_jual', 'DT.qty AS jumlah_beli_barang', 'TP.id AS id_penjualan', 'TP.tgl AS tanggal', 'B.nama AS nama_barang', 'B.id AS id_barang', 'B.harga_beli', 'B.kode', 'DRP.qty AS jumlah_kembali_barang')
        // ->where('TP.id', $request->id)     
        // ->where('DT.id_barang', 'DRP.id_barang')
        // ->where('TP.id_perusahaan', auth()->user()->id_perusahaan)     
        // ->orderBy('TP.id', 'desc')
        // ->get();
        // return $teset;

        $detailPenjualan = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DT', 't_transaksi_penjualan.id', 'DT.id_penjualan')
        ->leftJoin('t_barang AS B', 'B.id', 'DT.id_barang')
        ->select('DT.harga_jual', 'DT.qty AS jumlah_beli_barang', 'DT.id_barang', 'DT.diskon', 't_transaksi_penjualan.id AS id_penjualan', 't_transaksi_penjualan.tgl AS tanggal', 'B.nama AS nama_barang', 'B.harga_beli', 'B.kode')
        ->where('t_transaksi_penjualan.id', $request->id)     
        ->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)     
        ->orderBy('DT.id_barang', 'asc')
        ->get();	

        $qtyRetur = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')->select('DRP.id_barang', 'DRP.qtySisa')
        ->where('t_retur_penjualan.id_penjualan', $request->id) 
        // ->whereRaw('DRP.qty IS NOT NULL') 
        ->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan) 
        ->orderBy('DRP.id_barang', 'asc')
        // ->toSql();
        ->get();    
        

        // $array = [$detailPenjualan, $qtyRetur];
        // return $array;
        // return count($qtyRetur);

         $i=0;
         $html="";
        // return $qtyRetur;
        if(count($qtyRetur) == 0){
            foreach ($detailPenjualan as $row) {
                $i++;
                $subtotal = ($row->jumlah_beli_barang * $row->harga_jual) - ($row->jumlah_beli_barang * $row->harga_jual * $row->diskon/100) ;
                $disc = $row->harga_jual - $row->harga_jual * $row->diskon/100;
                $html.="<tr>";
                $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i' style='width: 130px;'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i' style='width: 175px;'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$disc' readonly='true' id='harga_jual$i' style='text-align:right; width: 170px;'><input class='form-control' type='hidden' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
                $html.="<td style='text-align:center; width: 8%;'><input class='form-control' type='number' value='$row->jumlah_beli_barang' readonly='true' id='qty$i' style='width: 90px;'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right; width: 200px;'></td>";
                // return $key;
                $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_jual='$row->harga_jual' data-harga_beli='$row->harga_beli' data-qty='$row->jumlah_beli_barang'><i class='fas fa-plus'></i></button></td>";

                $html.="</tr>";
            }   

            return $html;  
        } else {
            foreach ($detailPenjualan as $row) {
                $i++;
                // return $row->id_barang;
                // Original
                // $qtySisa = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')->select('DRP.id_barang', 'DRP.qtySisa')
                // ->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan) 
                // ->where('t_retur_penjualan.id_penjualan', $request->id) 
                // ->where('DRP.id_barang', $row->id_barang) 
                // ->orderBy('DRP.id_barang', 'asc')
                // ->first(); 

                // if(isset($qtySisa->qtySisa)){
                //     $subtotal = $qtySisa->qtySisa * $row->harga_jual;
                //     $qtySekarang = $qtySisa->qtySisa;
                // } else {
                //     $subtotal = $row->jumlah_beli_barang * $row->harga_jual;
                //     $qtySekarang = $row->jumlah_beli_barang;
                // }

                $qtySisa = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')->select('DRP.id_barang', 'DRP.qtySisa')
                ->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan) 
                ->where('t_retur_penjualan.id_penjualan', $request->id) 
                ->where('DRP.id_barang', $row->id_barang) 
                ->orderBy('DRP.id', 'desc')
                ->first(); 

                if(isset($qtySisa->qtySisa)){
                    $subtotal = ($qtySisa->qtySisa * $row->harga_jual) - ($qtySisa->qtySisa * $row->harga_jual * $row->diskon/100);
                    $qtySekarang = $qtySisa->qtySisa;
                    $hargaDisc = $row->harga_jual - ($row->harga_jual * $row->diskon/100);
                } else {
                    $subtotal = ($row->jumlah_beli_barang * $row->harga_jual) - ($row->jumlah_beli_barang * $row->harga_jual * $row->diskon);
                    $qtySekarang = $row->jumlah_beli_barang;
                    $hargaDisc = $row->harga_jual - ($row->harga_jual * $row->diskon/100);
                }

                $html.="<tr>";
                $html.="<td style='text-align:center;'><input type='hidden' value='$row->id_barang' id='id_barang$i'> <input class='form-control' type='text' value='$row->kode' readonly='true' id='kode$i' style='width: 130px;'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='text' value='$row->nama_barang' readonly='true' id='nama_barang$i' style='width: 175px;'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$hargaDisc' readonly='true' id='harga_jual$i' style='text-align:right; width: 170px;'><input class='form-control' type='hidden' value='$row->harga_beli' readonly='true' id='harga_beli$i' style='text-align:right'></td>";
                $html.="<td style='text-align:center; width: 8%;'><input class='form-control' type='number' value='$qtySekarang' readonly='true' id='qty$i' style='width: 90px;'></td>";
                $html.="<td style='text-align:center;'><input class='form-control' type='number' value='$subtotal' readonly='true' id='subtotal$i' style='text-align:right; width: 200px;'></td>";
                // return $key;
                if(isset($qtySisa->qtySisa) && $qtySisa->qtySisa == 0){
                    $html.="<td style='text-align:center;'><button type='button' class='btn btn-info restrict-retur'><i class='fas fa-plus'></i></button></td>";
                } else if(isset($qtySisa->qtySisa) && $qtySisa->qtySisa > 0){
                    $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_jual='$row->harga_jual' data-harga_beli='$row->harga_beli' data-qty='$row->qtySekarang'><i class='fas fa-plus'></i></button></td>";
                } else {
                    $html.="<td style='text-align:center;'><button type='button' class='btn btn-info add_retur' data-idbuffer='$i' data-id_barang='$row->id_barang' data-nama_barang='$row->nama_barang' data-harga_jual='$row->harga_jual' data-harga_beli='$row->harga_beli' data-qty='$row->qtySekarang'><i class='fas fa-plus'></i></button></td>";
                }

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // dd($request); die;
        $returBaru = new ReturPenjualan();

        // if(ReturPenjualan::select("id")->where('id', 'like', '%'. date('Ymd') . '%')->first() == null){
        //     $indexTransaksi = sprintf("%05d", 1);
        //     $returBaru->id = date('Ymd'). $indexTransaksi;
        // }
        $id = $this->NextId(date('Y-m-d'));
        $returBaru->id = $id;
        $returBaru->id_penjualan = $request->id_penjualan;
        $returBaru->tgl = date('Y-m-d');
        $returBaru->total_retur = $request->total_retur;
        $returBaru->retur_keuntungan = $request->retur_keuntungan; 
        $returBaru->id_user = auth()->user()->id; 
        $returBaru->id_perusahaan = auth()->user()->id_perusahaan;
        $returBaru->save(); 

        
        foreach($request->item as $barang){
            $detReturBaru = new DetailReturPenjualan();
            $detReturBaru->id_retur_penjualan = $id;
            $detReturBaru->id_barang = $barang['id_barang_retur'];
            $detReturBaru->qty = $barang['qty_retur'];
            $qtyBeli = TransaksiPenjualan::leftJoin('t_detail_penjualan AS DT', 'DT.id_penjualan', 't_transaksi_penjualan.id')->select(DB::raw('DT.qty'), 'DT.id_barang')->where('t_transaksi_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->where('t_transaksi_penjualan.id', $request->id_penjualan)->where('DT.id_barang', $barang['id_barang_retur'])->first();
            // return $qtyBeli->id_barang;
            // $detReturBaru->qtySisa = $qtyBeli->qty - $barang['qty_retur];

            $qtyRetur = ReturPenjualan::leftJoin('t_detail_retur_penjualan AS DRP', 'DRP.id_retur_penjualan', 't_retur_penjualan.id')->select('DRP.qtySisa')->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->where('t_retur_penjualan.id_penjualan', $request->id_penjualan)->where('DRP.id_barang', $barang['id_barang_retur']) 
            ->orderBy('DRP.id', 'desc')
            // ->latest()
            ->first(); 
            // dd($qtyRetur) die;;
            if(isset($qtyRetur->qtySisa)){
                // return $qtyRetur;
                $detReturBaru->qtySisa = $qtyRetur->qtySisa - $barang['qty_retur'];
            } elseif(!isset($qtyRetur->qtySisa)){
                $detReturBaru->qtySisa = $qtyBeli->qty - $barang['qty_retur'];
            }
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

        $jumlahKas = KasMasuk::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $kasKeluar = KasKeluar::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $sisaKas = format_uang($jumlahKas - $kasKeluar);
        $kasKeluar = new KasKeluar;
        $kasKeluar->tgl = now();
        $kasKeluar->jumlah = $this->checkPrice($request->total_retur);
        $kasKeluar->keperluan = 'Retur Penjualan Pada Transaksi '. $request->id_penjualan;
        $kasKeluar->id_user = auth()->user()->id;
        $kasKeluar->id_perusahaan = auth()->user()->id_perusahaan;
        $kasKeluar->save();
        
        if(auth()->user()->hak_akses == 'admin'){
            return redirect()->route('admin.list-retur-penjualan.index')->with(['success' => 'Retur Penjualan Berhasil']);
        } elseif(auth()->user()->hak_akses == 'kasir') {
            return redirect()->route('kasir.list-retur-penjualan.index')->with(['success' => 'Retur Penjualan Berhasil']);
        }   
    }

    public function checkPrice($value)
    {
        if (gettype($value) == "string") {
            $temp = 0;
            for ($i = 0; $i < strlen($value); $i++) {
                if ((isset($value[$i]) == true && $value[$i] != ".") && $value[$i] != ",") {
                    $temp = ($temp * 10) + (int)$value[$i];
                }
            }
            return $temp;
        } else {
            return $value;
        }
    }

    public function NextId($tgl){
        $pieces = explode("-",$tgl);
        $yy=$pieces[0]; // piece1
        $mm=$pieces[1]; //
        $dd=$pieces[2]; 
        $tgl=$yy.$mm.$dd;
        
        $result= ReturPenjualan::select(DB::raw('max(id)+1 AS nextid'))->orderBy('id', 'DESC')->where('t_retur_penjualan.id_perusahaan', auth()->user()->id_perusahaan)->first();
        // dd($result);
        if($tgl==substr($result->nextid,0,8)){
            $nextid=$result->nextid;        
        } else{
            $nextid=$tgl.'001';
        }
        return $nextid;
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
