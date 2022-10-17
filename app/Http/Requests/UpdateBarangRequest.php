<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
            'kode' => 'string|max:50',
            'nama' => 'string|max:50',
            'tebal' => 'string|max:50',
            'panjang' => 'string|max:50',
            'stock' => 'numeric|max:11',
            'stock_minimal' => 'numeric|max:11',
            'harga_beli' => 'numeric|max:11',
            'keuntungan' => 'numeric|max:11',
            'keterangan' => 'string|max:255'
        ];
    }
}
