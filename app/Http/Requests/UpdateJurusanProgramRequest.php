<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateJurusanProgramRequest extends FormRequest
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
        // Ambil UniversitasID dari input
        $universitasID = $this->input('UniversitasID');

        // Cek tipe universitas
        $universitasTipe = DB::table('muniversitas')->where('id', $universitasID)->value('TipeInstitusi');

        $rules = [
            'NamaJurusanPrograms' => 'required|string|max:255',
            'KodeJurusanProgram' => 'required|string|max:255',
            'UniversitasID' => 'required|exists:muniversitas,id',
            'StatusJurusanPrograms' => 'required|string|in:Active,InActive',
        ];

        // Jika tipe universitas adalah 'Universitas', FakultasID harus diisi
        if ($universitasTipe == 'Universitas') {
            $rules['FakultasID'] = 'required|exists:mfakultas,id';
        } else {
            // Jika tipe Politeknik, FakultasID boleh null
            $rules['FakultasID'] = 'nullable|exists:mfakultas,id';
        }

        return $rules;
    }
}
