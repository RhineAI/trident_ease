<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Imports\BarangImport;
use App\Exports\TemplateDownload;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;

class ImportController extends Controller
{
    public function viewBarangImport(){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        // ambil data perusahaan yang sedang login
        $data['perusahaan'] = Perusahaan::get();
        // ambil semua data perusahaan dari database
        return view('admin.import', $data);
        // return tampiln halaman barang 
    }

    public function barangImport(Request $request){
        $rollback = true;
        Excel::import(new BarangImport($request->id_perusahaan, $rollback), $request->file('fileExcel')->store('temp'));
        // Import request file excel ke database melalui class BarangImport dengan rollback true
        return back()->with(['success' => 'Import Data Barang Berhasil']);
        // return kembali ke halaman barang
    }

    public function downloadTemplate()
    {
        return Excel::download(new TemplateDownload, 'template.xlsx');
        // return download file excel dari class TemplateDownload
    }

}
