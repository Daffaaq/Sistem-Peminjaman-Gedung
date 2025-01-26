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
        // Universitas UB
        $universitasIdUB = DB::table('muniversitas')->insertGetId([
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

        $fakultasIdUB = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Teknik',
            'KodeFakultas' => 'FT',
            'UniversitasID' => $universitasIdUB,
            'StatusFakultas' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanIdUB = DB::table('mjurusanprograms')->insertGetId([
            'NamaJurusanPrograms' => 'Departemen Teknik Kimia',
            'KodeJurusanProgram' => 'DTK',
            'FakultasID' => $fakultasIdUB,
            'UniversitasID' => $universitasIdUB,
            'StatusJurusanPrograms' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mprodis')->insert([
            'NamaProdi' => 'Teknik Kimia',
            'KodeProdi' => 'TEKKIM',
            'strata' => 'S1',
            'JurusanProgramID' => $jurusanIdUB,
            'FakultasID' => $fakultasIdUB,
            'StatusProdi' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Universitas Airlangga
        $universitasIdUA = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Universitas Airlangga',
            'KodeUniversitas' => 'UNAIR',
            'AlamatUniversitas' => 'Jl. Airlangga No. 4, Surabaya',
            'NoTelpUniversitas' => '031-123456',
            'EmailUniversitas' => 'info@unair.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Universitas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $fakultasIdUA = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Kedokteran',
            'KodeFakultas' => 'FK',
            'UniversitasID' => $universitasIdUA,
            'StatusFakultas' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanIdUA = DB::table('mjurusanprograms')->insertGetId([
            'NamaJurusanPrograms' => 'Pendidikan Dokter',
            'KodeJurusanProgram' => 'PDK',
            'FakultasID' => $fakultasIdUA,
            'UniversitasID' => $universitasIdUA,
            'StatusJurusanPrograms' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mprodis')->insert([
            [
                'NamaProdi' => 'Pendidikan Dokter Umum',
                'KodeProdi' => 'PDU',
                'strata' => 'S1',
                'JurusanProgramID' => $jurusanIdUA,
                'FakultasID' => $fakultasIdUA,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NamaProdi' => 'Pendidikan Dokter Spesialis',
                'KodeProdi' => 'PDS',
                'strata' => 'S2',
                'JurusanProgramID' => $jurusanIdUA,
                'FakultasID' => $fakultasIdUA,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Universitas Indonesia
        $universitasIdUI = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Universitas Indonesia',
            'KodeUniversitas' => 'UI',
            'AlamatUniversitas' => 'Depok, Jawa Barat',
            'NoTelpUniversitas' => '021-123789',
            'EmailUniversitas' => 'info@ui.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Universitas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $fakultasIdUI = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Ilmu Komputer',
            'KodeFakultas' => 'FASILKOM',
            'UniversitasID' => $universitasIdUI,
            'StatusFakultas' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanIdUI = DB::table('mjurusanprograms')->insertGetId([
            'NamaJurusanPrograms' => 'Sistem Informasi',
            'KodeJurusanProgram' => 'SI',
            'FakultasID' => $fakultasIdUI,
            'UniversitasID' => $universitasIdUI,
            'StatusJurusanPrograms' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mprodis')->insert([
            'NamaProdi' => 'Manajemen Sistem Informasi',
            'KodeProdi' => 'MSI',
            'strata' => 'S2',
            'JurusanProgramID' => $jurusanIdUI,
            'FakultasID' => $fakultasIdUI,
            'StatusProdi' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Politeknik Negeri Malang
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
            [
                'NamaProdi' => 'Sistem Informasi Bisnis',
                'KodeProdi' => 'SIB',
                'strata' => 'D4',
                'JurusanProgramID' => $jurusanPoliteknikId,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NamaProdi' => 'Teknik Informatika',
                'KodeProdi' => 'TIF',
                'strata' => 'D4',
                'JurusanProgramID' => $jurusanPoliteknikId,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Universitas Gadjah Mada
        $universitasIdUGM = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Universitas Gadjah Mada',
            'KodeUniversitas' => 'UGM',
            'AlamatUniversitas' => 'Bulaksumur, Sleman, Yogyakarta',
            'NoTelpUniversitas' => '0274-123789',
            'EmailUniversitas' => 'info@ugm.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Universitas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $fakultasIdUGM = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Ekonomi dan Bisnis',
            'KodeFakultas' => 'FEB',
            'UniversitasID' => $universitasIdUGM,
            'StatusFakultas' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanIdUGM = DB::table('mjurusanprograms')->insertGetId([
                'NamaJurusanPrograms' => 'Akuntansi',
                'KodeJurusanProgram' => 'AKT',
                'FakultasID' => $fakultasIdUGM,
                'UniversitasID' => $universitasIdUGM,
                'StatusJurusanPrograms' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('mprodis')->insert([
            [
                'NamaProdi' => 'Akuntansi Keuangan',
                'KodeProdi' => 'AKK',
                'strata' => 'S1',
                'JurusanProgramID' => $jurusanIdUGM,
                'FakultasID' => $fakultasIdUGM,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NamaProdi' => 'Akuntansi Manajerial',
                'KodeProdi' => 'AKM',
                'strata' => 'S2',
                'JurusanProgramID' => $jurusanIdUGM,
                'FakultasID' => $fakultasIdUGM,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Politeknik Negeri Surabaya
        $politeknikIdPNS = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Politeknik Negeri Surabaya',
            'KodeUniversitas' => 'PNS',
            'AlamatUniversitas' => 'Jl. Raya ITS, Sukolilo, Surabaya',
            'NoTelpUniversitas' => '031-123654',
            'EmailUniversitas' => 'info@pns.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Politeknik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanPoliteknikIdPNS = DB::table('mjurusanprograms')->insertGetId([
                'NamaJurusanPrograms' => 'Teknik Elektro',
                'KodeJurusanProgram' => 'TE',
                'FakultasID' => null,
                'UniversitasID' => $politeknikIdPNS,
                'StatusJurusanPrograms' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('mprodis')->insert([
            [
                'NamaProdi' => 'Teknik Telekomunikasi',
                'KodeProdi' => 'TT',
                'strata' => 'D4',
                'JurusanProgramID' => $jurusanPoliteknikIdPNS,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NamaProdi' => 'Teknik Elektronika',
                'KodeProdi' => 'TEK',
                'strata' => 'D4',
                'JurusanProgramID' => $jurusanPoliteknikIdPNS,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Politeknik Negeri Jakarta
        $politeknikIdPNJ = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Politeknik Negeri Jakarta',
            'KodeUniversitas' => 'PNJ',
            'AlamatUniversitas' => 'Jl. Prof. Dr. G.A. Siwabessy, Depok',
            'NoTelpUniversitas' => '021-987654',
            'EmailUniversitas' => 'info@pnj.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Politeknik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanPoliteknikIdPNJ = DB::table('mjurusanprograms')->insertGetId([
                'NamaJurusanPrograms' => 'Teknik Sipil',
                'KodeJurusanProgram' => 'TS',
                'FakultasID' => null,
                'UniversitasID' => $politeknikIdPNJ,
                'StatusJurusanPrograms' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('mprodis')->insert([
            [
                'NamaProdi' => 'Teknik Konstruksi Gedung',
                'KodeProdi' => 'TKG',
                'strata' => 'D3',
                'JurusanProgramID' => $jurusanPoliteknikIdPNJ,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NamaProdi' => 'Teknik Konstruksi Sipil',
                'KodeProdi' => 'TKS',
                'strata' => 'D3',
                'JurusanProgramID' => $jurusanPoliteknikIdPNJ,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Politeknik Negeri Madiun
        $politeknikIdPNM = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Politeknik Negeri Madiun',
            'KodeUniversitas' => 'PNM',
            'AlamatUniversitas' => 'Jl. Siliwangi No. 39, Madiun',
            'NoTelpUniversitas' => '0351-123456',
            'EmailUniversitas' => 'info@pnm.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Politeknik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanPoliteknikIdPNM = DB::table('mjurusanprograms')->insertGetId([
                'NamaJurusanPrograms' => 'Teknik Mesin',
                'KodeJurusanProgram' => 'TM',
                'FakultasID' => null,
                'UniversitasID' => $politeknikIdPNM,
                'StatusJurusanPrograms' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('mprodis')->insert([
            [
                'NamaProdi' => 'Teknik Mesin Produksi',
                'KodeProdi' => 'TMP',
                'strata' => 'D3',
                'JurusanProgramID' => $jurusanPoliteknikIdPNM,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NamaProdi' => 'Teknik Mesin Otomotif',
                'KodeProdi' => 'TMO',
                'strata' => 'D3',
                'JurusanProgramID' => $jurusanPoliteknikIdPNM,
                'FakultasID' => null,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Universitas Negeri Jember
        $universitasIdUNJ = DB::table('muniversitas')->insertGetId([
            'NamaUniversitas' => 'Universitas Negeri Jember',
            'KodeUniversitas' => 'UNJ',
            'AlamatUniversitas' => 'Jl. Kalimantan No. 37, Jember',
            'NoTelpUniversitas' => '0331-123456',
            'EmailUniversitas' => 'info@unj.ac.id',
            'StatusUniversitas' => 'Active',
            'TipeInstitusi' => 'Universitas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $fakultasIdUNJ = DB::table('mfakultas')->insertGetId([
            'NamaFakultas' => 'Fakultas Pendidikan Matematika dan Ilmu Pengetahuan Alam',
            'KodeFakultas' => 'FPMIPA',
            'UniversitasID' => $universitasIdUNJ,
            'StatusFakultas' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jurusanIdUNJ = DB::table('mjurusanprograms')->insertGetId([
                'NamaJurusanPrograms' => 'Matematika',
                'KodeJurusanProgram' => 'MTK',
                'FakultasID' => $fakultasIdUNJ,
                'UniversitasID' => $universitasIdUNJ,
                'StatusJurusanPrograms' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('mprodis')->insert([
            [
                'NamaProdi' => 'Matematika Terapan',
                'KodeProdi' => 'MTK-T',
                'strata' => 'S1',
                'JurusanProgramID' => $jurusanIdUNJ,
                'FakultasID' => $fakultasIdUNJ,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NamaProdi' => 'Pendidikan Matematika',
                'KodeProdi' => 'PDM',
                'strata' => 'S1',
                'JurusanProgramID' => $jurusanIdUNJ,
                'FakultasID' => $fakultasIdUNJ,
                'StatusProdi' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
