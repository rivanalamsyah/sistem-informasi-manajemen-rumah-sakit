<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

class ProcessPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'string', 'in:Tunai,Transfer Bank,Kartu Debit,Kartu Kredit,QRIS'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'amount_paid.required' => 'Nominal uang yang dibayarkan wajib diisi.',
            'amount_paid.numeric' => 'Nominal harus berupa angka.',
        ];
    }
}
