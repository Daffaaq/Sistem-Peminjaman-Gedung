<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreRuangRequest extends FormRequest
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
            'NamaRuang' => 'required|string|max:255',
            'KodeRuang' => 'required|string|max:50|unique:mruangans,KodeRuang',
            'KapasitasRuang' => 'required|integer|min:1',
            'GedungID' => [
                'required',
                'exists:mgedungs,id',
                function ($attribute, $value, $fail) {
                    if (!$this->isGedungFakultas($value)) {
                        $fail('Gedung yang dipilih harus bertipe Fakultas.');
                    }
                },
            ],
            'StatusRuang' => 'required|in:Active,InActive',
            'StatusBooked' => 'required|in:Booked,Available',
            'Keterangan' => 'nullable|string',
        ];
    }

    /**
     * Private function to check if the selected GedungID is Fakultas.
     */
    private function isGedungFakultas($gedungID): bool
    {
        return DB::table('mgedungs')
            ->where('id', $gedungID)
            ->where('TipeGedung', 'Fakultas')
            ->exists();
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'NamaRuang.required' => 'Nama ruang wajib diisi.',
            'KodeRuang.required' => 'Kode ruang wajib diisi.',
            'KodeRuang.unique' => 'Kode ruang sudah digunakan, silakan pilih kode lain.',
            'KapasitasRuang.required' => 'Kapasitas ruang wajib diisi.',
            'GedungID.required' => 'Gedung wajib dipilih.',
            'GedungID.exists' => 'Gedung yang dipilih tidak valid.',
            'StatusRuang.required' => 'Status ruang wajib dipilih.',
            'StatusBooked.required' => 'Status booked wajib dipilih.',
        ];
    }
}
