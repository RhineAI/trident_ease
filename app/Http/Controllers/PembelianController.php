<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Perusahaan;
use App\Models\Supplier;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('pembelian.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data['supplier'] = Supplier::get();
        $data['produk'] = Barang::get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('pembelian.tambah', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembelianRequest $request)
    {
        $pembelian = new Pembelian();
        $generateKode = Pembelian::select('kode_invoice')->orderBy('created_at', 'DESC')->first();

        $kode = '';

        if($generateKode == NULL) {
            $kode = 'INV-202205001';
        } else {
            $kode = sprintf('INV-202205%03d', substr($generateKode->kode_pembelian, 10) + 1);
            // $kode = sprintf('BRC-202205%03d' + 1);
        }

        $pembelian->tgl = now();
        $pembelian->kode_invoice = $kode;
        $pembelian->id_supplier = $request->id_supplier;
        $pembelian->total_pembelian = $request->total_pembelian;
        $pembelian->jenis_pembayaran = $request->jenis_pembayaran;
        $pembelian->id_user = $request->id_user;
        $pembelian->save();

        $detail = DetailPembelian::Where('id_pembelian', $pembelian->id)->get();
        foreach ($detail as $item) {
            $produk = Barang::find($item->id_produk);
            $produk->stok += $item->jumlah;
            $produk->update();
        }

        return redirect()->route('pembelian.index');
    }

    public function data($id)
    {
        $detail = DetailPembelian::with('produk')
            ->where('id_pembelian', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['barcode']     = '<span class="badge badge-info">'. $item->produk->barcode .'</span>';
            $row['nama_produk'] = $item->produk->nama;
            $row['harga_beli']  = 'Rp. '. format_uang($item->harga_beli);
            $row['qty']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id .'" value="'. $item->qty .'">';
            $row['subtotal']    = 'Rp. '. format_uang($item->harga_beli * $item->qty);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->qty;
            $total_item += $item->qty;
        }
        $data[] = [
            'barcode' => '
                <div class="total hide" style="visibility : hidden">'. $total .'</div>
                <div class="total_item hide" style="visibility : hidden">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'barcode', 'jumlah'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembelianRequest  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembelianRequest $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }
}
