<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubKriteriaRequest extends FormRequest
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
            'sub_kriteria' => 'required|string|max:255',
            'bobot' => 'required|decimal:0,2|min:0',
            'kriteria_id' => 'required|numeric|exists:App\Models\Kriteria,id',
        ];
    }
}
