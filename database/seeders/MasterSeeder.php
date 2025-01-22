<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Universitas
        $universitasId = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Universitas Brawijaya',
            'KodeUniversitas' => 'UB',
            'AlamatUniversitas' => 'Jl. Veteran No. 246, Malang',
            'NoTelpUniversitas' => '0341-123456',
            'EmailUniversitas' => 'info@ub.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Universitas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $fakultasId = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Teknik',
            'KodeFakultas' => 'FT',
            'UniversitasID' => $universitasId,
            'StatusFakultas' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanId = DB::table('mjurusanprograms')->insertGetId([
            'NamaJurusanPrograms' => 'Departemen Teknik Kimia',
            'KodeJurusanProgram' => 'DTK',
            'FakultasID' => $fakultasId,
            'UniversitasID' => $universitasId,
            'StatusJurusanPrograms' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mprodis')->insert([
            'NamaProdi' => 'Teknik Kimia',
            'KodeProdi' => 'TEKKIM',
            'strata' => 'S1',
            'JurusanProgramID' => $jurusanId,
            'FakultasID' => $fakultasId,
            'StatusProdi' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Politeknik
        $politeknikId = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Politeknik Negeri Malang',
            'KodeUniversitas' => 'Polinema',
            'AlamatUniversitas' => 'Jl. Soekarno Hatta No. 246, Malang',
            'NoTelpUniversitas' => '0341-123458',
            'EmailUniversitas' => 'info@polinema.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Politeknik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanPoliteknikId = DB::table('mjurusanprograms')->insertGetId([
            'NamaJurusanPrograms' => 'Teknologi Informasi',
            'KodeJurusanProgram' => 'TI',
            'FakultasID' => null, // Politeknik tidak memiliki fakultas
            'UniversitasID' => $politeknikId,
            'StatusJurusanPrograms' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mprodis')->insert([
            'NamaProdi' => 'Sistem Informasi Bisnis',
            'KodeProdi' => 'SIB',
            'strata' => 'D4',
            'JurusanProgramID' => $jurusanPoliteknikId,
            'FakultasID' => null,
            'StatusProdi' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
