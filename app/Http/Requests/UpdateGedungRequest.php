<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateGedungRequest extends FormRequest
{
    private $isUniversitas = null;
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
        // Aturan dasar
        $rules = [
            'NamaGedung' => 'required|string|max:255',
            'KodeGedung' => 'required|string|max:255',
            'StatusGedung' => 'required|in:Active,InActive',
            'TipeGedung' => 'required|in:Mandiri,Fakultas',
            'statusGedungMandiri' => 'nullable|in:Booked,Available',
            'Keterangan' => 'nullable|string',
            'UniversitasID' => 'required|exists:muniversitas,id',
        ];

        // Validasi berdasarkan TipeGedung
        if ($this->input('TipeGedung') === 'Mandiri') {
            $rules['JumlahLantaiGedung'] = 'nullable|numeric|min:0';
            $rules['kapasitasGedung'] = 'required|numeric|min:0';
            $rules['FakultasID'] = 'nullable|exists:mfakultas,id';
            $rules['JurusanProgramID'] = 'nullable|exists:mjurusanprograms,id';
        } elseif ($this->input('TipeGedung') === 'Fakultas' && $this->isUniversitas()) {
            $rules['JumlahLantaiGedung'] = 'required|numeric|min:1';
            $rules['kapasitasGedung'] = 'nullable|numeric|min:0';
            $rules['FakultasID'] = 'required|exists:mfakultas,id';
            $rules['JurusanProgramID'] = 'required|exists:mjurusanprograms,id';
        }

        // // Validasi FakultasID berdasarkan tipe Universitas
        // if ($this->isUniversitas()) {
        //     $rules['FakultasID'] = 'required|exists:mfakultas,id';
        // } else {
        //     $rules['FakultasID'] = 'nullable|exists:mfakultas,id';
        // }

        return $rules;
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'NamaGedung.required' => 'Nama gedung wajib diisi.',
            'KodeGedung.required' => 'Kode gedung wajib diisi.',
            'kapasitasGedung.required' => 'Kapasitas gedung wajib diisi.',
            'kapasitasGedung.numeric' => 'Kapasitas gedung harus berupa angka.',
            'StatusGedung.in' => 'Status gedung harus Active atau InActive.',
            'TipeGedung.in' => 'Tipe gedung harus Mandiri atau Fakultas.',
            'UniversitasID.exists' => 'Universitas tidak ditemukan.',
            'JumlahLantaiGedung.required' => 'Jumlah lantai gedung wajib diisi untuk tipe Fakultas.',
            'statusGedungMandiri.required' => 'Status gedung mandiri wajib diisi.',
            'FakultasID.required' => 'Fakultas ID wajib diisi untuk tipe Fakultas.',
            'JurusanProgramID.required' => 'Jurusan Program ID wajib diisi untuk tipe Fakultas.',
        ];
    }


    /**
     * Check if the UniversitasID refers to a Universitas.
     */
    private function isUniversitas(): bool
    {
        if ($this->isUniversitas === null) {
            $this->isUniversitas = DB::table('muniversitas')
            ->where('id', $this->input('UniversitasID'))
            ->value('TipeInstitusi') === 'Universitas';
        }
        return $this->isUniversitas;
    }
}
