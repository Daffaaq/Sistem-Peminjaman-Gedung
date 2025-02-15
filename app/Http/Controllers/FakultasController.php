<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFakultasRequest;
use App\Http\Requests\UpdateFakultasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fakultas = DB::table('mfakultas')
            ->when($request->input('NamaFakultas'), function ($query, $NamaFakultas) {
                return $query->where('NamaFakultas', 'like', '%' . $NamaFakultas . '%');
            })
            ->when($request->input('UniversitasID'), function ($query, $UniversitasID) {
                return $query->where('mfakultas.UniversitasID', $UniversitasID);
            })
            ->leftJoin('muniversitas', 'mfakultas.UniversitasID', '=', 'muniversitas.id')
            ->select(
                'mfakultas.NamaFakultas',
                'mfakultas.KodeFakultas',
                'mfakultas.StatusFakultas',
                'mfakultas.id',
                'muniversitas.NamaUniversitas' // Kolom dari tabel muniversitas
            )
            ->where('muniversitas.TipeInstitusi', 'Universitas')
            ->paginate(10);

        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->where('TipeInstitusi', 'Universitas')->get();

        return view('fakultas.index', compact('fakultas', 'universitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->where('TipeInstitusi', 'Universitas')->get();
        // Jika data universitas tidak ditemukan
        if ($universitas->isEmpty()) {
            return redirect()->route('fakultas.index')->with('error', 'Data Universitas Tidak Ditemukan!');
        }
        return view('fakultas.create', compact('universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFakultasRequest $request)
    {
        DB::table('mfakultas')->insert(
            array_merge($request->validated(), [
                'created_at' => now(), // Menambahkan nilai created_at
            ])
        );
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil ditambahkan!');
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
        $fakultas = DB::table('mfakultas')->where('id', $id)->first();
        if (!$fakultas) {
            return redirect()->route('fakultas.index')->with('error', 'Data Fakultas Tidak Ditemukan!');
        }
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();
        if ($universitas->isEmpty()) {
            return redirect()->route('fakultas.index')->with('error', 'Data Universitas Tidak Ditemukan!');
        }

        return view('fakultas.edit', compact('fakultas', 'universitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFakultasRequest $request, string $id)
    {
        // Validasi data dan update fakultas menggunakan DB
        $updated = DB::table('mfakultas')
            ->where('id', $id)
            ->update(array_merge(
                $request->validated(),
                ['updated_at' => now()] // Tambahkan kolom updated_at
            ));

        return redirect()->route('fakultas.index')->with('success', 'Data Fakultas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cek jika data fakultas ada
        $fakultas = DB::table('mfakultas')->where('id', $id)->first();

        if (!$fakultas) {
            return redirect()->route('fakultas.index')->with('error', 'Data Fakultas Tidak Ditemukan!');
        }

        // Hapus data fakultas
        $deleted = DB::table('mfakultas')->where('id', $id)->delete();

        return redirect()->route('fakultas.index')->with('success', 'Data Fakultas berhasil dihapus!');
    }
}
