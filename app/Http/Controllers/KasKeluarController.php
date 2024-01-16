<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\Console\Input\Input;
use App\Http\Requests\StoreKasKeluarRequest;
use App\Http\Requests\UpdateKasKeluarRequest;

class KasKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->perusahaan->grade >= 3) {
                // User has super access, allow all actions
                return $next($request);
            } else {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses');
            }
        });
    }
    
    public function index()
    {
        $data['now'] = date('d-m-Y');
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $jumlahKas = KasMasuk::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $kasKeluar = KasKeluar::where('id_perusahaan', auth()->user()->id_perusahaan)->sum('jumlah');
        $data['sisaKas'] = format_uang($jumlahKas - $kasKeluar);

        // return $data;

        return view('kas.kas-keluar.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $kasKeluar = KasKeluar::where('id_perusahaan', auth()->user()->id_perusahaan)
                            ->with(['user'])
                            ->orderBy('id', 'DESC')->get();
        $sisaKas = KasMasuk::where('id_perusahaan', auth()->user()->id_perusahaan);

     
        return datatables()
            ->of($kasKeluar)
            ->addIndexColumn()
            ->addColumn('jumlah', function($kasKeluar){
                return 'Rp. '. format_uang($kasKeluar->jumlah) ;
            })
            ->addColumn('nama_user', function($kasMasuk) {
                return $kasMasuk->user->nama;
            })
            ->addColumn('action', function ($kasKeluar) {
                return '
                    <button data-keperluan="'.$kasKeluar->keperluan.'" 
                            data-jumlah="'.$kasKeluar->jumlah.'" "
                            data-route="' . route('admin.kas-keluar.update', $kasKeluar->id) . '" class="edit btn btn-xs btn-success"><i class="fas fa-pencil-square"></i></button>
                ';
                // <button onclick="deleteForm(`'. route('admin.kas-keluar.destroy', $kasKeluar->id) .'`)" class="btn btn-xs btn-danger delete"><i class="fas fa-trash"></i></button>

            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKasKeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validate = $request->validate([
            'jumlah' => 'required',
        ]);

        $jumlah = $request['jumlah'];
        $sisaKas = $this->checkPrice($request->jumlah_kas);
        $kasAkhir = $sisaKas - $this->checkPrice($request->jumlah);

        // return $jumlah;
        $kasKeluar = new KasKeluar;
        $kasKeluar->tgl = now();
        // if( $this->checkPrice($request->jumlah) > $sisaKas ) {
            // return redirect()->back()->withInput(Input::all());
            // return redirect()->back()->withInput($request->only('keperluan'))->with(['errorKasKeluar' => 'Biaya melebihi Uang Kas!']);
        // } else {
            $kasKeluar->jumlah = $this->checkPrice($jumlah);
        // }
        $kasKeluar->keperluan = $request->keperluan;
        $kasKeluar->id_user = auth()->user()->id;
        $kasKeluar->id_perusahaan = auth()->user()->id_perusahaan;
        $kasKeluar->save();

        return redirect()->route('admin.kas-keluar.index')->with(['success' => 'Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(KasKeluar $kasKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(KasKeluar $kasKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKasKeluarRequest  $request
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'jumlah' => 'required',
        ]);

        $jumlah = $request['jumlah'];
        $sisaKas = $this->checkPrice($request->jumlah_kas);
        $kasAkhir = $sisaKas - $this->checkPrice($request->jumlah);

        // return $sisaKas;
        $kasKeluar = KasKeluar::find($id);
        $kasKeluar->tgl = now();
        // if( $this->checkPrice($request->jumlah) > $sisaKas ) {
            // return back()->withInput(Input::all());
            // return back()->withInput($request->only('keperluan'))->with(['errorKasKeluar' => 'Biaya melebihi Uang Kas!']);
        // } else {
            $kasKeluar->jumlah = $this->checkPrice($jumlah);
        // }
        $kasKeluar->keperluan = $request->keperluan;
        $kasKeluar->id_user = auth()->user()->id;
        $kasKeluar->id_perusahaan = auth()->user()->id_perusahaan;
        $kasKeluar->update();

        return redirect()->back()->with(['success' => 'Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KasKeluar  $kasKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KasKeluar::find($id)->delete();
        return redirect()->back()->with(['success' => 'Berhasil Dihapus!']);
    }
}
