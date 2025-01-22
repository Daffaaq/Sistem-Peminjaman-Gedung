<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateProdiRequest extends FormRequest
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
            'NamaProdi' => 'required|string|max:255',
            'KodeProdi' => 'required|string|max:255',
            'strata' => 'required|string|max:255',
            'StatusProdi' => 'required|in:Active,InActive',
            'UniversitasID' => 'required|exists:muniversitas,id',
            'JurusanProgramID' => 'required|exists:mjurusanprograms,id',
        ];

        // Cek tipe institusi dari request untuk menentukan validasi Fakultas dan JurusanProgram
        if ($universitasTipe == 'Universitas') {
            $rules['FakultasID'] = 'required|exists:mfakultas,id';
        } elseif ($universitasTipe == 'Politeknik') {
            $rules['FakultasID'] = 'nullable';
        }

        return $rules;
    }
}
