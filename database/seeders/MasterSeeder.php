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
        // Create Universitas
        $universitasId = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Universitas Negeri Malang',
            'KodeUniversitas' => 'UM',
            'AlamatUniversitas' => 'Jl. Raya Tlogomas No. 246, Malang',
            'NoTelpUniversitas' => '0341-123456',
            'EmailUniversitas' => 'info@um.ac.id',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Fakultas
        $fakultasId = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Ilmu Komputer',
            'KodeFakultas' => 'FIK',
            'UniversitasID' => $universitasId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $fakultasId1 = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Ilmu Administrasi',
            'KodeFakultas' => 'FIA',
            'UniversitasID' => $universitasId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Prodi
        $prodiId = DB::table('mprodis')->insertGetId([
            'NamaProdi' => 'Teknik Informatika',
            'KodeProdi' => 'TI',
            'FakultasID' => $fakultasId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Gedung
        $gedungId = DB::table('mgedungs')->insertGetId([
            'NamaGedung' => 'Gedung A',
            'KodeGedung' => 'GA',
            'JumlahLantaiGedung' => 5,
            'kapasitasGedung' => 500,
            'FakultasID' => $fakultasId,
            'StatusGedung' => 'Active',
            'TipeGedung' => 'Fakultas',
            'Keterangan' => 'Gedung utama Fakultas Ilmu Komputer',
            'statusGedungMandiri' => 'available',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Ruangan
        DB::table('mruangans')->insert([
            'NamaRuang' => 'Ruang 101',
            'KodeRuang' => 'R101',
            'KapasitasRuang' => 50,
            'GedungID' => $gedungId,
            'StatusRuang' => 'Active',
            'StatusBooked' => 'available',
            'Keterangan' => 'Ruang kuliah untuk kelas besar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
