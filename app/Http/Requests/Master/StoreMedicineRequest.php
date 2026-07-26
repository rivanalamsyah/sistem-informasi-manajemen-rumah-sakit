<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:30', 'unique:medicines,code'],
            'name' => ['required', 'string', 'max:150'],
            'generic_name' => ['nullable', 'string', 'max:150'],
            'category_id' => ['required', 'exists:medicine_categories,id'],
            'unit' => ['required', 'string', 'max:30'],
            'type' => ['required', 'string', 'in:Bebas,Bebas Terbatas,Keras,Narkotika,Psikotropika,Alkes'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode obat wajib diisi.',
            'code.unique' => 'Kode obat sudah digunakan.',
            'name.required' => 'Nama obat wajib diisi.',
            'category_id.required' => 'Kategori obat wajib dipilih.',
            'unit.required' => 'Satuan obat wajib diisi.',
            'purchase_price.required' => 'Harga beli (HPP) wajib diisi.',
            'selling_price.required' => 'Harga jual ke pasien wajib diisi.',
        ];
    }
}
