<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMinOrganisasiRequest;
use App\Http\Requests\UpdateMinOrganisasiRequest;
use App\Models\minorganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganisasiInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organisasiInternal = DB::table('minorganisasis')
            ->leftJoin('mjurusanprograms', 'minorganisasis.JurusanProgramID', '=', 'mjurusanprograms.id')
            ->leftJoin('mfakultas', 'minorganisasis.FakultasID', '=', 'mfakultas.id')
            ->leftJoin('muniversitas', 'minorganisasis.UniversitasID', '=', 'muniversitas.id')
            ->select(
                'minorganisasis.id',
                'minorganisasis.NamaInternalOrganisasi',
                'minorganisasis.KodeInternalOrganisasi',
                'minorganisasis.StatusInternalOrganisasi',
                'minorganisasis.TipeOrganisasi',
                'mfakultas.NamaFakultas',
                'mjurusanprograms.NamaJurusanPrograms',
                'muniversitas.NamaUniversitas'
            )
            ->when($request->input('NamaInternalOrganisasi'), function ($query, $NamaInternalOrganisasi) {
                // Memastikan pencarian berdasarkan NamaInternalOrganisasi
                return $query->where('minorganisasis.NamaInternalOrganisasi', 'like', '%' . $NamaInternalOrganisasi . '%');
            })
            ->when($request->input('FakultasID'), function ($query, $FakultasID) {
                // Memfilter berdasarkan FakultasID jika tersedia
                return $query->where('minorganisasis.FakultasID', $FakultasID);
            })
            ->when($request->input('JurusanProgramID'), function ($query, $JurusanProgramID) {
                // Memfilter berdasarkan JurusanProgramID jika tersedia
                return $query->where('minorganisasis.JurusanProgramID', $JurusanProgramID);
            })
            ->when($request->input('UniversitasID'), function ($query, $UniversitasID) {
                // Memfilter berdasarkan UniversitasID jika tersedia
                return $query->where('minorganisasis.UniversitasID', $UniversitasID);
            })
            ->paginate(10); // Pagination agar data tidak overload

        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();

        return view('organisasi.internal.index', compact('organisasiInternal', 'universitas'));
    }

    public function GetUniversitas(Request $request)
    {
        $tipeOrganisasi = $request->input('TipeOrganisasi'); // Mendapatkan tipe organisasi yang dipilih
        $universitasID = $request->input('UniversitasID'); // ID Universitas jika ada
        $fakultasID = $request->input('FakultasID'); // ID Fakultas jika ada

        // Mengecek apakah UniversitasID diberikan dan valid
        if (!$universitasID) {
            return response()->json(['error' => 'UniversitasID is required'], 400);
        }

        // Mendapatkan TipeInstitusi dari Universitas
        $tipeInstitusi = DB::table('muniversitas')->where('id', $universitasID)->value('TipeInstitusi');

        // Inisialisasi response array
        $response = [];

        if ($tipeInstitusi === 'Universitas') {
            // Jika TipeInstitusi adalah Universitas
            if ($tipeOrganisasi == 'Universitas') {
                // Kembalikan data Universitas
                $response['universitas'] = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();
            } elseif ($tipeOrganisasi == 'Fakultas') {
                // Jika tipe organisasi adalah Fakultas, ambil data fakultas sesuai UniversitasID
                $response['fakultas'] = DB::table('mfakultas')->where('UniversitasID', $universitasID)->get();
                dd($response);
            } elseif ($tipeOrganisasi == 'JurusanProgram') {
                // Jika tipe organisasi adalah JurusanProgram, pastikan ada FakultasID
                if ($fakultasID) {
                    // Ambil data jurusan berdasarkan UniversitasID dan FakultasID
                    $response['jurusanProgram'] = DB::table('mjurusanprograms')
                        ->where('UniversitasID', $universitasID)
                        ->where('FakultasID', $fakultasID)
                        ->get();
                } else {
                    return response()->json(['error' => 'FakultasID is required for JurusanProgram'], 400);
                }
            }
        } elseif ($tipeInstitusi === 'Politeknik') {
            // Jika TipeInstitusi adalah Politeknik
            if ($tipeOrganisasi == 'Universitas') {
                // Kembalikan data Universitas
                $response['universitas'] = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();
            } elseif ($tipeOrganisasi == 'JurusanProgram') {
                // Jika tipe organisasi adalah JurusanProgram, pastikan ada FakultasID
                if ($fakultasID) {
                    // Ambil data jurusan berdasarkan UniversitasID dan FakultasID
                    $response['jurusanProgram'] = DB::table('mjurusanprograms')
                        ->where('UniversitasID', $universitasID)
                        ->where('FakultasID', $fakultasID)
                        ->get();
                } else {
                    return response()->json(['error' => 'FakultasID is required for JurusanProgram'], 400);
                }
            }
        } else {
            return response()->json(['error' => 'Invalid TipeInstitusi'], 400);
        }
        // Mengembalikan response JSON
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();
        return view('organisasi.internal.create', compact('universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMinOrganisasiRequest $request)
    {
        // Ambil data yang sudah tervalidasi
        $validated = $request->validated();

        try {
            // Mendapatkan data Universitas berdasarkan UniversitasID
            $universitas = DB::table('muniversitas')->where('id', $validated['UniversitasID'])->first();

            // Memeriksa apakah Universitas ditemukan
            if (!$universitas) {
                return redirect()->route('internal-organisasi.index')->with('error', 'Universitas tidak ditemukan.');
            }

            // Membuat NamaInternalOrganisasi dengan menambahkan NamaUniversitas
            $namaInternalOrganisasi = $validated['NamaInternalOrganisasi'] . ' ' . $universitas->NamaUniversitas;

            // Membuat KodeInternalOrganisasi dengan menambahkan KodeUniversitas
            $kodeInternalOrganisasi = $validated['KodeInternalOrganisasi'] . $universitas->KodeUniversitas;

            // Menyimpan data ke dalam tabel minorganisasis
            $minOrganisasi = minorganisasi::create([
                'NamaInternalOrganisasi' => $namaInternalOrganisasi,  // Menggabungkan NamaInternalOrganisasi dengan NamaUniversitas
                'KodeInternalOrganisasi' => $kodeInternalOrganisasi,  // Menggabungkan KodeInternalOrganisasi dengan KodeUniversitas
                'TipeOrganisasi' => $validated['TipeOrganisasi'],
                'UniversitasID' => $validated['UniversitasID'] ?? null,
                'FakultasID' => $validated['FakultasID'] ?? null,
                'JurusanProgramID' => $validated['JurusanProgramID'] ?? null,
                'StatusInternalOrganisasi' => $validated['StatusInternalOrganisasi'],
                'Keterangan' => $validated['Keterangan'] ?? null,
            ]);

            // Mengembalikan respon sukses
            return redirect()->route('internal-organisasi.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan response error
            return redirect()->route('internal-organisasi.index')->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $minOrganisasi = minorganisasi::find($id);

        if (!$minOrganisasi) {
            return redirect()->route('internal-organisasi.index')->with('error', 'Data gedung tidak ditemukan.');
        }

        // Ambil data universitas berdasarkan UniversitasID
        $universitas = DB::table('muniversitas')->where('id', $minOrganisasi->UniversitasID)->first();

        if ($universitas) {
            // Potong NamaInternalOrganisasi dan KodeInternalOrganisasi sesuai dengan Nama dan Kode Universitas
            $namaUniversitas = $universitas->NamaUniversitas; // e.g. "Politeknik Negeri Malang"
            $kodeUniversitas = $universitas->KodeUniversitas; // e.g. "polinema"

            $minOrganisasi->NamaInternalOrganisasi = str_replace($namaUniversitas, '', $minOrganisasi->NamaInternalOrganisasi);
            $minOrganisasi->KodeInternalOrganisasi = str_replace($kodeUniversitas, '', $minOrganisasi->KodeInternalOrganisasi);

            // Trim hasil untuk menghapus spasi berlebih
            $minOrganisasi->NamaInternalOrganisasi = trim($minOrganisasi->NamaInternalOrganisasi);
            $minOrganisasi->KodeInternalOrganisasi = trim($minOrganisasi->KodeInternalOrganisasi);
        }

        // Ambil data universitas untuk dropdown
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();

        // Ambil data fakultas berdasarkan UniversitasID (jika tipe institusi Universitas)
        $fakultas = [];
        if ($minOrganisasi->UniversitasID) {
            $universitasGedung = DB::table('muniversitas')->where('id', $minOrganisasi->UniversitasID)->first();

            if ($universitasGedung->TipeInstitusi === 'Universitas') {
                $fakultas = DB::table('mfakultas')->where('UniversitasID', $minOrganisasi->UniversitasID)->get();
            }
        }

        // Ambil data jurusan program berdasarkan FakultasID atau UniversitasID
        $jurusanProgram = [];
        if ($minOrganisasi->FakultasID) {
            $jurusanProgram = DB::table('mjurusanprograms')->where('FakultasID', $minOrganisasi->FakultasID)->get();
        } elseif ($minOrganisasi->UniversitasID && isset($universitasGedung->TipeInstitusi) && $universitasGedung->TipeInstitusi === 'Politeknik') {
            $jurusanProgram = DB::table('mjurusanprograms')->where('UniversitasID', $minOrganisasi->UniversitasID)->get();
        }

        // dd($minOrganisasi, $universitas, $fakultas, $jurusanProgram, $universitasGedung);
        return view('organisasi.internal.edit', compact('minOrganisasi', 'universitas', 'fakultas', 'jurusanProgram', 'universitasGedung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMinOrganisasiRequest $request, $id)
    {
        // Ambil data yang sudah tervalidasi
        $validated = $request->validated();

        try {
            // Mendapatkan data Universitas berdasarkan UniversitasID
            $universitas = DB::table('muniversitas')->where('id', $validated['UniversitasID'])->first();

            // Memeriksa apakah Universitas ditemukan
            if (!$universitas) {
                return redirect()->route('internal-organisasi.index')->with('error', 'Universitas tidak ditemukan.');
            }

            // Mencari data organisasi berdasarkan ID dan update data yang sesuai
            $minOrganisasi = minorganisasi::findOrFail($id);

            // Membuat NamaInternalOrganisasi dengan menambahkan NamaUniversitas
            $namaInternalOrganisasi = $validated['NamaInternalOrganisasi'] . ' ' . $universitas->NamaUniversitas;

            // Membuat KodeInternalOrganisasi dengan menambahkan KodeUniversitas
            $kodeInternalOrganisasi = $validated['KodeInternalOrganisasi'] . $universitas->KodeUniversitas;

            // Mengupdate data ke dalam tabel minorganisasis
            $minOrganisasi->update([
                'NamaInternalOrganisasi' => $namaInternalOrganisasi,  // Menggabungkan NamaInternalOrganisasi dengan NamaUniversitas
                'KodeInternalOrganisasi' => $kodeInternalOrganisasi,  // Menggabungkan KodeInternalOrganisasi dengan KodeUniversitas
                'TipeOrganisasi' => $validated['TipeOrganisasi'],
                'UniversitasID' => $validated['UniversitasID'] ?? null,
                'FakultasID' => $validated['FakultasID'] ?? null,
                'JurusanProgramID' => $validated['JurusanProgramID'] ?? null,
                'StatusInternalOrganisasi' => $validated['StatusInternalOrganisasi'],
                'Keterangan' => $validated['Keterangan'] ?? null,
            ]);

            // Mengembalikan respon sukses
            return redirect()->route('internal-organisasi.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan response error
            return redirect()->route('internal-organisasi.index')->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cari data berdasarkan ID
            $minOrganisasi = minorganisasi::find($id);

            if (!$minOrganisasi) {
                return redirect()->route('internal-organisasi.index')->with('error', 'Data tidak ditemukan.');
            }

            // Hapus data
            $minOrganisasi->delete();

            return redirect()->route('internal-organisasi.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return redirect()->route('internal-organisasi.index')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
