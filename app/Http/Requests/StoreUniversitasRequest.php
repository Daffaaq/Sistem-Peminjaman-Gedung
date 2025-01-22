<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniversitasRequest extends FormRequest
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
            'NamaUniversitas' => 'required|string|max:255',
            'KodeUniversitas' => 'required|string|max:255',
            'AlamatUniversitas' => 'required|string|max:255',
            'NoTelpUniversitas' => 'required|string|max:255',
            'EmailUniversitas' => 'required|string|max:255',
            'StatusUniversitas' => 'required|in:Active,InActive',
            'TipeInstitusi' => 'required|in:Universitas,Politeknik'
        ];
    }
}
