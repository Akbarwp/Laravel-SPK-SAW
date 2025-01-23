<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KriteriaRequest extends FormRequest
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
            'kriteria' => 'required|string|max:255|unique:kriteria,kriteria,' . $this->id,
            'bobot' => 'required|decimal:0,2|min:0|max:1',
            'jenis_kriteria' => 'required|string|in:benefit,cost',
        ];
    }
}
