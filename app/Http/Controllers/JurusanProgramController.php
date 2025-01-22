<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJurusanProgramRequest;
use App\Http\Requests\UpdateJurusanProgramRequest;
use App\Models\mjurusanprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jurusanPrograms = DB::table('mjurusanprograms')
            ->when($request->input('NamaJurusanPrograms'), function ($query, $NamaJurusanPrograms) {
                return $query->where('NamaJurusanPrograms', 'like', '%' . $NamaJurusanPrograms . '%');
            })
            ->when($request->input('FakultasID'), function ($query, $FakultasID) {
                return $query->where('mjurusanprograms.FakultasID', $FakultasID);
            })
            ->when($request->input('UniversitasID'), function ($query, $UniversitasID) {
                return $query->where('mjurusanprograms.UniversitasID', $UniversitasID);
            })
            ->leftJoin('mfakultas', 'mjurusanprograms.FakultasID', '=', 'mfakultas.id')
            ->leftJoin('muniversitas', 'mjurusanprograms.UniversitasID', '=', 'muniversitas.id')
            ->select(
                'mjurusanprograms.id',
                'mjurusanprograms.NamaJurusanPrograms',
                'mjurusanprograms.KodeJurusanProgram',
                'mjurusanprograms.StatusJurusanPrograms',
                'mfakultas.NamaFakultas as Fakultas',
                'muniversitas.NamaUniversitas as Universitas',
                'muniversitas.TipeInstitusi as TipeUniversitas'
            )
            ->paginate(10);
        // dd($jurusanPrograms);
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();
        $fakultas = DB::table('mfakultas')->select('id', 'NamaFakultas')->get();

        return view('jurusan_programs.index', compact('jurusanPrograms', 'universitas', 'fakultas'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();
        $fakultas = DB::table('mfakultas')->select('id', 'NamaFakultas')->get();
        return view('jurusan_programs.create', compact('universitas', 'fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJurusanProgramRequest $request)
    {
        DB::table('mjurusanprograms')->insert([
            'NamaJurusanPrograms' => $request->NamaJurusanPrograms,
            'KodeJurusanProgram' => $request->KodeJurusanProgram,
            'FakultasID' => $request->FakultasID ?? null,
            'UniversitasID' => $request->UniversitasID,
            'StatusJurusanPrograms' => $request->StatusJurusanPrograms,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('jurusan-program.index')->with('success', 'Jurusan Program berhasil disimpan');
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
        // Ambil data jurusan program berdasarkan ID
        $jurusanProgram = mjurusanprogram::findOrFail($id);

        // Ambil semua universitas dan fakultas untuk dropdown
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();
        $fakultas = DB::table('mfakultas')->select('id', 'NamaFakultas')->get();

        // Kirim data ke view 'jurusan_programs.edit'
        return view('jurusan_programs.edit', compact('jurusanProgram', 'universitas', 'fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJurusanProgramRequest $request, string $id)
    {
        // Ambil data jurusan program yang ingin diupdate
        $jurusanProgram = mjurusanprogram::findOrFail($id);

        // Update data jurusan program
        $jurusanProgram->update([
            'NamaJurusanPrograms' => $request->NamaJurusanPrograms,
            'KodeJurusanProgram' => $request->KodeJurusanProgram,
            'FakultasID' => $request->FakultasID ?? null,  // Jika FakultasID null, simpan null
            'UniversitasID' => $request->UniversitasID,
            'StatusJurusanPrograms' => $request->StatusJurusanPrograms,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('jurusan-program.index')->with('success', 'Jurusan Program berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari jurusan program berdasarkan ID
        $jurusanProgram = mjurusanprogram::findOrFail($id);

        // Hapus data jurusan program
        $jurusanProgram->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('jurusan-program.index')->with('success', 'Jurusan Program berhasil dihapus');
    }

    public function getUniversitasType($universitasID)
    {
        $universitas = DB::table('muniversitas')->where('id', $universitasID)->first();

        if ($universitas) {
            return response()->json($universitas);
        }

        return response()->json(['error' => 'Universitas not found'], 404);
    }
}
