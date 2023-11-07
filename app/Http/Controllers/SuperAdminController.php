<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;

class SuperAdminController extends Controller
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
        $data['no'] = 1;
        $data['perusahaan'] = Perusahaan::where('nama', '!=', 'ZiePOS')->orderBy('grade', 'ASC')->get();
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        return view('super-admin.perusahaan.index')->with($data);
    }

    public function table()
    {
        $perusahaan = Perusahaan::orderBy('', 'DESC')->get();
        return datatables()
            ->of($perusahaan)
            ->addIndexColumn()
            ->addColumn('grade', function($perusahaan) {
                if ($perusahaan->grade == 1) {
                    $grade = '<span class="badge badge-primary">Free</span>';
                } elseif($perusahaan->grade == 2) {
                    $grade = '<span class="badge" style="background-color:#81d6b0;">Intermediate</span>';
                } elseif($perusahaan->grade == 3) {
                    $grade = '<span class="badge badge-danger">Premium</span>';
                }
                
                return $grade;
            })
            ->addColumn('created_at', function($perusahaan) {
                return tanggal_indonesia($perusahaan->created_at);
            })
            ->addColumn('updated_at', function($perusahaan) {
                return tanggal_indonesia($perusahaan->updated_at);
            })
            ->addColumn('action', function ($perusahaan) {
                $button = '<div class="input-group">
                                <button data-mode ="edit"
                                    data-nama="'.$perusahaan->nama.'" 
                                    data-pemilik="'.$perusahaan->pemilik.'"
                                    data-tlp="'.$perusahaan->tlp.'"
                                    data-npwp="'.$perusahaan->npwp.'"
                                    data-email="'.$perusahaan->email.'"
                                    data-grade="'.$perusahaan->grade.'"
                                    data-route="' . route('super_admin.manage-perusahaan.update', $perusahaan->id) . '" 
                                    class="edit btn btn-xs btn-warning">
                                    <i class="fas fa-light fa-pencil-square"></i>
                                </button>';      
                $button .= '    <button data-mode = "delete"
                                    data-route = "'. route('super_admin.manage-perusahaan.destroy', $perusahaan->id) .'" 
                                    class="delete btn btn-xs btn-danger">
                                    <i class="fas fa-light fa-trash"></i>
                                </button>         
                            </div>';
                return $button;
            })
            ->rawColumns(['action', 'grade'])
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perbarui(Request $request, $id) {
        return $request;
        $perusahaan = Perusahaan::find($id);
        $perusahaan['grade'] = $request->grade;
        $perusahaan['expiredDate'] = $request->grade;
        $perusahaan->update($request->all());

        // return response(null, 204);
        return redirect()->route('super_admin.manage-perusahaan.index')->with(['success' => 'Perusahaan Berhasil Diupdate!']);
    }
    public function update(Request $request, $id)
    {
        // return $request;
        // return (strtotime($request->expiredDate) > strtotime(date('Y-m-d')));

        $perusahaan = Perusahaan::find($id);
        $perusahaan->grade = $request->grade;
        $perusahaan->startDate = date('Y-m-d');
        if(strtotime($request->expiredDate) > strtotime(date('Y-m-d'))){
            if($request->expiredDate != null) {
                $perusahaan->expiredDate = $request->expiredDate;
            } else {
                $perusahaan->expiredDate = '0000-00-00';
            }
        } else {
            return back()->with(['error', 'Tanggal Kadaluarsa Sewa Perusahaan Harus Melebihi Hari Ini']);
        }
        // return $perusahaan;
        $perusahaan->update();

        // return response(null, 204);
        return redirect()->route('super_admin.manage-perusahaan.index')->with(['success' => 'Perusahaan Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::find($id);
        $perusahaan->delete();
        return redirect()->route('super_admin.manage-perusahaan.index')->with(['success' => 'Perusahaan Berhasil Dihapus!']);
    }
}
