<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comprobante_id' => 'required|exists:comprobantes,id',
            'numero_comprobante' => [
                'required',
                'max:255',
                Rule::unique('compras', 'numero_comprobante')->where(function ($query) {
                    return $query->where('estado', 1); // Solo verifica compras activas
                })
            ],
            'impuesto' => 'required',
            'fecha_hora' => 'required',
            'total' => 'required'
        ];
    }
}
