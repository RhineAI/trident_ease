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
        $data['perusahaan'] = Perusahaan::get();
        return view('admin.import', $data);
    }

    public function barangImport(Request $request){
        include app_path('Imports/BarangImport.php');
        $fileExcel = $request->file('fileExcel');
        // dd($request);
        // return $fileExcel;
        // $namaFile = $fileExcel->getClientOriginalName();  
        // $request->file('fileExcel')->move('assets/excel', $namaFile);
     
        $rollback = true;
        Excel::import(new BarangImport($request->id_perusahaan, $rollback), $request->file('fileExcel')->store('temp'));
        if($rollback == false) {
            return back()->with(['success' => 'Import Data Barang Berhasil']);
        } else {
            return redirect()->back()->with(['error' => 'Terdapat Kesalahan saat Import file!']);
        }
     
        
        // Excel::import(new BarangImport, storage_path('public/assets/excel/'.$namaFile));
        // Excel::import(new BarangImport, public_path('/assets/excel'.$namaFile));
        // Excel::toCollection(new BarangImport, $file->path, 'public/assets/excel')[0];
        // return back();
    }

    public function downloadTemplate() 
    {
        return Excel::download(new TemplateDownload, 'template.xlsx');
    }

}
