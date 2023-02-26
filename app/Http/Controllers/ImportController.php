<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Imports\BarangImport;
use App\Exports\TemplateDownload;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function viewBarangImport(){
        $data['cPerusahaan'] = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();
        $data['perusahaan'] = Perusahaan::get();
        return view('admin.import', $data);
    }

    public function barangImport(Request $request){
        $fileExcel = $request->file('fileExcel');
        // dd($request);
        // $namaFile = $fileExcel->getClientOriginalName();  
        // $request->file('fileExcel')->move('assets/excel', $namaFile);
     
        // return $namaFile;
        Excel::import(new BarangImport($request->id_perusahaan), $request->file('fileExcel')->store('temp'));

        return back()->with(['success' => 'Import Data Barang Berhasil']);
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
