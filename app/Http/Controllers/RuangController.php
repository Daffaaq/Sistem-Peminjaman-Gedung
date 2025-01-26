<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRuangRequest;
use App\Http\Requests\UpdateRuangRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ruang = DB::table('mruangans')
            ->leftJoin('mgedungs', 'mruangans.GedungID', '=', 'mgedungs.id')
            ->leftJoin('mfakultas', 'mgedungs.FakultasID', '=', 'mfakultas.id')
            ->leftJoin('muniversitas', 'mgedungs.UniversitasID', '=', 'muniversitas.id')
            ->leftJoin('mjurusanprograms', 'mgedungs.JurusanProgramID', '=', 'mjurusanprograms.id')
            ->select(
                'mfakultas.NamaFakultas',
                'mjurusanprograms.NamaJurusanPrograms',
                'muniversitas.NamaUniversitas',
                'mgedungs.NamaGedung',
                'mjurusanprograms.NamaJurusanPrograms',
                'mruangans.NamaRuang',
                'mruangans.KodeRuang',
                'mruangans.StatusRuang',
                'mruangans.id'
            )
            ->when($request->input('NamaRuang'), function ($query, $NamaRuang) {
                return $query->where('NamaRuang', 'like', '%' . $NamaRuang . '%');
            })
            ->when($request->input('FakultasID'), function ($query, $FakultasID) {
                return $query->where('mgedungs.FakultasID', $FakultasID);
            })
            ->when($request->input('JurusanProgramID'), function ($query, $JurusanProgramID) {
                return $query->where('mgedungs.JurusanProgramID', $JurusanProgramID);
            })
            ->when($request->input('UniversitasID'), function ($query, $UniversitasID) {
                return $query->where('mgedungs.UniversitasID', $UniversitasID);
            })
            ->paginate(10);

        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();
        return view('ruang.index', compact('ruang', 'universitas'));
    }

    public function getGedung(Request $request)
    {
        $universitasID = $request->input('UniversitasID');
        $tipeInstitusi = DB::table('muniversitas')->where('id', $universitasID)->value('TipeInstitusi');

        if ($tipeInstitusi === 'Universitas') {
            // Jika tipe institusi adalah Universitas
            $gedung = DB::table('mgedungs')
                ->leftJoin('mfakultas', 'mgedungs.FakultasID', '=', 'mfakultas.id')
                ->leftJoin('mjurusanprograms', 'mgedungs.JurusanProgramID', '=', 'mjurusanprograms.id')
                ->select(
                    'mgedungs.id',
                    'mgedungs.NamaGedung',
                    'mgedungs.TipeGedung',
                    'mfakultas.id as FakultasID',
                    'mfakultas.NamaFakultas',
                    'mjurusanprograms.id as JurusanProgramID',
                    'mjurusanprograms.NamaJurusanPrograms'
                )
                ->where('mgedungs.UniversitasID', $universitasID)
                ->where('mgedungs.TipeGedung', 'Fakultas')
                ->get();
            // dd($gedung);
            return response()->json([
                'type' => 'Universitas',
                'data' => $gedung,
            ]);
        } elseif ($tipeInstitusi === 'Politeknik') {
            // Jika tipe institusi adalah Politeknik
            $gedung = DB::table('mgedungs')
                ->leftJoin('mjurusanprograms', 'mgedungs.JurusanProgramID', '=', 'mjurusanprograms.id')
                ->select(
                    'mgedungs.id',
                    'mgedungs.NamaGedung',
                    'mgedungs.TipeGedung',
                    'mjurusanprograms.id as JurusanProgramID',
                    'mjurusanprograms.NamaJurusanPrograms'
                )
                ->where('mgedungs.UniversitasID', $universitasID)
                ->where('mgedungs.TipeGedung', 'Fakultas')
                ->get();

            return response()->json([
                'type' => 'Politeknik',
                'data' => $gedung,
            ]);
        }

        return response()->json([
            'type' => 'Unknown',
            'data' => [],
            'message' => 'Tipe institusi tidak valid.',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();
        return view('ruang.create', compact('universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRuangRequest $request)
    {
        // Validasi otomatis dilakukan oleh StoreRuangRequest
        $validatedData = $request->validated();

        // Simpan data ke database menggunakan Eloquent
        \App\Models\mruangan::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()
            ->route('ruang.index')
            ->with('success', 'Ruang berhasil ditambahkan.');
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
    public function edit($id)
    {
        // Ambil data ruang berdasarkan ID
        $ruang = \App\Models\mruangan::findOrFail($id);

        // Ambil data Universitas berdasarkan UniversitasID ruang
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();

        // Ambil data Gedung berdasarkan UniversitasID, dan langsung include Fakultas dan JurusanProgram
        $gedungs = DB::table('mgedungs')
            ->leftJoin('mfakultas', 'mgedungs.FakultasID', '=', 'mfakultas.id')
            ->leftJoin('muniversitas', 'mgedungs.UniversitasID', '=', 'muniversitas.id')
            ->leftJoin('mjurusanprograms', 'mgedungs.JurusanProgramID', '=', 'mjurusanprograms.id')
            ->select(
                'mgedungs.id',
                'mgedungs.NamaGedung',
                'mgedungs.TipeGedung',
                'mfakultas.id as FakultasID',
                'mfakultas.NamaFakultas',
                'mjurusanprograms.id as JurusanProgramID',
                'mjurusanprograms.NamaJurusanPrograms',
                'muniversitas.id as UniversitasID',
                'muniversitas.NamaUniversitas'
            )
            ->where('mgedungs.TipeGedung', 'Fakultas')
            ->where('mgedungs.id', $ruang->GedungID) // Pastikan GedungID sesuai
            ->first();

        // dd($ruang, $gedungs);
        // Jika data Gedung tidak ditemukan, kamu bisa menambahkan pengecekan
        if (!$gedungs) {
            return redirect()->route('ruang.index')->with('error', 'Gedung tidak ditemukan.');
        }

        // Kirim data ke view
        return view('ruang.edit', compact('ruang', 'universitas', 'gedungs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRuangRequest $request, string $id)
    {
        // Validasi data dengan menggunakan request
        $validatedData = $request->validated();

        // Cari data ruang berdasarkan ID
        $ruang = \App\Models\mruangan::findOrFail($id);

        // Perbarui data ruang dengan data yang telah divalidasi
        $ruang->update($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data ruang berdasarkan ID
        $ruang = \App\Models\mruangan::findOrFail($id);

        // Hapus data ruang
        $ruang->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus.');
    }
}
