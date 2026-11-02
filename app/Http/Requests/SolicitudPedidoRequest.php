<?php

namespace App\Http\Requests;

use App\Models\SolicitudPedido;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SolicitudPedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $presencia = $this->isMethod('PATCH') ? 'sometimes' : 'required';

        return [
            'cliente' => [$presencia, 'string', 'min:3', 'max:100'],
            'cantidad' => [$presencia, 'integer', 'min:1', 'max:100000'],
            'fecha_requerida' => [$presencia, 'date_format:Y-m-d', 'after_or_equal:today'],
            'estado' => ['sometimes', Rule::in(SolicitudPedido::ESTADOS)],
        ];
    }

    public function messages(): array
    {
        return [
            'cliente.required' => 'El nombre o referencia del cliente es obligatorio.',
            'cliente.string' => 'El cliente debe ser un texto.',
            'cliente.min' => 'El cliente debe tener al menos 3 caracteres.',
            'cliente.max' => 'El cliente no puede superar los 100 caracteres.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser mayor que 0.',
            'cantidad.max' => 'La cantidad no puede superar 100000.',
            'fecha_requerida.required' => 'La fecha requerida es obligatoria.',
            'fecha_requerida.date_format' => 'La fecha debe tener el formato AAAA-MM-DD, por ejemplo 2026-12-15.',
            'fecha_requerida.after_or_equal' => 'La fecha requerida no puede ser anterior a hoy.',
            'estado.in' => 'El estado debe ser uno de: ' . implode(', ', SolicitudPedido::ESTADOS) . '.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Los datos enviados no son válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}