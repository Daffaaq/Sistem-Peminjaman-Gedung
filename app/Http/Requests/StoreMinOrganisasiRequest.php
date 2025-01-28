<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreMinOrganisasiRequest extends FormRequest
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
        $universitasID = $this->input('UniversitasID');
        $tipeOrganisasi = $this->input('TipeOrganisasi');

        // Cek tipe universitas untuk menentukan validasi berdasarkan tipe institusi
        $universitasTipe = DB::table('muniversitas')->where('id', $universitasID)->value('TipeInstitusi');

        // Aturan dasar
        $rules = [
            'NamaInternalOrganisasi' => 'required|string|max:255',
            'KodeInternalOrganisasi' => 'required|string|max:255',
            'TipeOrganisasi' => 'required|in:Universitas,Fakultas,JurusanProgram',
            'UniversitasID' => 'nullable|exists:muniversitas,id',
            'FakultasID' => 'nullable|exists:mfakultas,id',
            'JurusanProgramID' => 'nullable|exists:mjurusanprograms,id',
            'StatusInternalOrganisasi' => 'required|in:Active,InActive',
            'Keterangan' => 'nullable|string',
        ];

        // Validasi untuk Universitas
        if ($universitasTipe == 'Universitas') {
            if ($tipeOrganisasi == 'Universitas') {
                // Jika TipeOrganisasi adalah Universitas, maka FakultasID dan JurusanProgramID bisa kosong
                $rules['FakultasID'] = 'nullable';
                $rules['JurusanProgramID'] = 'nullable';
            } elseif ($tipeOrganisasi == 'Fakultas') {
                // Jika TipeOrganisasi adalah Fakultas, maka FakultasID wajib ada, UniversitasID wajib ada
                $rules['FakultasID'] = 'required|exists:mfakultas,id';
                $rules['UniversitasID'] = 'required|exists:muniversitas,id'; // UniversitasID wajib ada untuk Fakultas
                $rules['JurusanProgramID'] = 'nullable'; // JurusanProgramID opsional
            } elseif ($tipeOrganisasi == 'JurusanProgram') {
                // Jika TipeOrganisasi adalah JurusanProgram, maka UniversitasID dan FakultasID wajib ada
                $rules['UniversitasID'] = 'required|exists:muniversitas,id';
                $rules['FakultasID'] = 'required|exists:mfakultas,id';
                $rules['JurusanProgramID'] = 'required|exists:mjurusanprograms,id';
            }
        } elseif ($universitasTipe == 'Politeknik') {
            if ($tipeOrganisasi == 'Universitas') {
                // Jika TipeOrganisasi adalah Universitas, maka FakultasID dan JurusanProgramID bisa kosong
                $rules['FakultasID'] = 'nullable';
                $rules['JurusanProgramID'] = 'nullable';
            } elseif ($tipeOrganisasi == 'JurusanProgram') {
                // Jika TipeOrganisasi adalah JurusanProgram di Politeknik, maka FakultasID bisa kosong, tetapi JurusanProgramID wajib ada
                $rules['UniversitasID'] = 'required|exists:muniversitas,id';
                $rules['FakultasID'] = 'nullable'; // FakultasID bisa kosong di Politeknik
                $rules['JurusanProgramID'] = 'required|exists:mjurusanprograms,id';
            }
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'NamaInternalOrganisasi.required' => 'Nama organisasi internal harus diisi.',
            'NamaInternalOrganisasi.string' => 'Nama organisasi internal harus berupa string.',
            'NamaInternalOrganisasi.max' => 'Nama organisasi internal maksimal 255 karakter.',
            'KodeInternalOrganisasi.required' => 'Kode organisasi internal harus diisi.',
            'KodeInternalOrganisasi.string' => 'Kode organisasi internal harus berupa string.',
            'KodeInternalOrganisasi.max' => 'Kode organisasi internal maksimal 255 karakter.',
            'KodeInternalOrganisasi.unique' => 'Kode organisasi internal sudah terdaftar.',
            'TipeOrganisasi.required' => 'Tipe organisasi harus dipilih.',
            'TipeOrganisasi.in' => 'Tipe organisasi harus salah satu dari: Universitas, Fakultas, JurusanProgram.',
            'UniversitasID.exists' => 'Universitas tidak ditemukan.',
            'FakultasID.exists' => 'Fakultas tidak ditemukan.',
            'JurusanProgramID.exists' => 'Jurusan program tidak ditemukan.',
            'StatusInternalOrganisasi.required' => 'Status organisasi harus dipilih.',
            'StatusInternalOrganisasi.in' => 'Status organisasi harus salah satu dari: Active, InActive.',
            'FakultasID.required' => 'Fakultas harus diisi.',
            'JurusanProgramID.required' => 'Jurusan Program harus diisi.',
            'UniversitasID.required' => 'Universitas harus diisi.',

            // Custom messages untuk validasi berdasarkan tipe universitas dan tipe organisasi
            'FakultasID.nullable' => 'Fakultas tidak wajib diisi untuk universitas atau politeknik.',
            'FakultasID.required' => 'Fakultas harus diisi untuk fakultas.',
            'FakultasID.exists' => 'Fakultas yang dipilih tidak ditemukan.',

            'JurusanProgramID.nullable' => 'Jurusan program tidak wajib diisi untuk universitas atau politeknik.',
            'JurusanProgramID.required' => 'Jurusan program harus diisi untuk jurusan program.',
            'JurusanProgramID.exists' => 'Jurusan program yang dipilih tidak ditemukan.',

            'UniversitasID.required' => 'Universitas harus diisi untuk fakultas atau jurusan program.',

            // Menambahkan validasi untuk universitas
            'UniversitasID.exists' => 'Universitas tidak ditemukan.',

            // Validasi untuk tipe organisasi yang lebih detail
            'FakultasID.required_if' => 'FakultasID harus diisi ketika tipe organisasi adalah Fakultas.',
            'JurusanProgramID.required_if' => 'JurusanProgramID harus diisi ketika tipe organisasi adalah JurusanProgram.',
        ];
    }
}
