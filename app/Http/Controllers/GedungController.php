<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGedungRequest;
use App\Http\Requests\UpdateGedungRequest;
use App\Models\mgedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gedung = DB::table('mgedungs')
            ->leftJoin('mjurusanprograms', 'mgedungs.JurusanProgramID', '=', 'mjurusanprograms.id')
            ->leftJoin('mfakultas', 'mgedungs.FakultasID', '=', 'mfakultas.id')
            ->leftJoin('muniversitas', 'mgedungs.UniversitasID', '=', 'muniversitas.id')
            ->select(
                'mfakultas.NamaFakultas',
                'mjurusanprograms.NamaJurusanPrograms',
                'muniversitas.NamaUniversitas',
                'mgedungs.NamaGedung',
                'mgedungs.KodeGedung',
                'mgedungs.TipeGedung',
                'mgedungs.id',
            )
            ->when($request->input('NamaGedung'), function ($query, $NamaGedung) {
                return $query->where('NamaGedung', 'like', '%' . $NamaGedung . '%');
            })
            ->when($request->input('FakultasID'), function ($query, $FakultasID) {
                return $query->where('mgedungs.FakultasID', $FakultasID);
            })
            ->when($request->input('JurusanProgramID'), function ($query, $JurusanProgramID) {
                return $query->where('mgedungs.JurusanProgramID', $JurusanProgramID);
            })
            ->when($request->input('UniversitasID'), function ($query, $UniversitasID) {
                return $query->where(function ($q) use ($UniversitasID) {
                    $q->where('mfakultas.UniversitasID', $UniversitasID)
                        ->orWhere('mjurusanprograms.UniversitasID', $UniversitasID)
                        ->orWhere('mgedungs.UniversitasID', $UniversitasID);
                });
            })
            ->paginate(10);
        // dd($gedung);
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();
        return view('gedung.index', compact('gedung', 'universitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();
        return view('gedung.create', compact('universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGedungRequest $request)
    {
        // dd($request->all());
        // Simpan data menggunakan DB facade
        DB::table('mgedungs')->insert([
            'NamaGedung' => $request->NamaGedung,
            'KodeGedung' => $request->KodeGedung,
            'JumlahLantaiGedung' => $request->JumlahLantaiGedung ?? null,
            'kapasitasGedung' => $request->kapasitasGedung ?? null,
            'FakultasID' => $request->FakultasID ?? null,
            'JurusanProgramID' => $request->JurusanProgramID ?? null,
            'UniversitasID' => $request->UniversitasID,
            'StatusGedung' => $request->StatusGedung,
            'TipeGedung' => $request->TipeGedung,
            'Keterangan' => $request->Keterangan,
            'statusGedungMandiri' => $request->statusGedungMandiri ?? null,
            'created_at' => now(),
        ]);

        return redirect()->route('gedung.index')->with('success', 'Data Gedung berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data gedung berdasarkan ID
        $gedung = mgedung::with(['universitas', 'Fakultas', 'JurusanPrograms'])->find($id);

        if (!$gedung) {
            return redirect()->route('gedung.index')->with('error', 'Gedung tidak ditemukan.');
        }

        return view('gedung.show', compact('gedung'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data gedung berdasarkan ID
        $gedung = DB::table('mgedungs')->where('id', $id)->first();

        if (!$gedung) {
            return redirect()->route('gedung.index')->with('error', 'Data gedung tidak ditemukan.');
        }

        // Ambil data universitas untuk dropdown
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();

        // Ambil data fakultas berdasarkan UniversitasID (jika tipe institusi Universitas)
        $fakultas = [];
        if ($gedung->UniversitasID) {
            $universitasGedung = DB::table('muniversitas')->where('id', $gedung->UniversitasID)->first();

            if ($universitasGedung->TipeInstitusi === 'Universitas') {
                $fakultas = DB::table('mfakultas')->where('UniversitasID', $gedung->UniversitasID)->get();
            }
        }

        // Ambil data jurusan program berdasarkan FakultasID atau UniversitasID
        $jurusanProgram = [];
        if ($gedung->FakultasID) {
            $jurusanProgram = DB::table('mjurusanprograms')->where('FakultasID', $gedung->FakultasID)->get();
        } elseif ($gedung->UniversitasID && isset($universitasGedung->TipeInstitusi) && $universitasGedung->TipeInstitusi === 'Politeknik') {
            $jurusanProgram = DB::table('mjurusanprograms')->where('UniversitasID', $gedung->UniversitasID)->get();
        }

        // dd($gedung, $universitas, $fakultas, $jurusanProgram, $universitasGedung);

        return view('gedung.edit', compact('gedung', 'universitas', 'fakultas', 'jurusanProgram', 'universitasGedung'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGedungRequest $request, string $id)
    {
        // Pastikan data gedung yang akan diupdate ada
        $gedung = DB::table('mgedungs')->where('id', $id)->first();

        if (!$gedung) {
            return redirect()->route('gedung.index')->with('error', 'Data gedung tidak ditemukan.');
        }

        // Update data gedung menggunakan DB facade
        DB::table('mgedungs')->where('id', $id)->update([
            'NamaGedung' => $request->NamaGedung,
            'KodeGedung' => $request->KodeGedung,
            'JumlahLantaiGedung' => $request->TipeGedung === 'Mandiri' ? null : $request->JumlahLantaiGedung,
            'kapasitasGedung' => $request->TipeGedung === 'Fakultas' ? null : $request->kapasitasGedung,
            'FakultasID' => $request->TipeGedung === 'Mandiri' ? null : $request->FakultasID,
            'JurusanProgramID' => $request->TipeGedung === 'Mandiri' ? null : $request->JurusanProgramID,
            'UniversitasID' => $request->UniversitasID,
            'StatusGedung' => $request->StatusGedung,
            'TipeGedung' => $request->TipeGedung,
            'Keterangan' => $request->Keterangan,
            'statusGedungMandiri' => $request->statusGedungMandiri ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('gedung.index')->with('success', 'Data Gedung berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data gedung berdasarkan ID
        $gedung = mgedung::find($id);

        if (!$gedung) {
            return redirect()->route('gedung.index')->with('error', 'Data gedung tidak ditemukan.');
        }

        // Hapus data gedung
        $gedung->delete();

        return redirect()->route('gedung.index')->with('success', 'Data Gedung berhasil dihapus!');
    }
}
