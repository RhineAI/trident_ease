<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:50',
            'barcode' => 'required',
            'tebal' => 'required|string|max:50',
            'panjang' => 'required|string|max:50',
            'id_kategori' => 'required',
            'id_supplier' => 'required',
            'id_satuan' => 'required',
            'id_merek' => 'required',
            'id_perusahaan' => 'required',
            'stock' => 'required|numeric',
            'stock_minimal' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'keuntungan' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'status' => 'required|max:11'
        ];
    }
}
