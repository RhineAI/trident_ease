<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use App\Models\Perusahaan;
use App\Http\Requests\StoreKasMasukRequest;
use App\Http\Requests\UpdateKasMasukRequest;
use Illuminate\Http\Request;

class KasMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['now'] = date('d-m-Y');
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('kas.kas-masuk.index', $data);
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

    public function data()
    {
        $kasMasuk = KasMasuk::leftJoin('t_users AS U', 'U.id', 't_kas_masuk.id_user')
                            ->select('t_kas_masuk.*', 'U.nama AS nama_user')
                            ->orderBy('id', 'DESC')->get();

        return datatables()
            ->of($kasMasuk)
            ->addIndexColumn()
            ->addColumn('jumlah', function($kasMasuk){
                return 'Rp. '. format_uang($kasMasuk->jumlah) ;
            })
            ->addColumn('action', function ($kasMasuk) {
                return '
                    <button data-mode ="edit"
                            data-jumlah="'.$kasMasuk->jumlah.'" 
                            data-keterangan="'.$kasMasuk->keterangan.'"
                            data-tambah = "'.route('admin.kas-masuk.store').'"
                            data-route="' . route('admin.kas-masuk.update', $kasMasuk->id) . '" class="edit btn btn-xs btn-success"><i class="fas fa-pencil-square"></i></button>
                    <button onclick="deleteForm(`'. route('admin.kas-masuk.destroy', $kasMasuk->id) .'`)" class="btn btn-xs btn-danger delete"><i class="fas fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
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
     * @param  \App\Http\Requests\StoreKasMasukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'jumlah' => 'required',
            'keterangan' => 'required',
        ]);

        $jumlah = $request['jumlah'];

        $kasMasuk = new KasMasuk;
        $kasMasuk->tgl = now();
        $kasMasuk->jumlah = $this->checkPrice($jumlah);
        $kasMasuk->id_user = auth()->user()->id;
        $kasMasuk->id_perusahaan = auth()->user()->id_perusahaan;
        $kasMasuk->keterangan = $request->keterangan;
        $kasMasuk->save();

        return redirect()->route('admin.kas-masuk.index')->with(['success' => 'Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KasMasuk  $kasMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(KasMasuk $kasMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KasMasuk  $kasMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(KasMasuk $kasMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKasMasukRequest  $request
     * @param  \App\Models\KasMasuk  $kasMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'jumlah' => 'required',
        ]);

        $jumlah = $request['jumlah'];

        $kasMasuk = KasMasuk::find($id);
        $kasMasuk->tgl = now();
        $kasMasuk->jumlah = $this->checkPrice($jumlah);
        $kasMasuk->id_user = auth()->user()->id;
        $kasMasuk->keterangan = $request->keterangan;
        $kasMasuk->update();

        return redirect()->route('admin.kas-masuk.index')->with(['success' => 'Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KasMasuk  $kasMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kasMasuk = KasMasuk::find($id);
        $kasMasuk->delete();

        return redirect()->route('admin.kas-masuk.index')->with(['success' => 'Berhasil Dihapus!']);
    }
}
