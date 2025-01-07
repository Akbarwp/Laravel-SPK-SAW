<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'alternatif_id' => 'required|numeric|exists:App\Models\Alternatif,id',
            'kriteria_id' => 'required|numeric|exists:App\Models\Kriteria,id',
            'sub_kriteria_id' => 'required|numeric|exists:App\Models\SubKriteria,id',
        ];
    }
}
