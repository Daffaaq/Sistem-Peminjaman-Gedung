<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFakultasRequest extends FormRequest
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
            'NamaFakultas' => 'required|string|max:255',
            'KodeFakultas' => 'required|string|max:255',
            'UniversitasID' => 'required|exists:muniversitas,id',
            'StatusFakultas' => 'required|in:Active,InActive'
        ];
    }
}
