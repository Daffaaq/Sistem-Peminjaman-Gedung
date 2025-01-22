<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdiRequest;
use App\Http\Requests\UpdateProdiRequest;
use App\Models\mprodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prodi = DB::table('mprodis')
            ->leftJoin('mjurusanprograms', 'mprodis.JurusanProgramID', '=', 'mjurusanprograms.id')
            ->leftJoin('mfakultas', 'mprodis.FakultasID', '=', 'mfakultas.id')
            ->leftJoin('muniversitas as universitas_fakultas', 'mfakultas.UniversitasID', '=', 'universitas_fakultas.id') // Alias untuk universitas melalui fakultas
            ->leftJoin('muniversitas as universitas_jurusan', 'mjurusanprograms.UniversitasID', '=', 'universitas_jurusan.id') // Alias untuk universitas melalui jurusan program
            ->select(
                'mprodis.NamaProdi',
                'mprodis.KodeProdi',
                'mprodis.StatusProdi',
                'mprodis.id',
                'mfakultas.NamaFakultas',
                'mjurusanprograms.NamaJurusanPrograms',
                'universitas_fakultas.NamaUniversitas as NamaUniversitasFakultas',
                'universitas_jurusan.NamaUniversitas as NamaUniversitasJurusan'
            )
            ->when($request->input('NamaProdi'), function ($query, $NamaProdi) {
                return $query->where('mprodis.NamaProdi', 'like', '%' . $NamaProdi . '%');
            })
            ->when($request->input('FakultasID'), function ($query, $FakultasID) {
                return $query->where('mprodis.FakultasID', $FakultasID);
            })
            ->when($request->input('JurusanProgramID'), function ($query, $JurusanProgramID) {
                return $query->where('mprodis.JurusanProgramID', $JurusanProgramID);
            })
            ->when($request->input('UniversitasID'), function ($query, $UniversitasID) {
                return $query->where(function ($q) use ($UniversitasID) {
                    $q->where('mfakultas.UniversitasID', $UniversitasID)
                        ->orWhere('mjurusanprograms.UniversitasID', $UniversitasID);
                });
            })
            ->paginate(10);
            
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();

        return view('prodi.index', compact('prodi', 'universitas'));
    }

    public function getFakultasByUniversitas(Request $request)
    {
        $universitasID = $request->UniversitasID;
        $tipeInstitusi = $request->input('TipeInstitusi');

        $query = DB::table('mfakultas')
            ->where('UniversitasID', $universitasID)
            ->select('id', 'NamaFakultas');

        // Filter fakultas jika tipe institusi adalah Universitas
        if ($tipeInstitusi === 'Universitas') {
            $query->where('UniversitasID', $universitasID);
        }

        $fakultas = $query->get();
        return response()->json($fakultas);
    }

    public function getJurusanProgramsByUniversitas(Request $request)
    {
        $universitasID = $request->UniversitasID;
        $fakultasID = $request->FakultasID;
        $tipeInstitusi = $request->input('TipeInstitusi');

        Log::info("UniversitasID: $universitasID, FakultasID: $fakultasID, TipeInstitusi: $tipeInstitusi");
        $query = DB::table('mjurusanprograms')
            ->select('id', 'NamaJurusanPrograms');

        // Jika Tipe Institusi adalah Universitas, maka filter berdasarkan Fakultas
        if ($tipeInstitusi == 'Universitas') {
            if ($fakultasID) {
                // Filter berdasarkan Fakultas jika Universitas
                $query->where('FakultasID', $fakultasID);
            }
        }
        // Jika Tipe Institusi adalah Politeknik, tampilkan semua jurusan tanpa filter fakultas
        elseif ($tipeInstitusi == 'Politeknik') {
            $query->where('UniversitasID', $universitasID); // Tidak perlu filter berdasarkan Fakultas
        }

        $jurusanProgram = $query->get();

        Log::info('Jurusan Program data:', $jurusanProgram->toArray());
        return response()->json($jurusanProgram);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();

        return view('prodi.create', compact('universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdiRequest $request)
    {
        DB::table('mprodis')->insert([
            'NamaProdi' => $request->NamaProdi,
            'KodeProdi' => $request->KodeProdi,
            'strata' => $request->strata,
            'StatusProdi' => $request->StatusProdi,
            'JurusanProgramID' => $request->JurusanProgramID,
            'FakultasID' => $request->FakultasID ?? null,
        ]);
        return redirect()->route('program-studi.index')->with('success', 'Data Program Studi berhasil ditambahkan!');
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
        // Ambil data program studi berdasarkan ID menggunakan DB Query
        $prodi = DB::table('mprodis')->where('id', $id)->first();

        // Jika data tidak ditemukan, redirect dengan pesan error
        if (!$prodi) {
            return redirect()->route('program-studi.index')->withErrors('Data Program Studi tidak ditemukan.');
        }

        // Ambil data JurusanProgram yang terhubung dengan Prodi
        $jurusanProgram = DB::table('mjurusanprograms')->where('id', $prodi->JurusanProgramID)->first();

        // Jika data jurusan ditemukan, ambil Fakultas dan Universitas yang terkait
        $fakultas = [];
        $universitas = [];

        // Jika jurusanProgram ada, ambil data Fakultas dan Universitas
        if ($jurusanProgram) {
            // Ambil Fakultas jika JurusanProgram memiliki FakultasID
            if ($jurusanProgram->FakultasID) {
                $fakultas = DB::table('mfakultas')->where('id', $jurusanProgram->FakultasID)->get();
            }

            // Ambil Universitas dari JurusanProgram
            $universitas = DB::table('muniversitas')->where('id', $jurusanProgram->UniversitasID)->first();
        }

        // Ambil daftar universitas untuk dropdown
        $universitasList = DB::table('muniversitas')->select('id', 'NamaUniversitas', 'TipeInstitusi')->get();

        // Kembalikan data ke view
        return view('prodi.edit', compact('prodi', 'universitasList', 'fakultas', 'jurusanProgram', 'universitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdiRequest $request, string $id)
    {
        $prodi = DB::table('mprodis')->where('id', $id)->first();

        if (!$prodi) {
            return redirect()->route('program-studi.index')->with('error', 'Data Program Studi tidak ditemukan!');
        }

        // Validasi hubungan JurusanProgram dan Fakultas
        $jurusanProgram = DB::table('mjurusanprograms')->where('id', $request->JurusanProgramID)->first();

        if (!$jurusanProgram) {
            return redirect()->route('program-studi.index')->withErrors('JurusanProgram tidak valid.');
        }

        if ($request->FakultasID && $jurusanProgram->FakultasID != $request->FakultasID) {
            return redirect()->route('program-studi.index')->withErrors('Fakultas tidak sesuai dengan JurusanProgram.');
        }

        DB::table('mprodis')->where('id', $id)->update([
            'NamaProdi' => $request->NamaProdi,
            'KodeProdi' => $request->KodeProdi,
            'strata' => $request->strata,
            'StatusProdi' => $request->StatusProdi,
            'JurusanProgramID' => $request->JurusanProgramID,
            'FakultasID' => $request->FakultasID ?? null,
        ]);

        return redirect()->route('program-studi.index')->with('success', 'Data Program Studi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cek apakah data program studi ada
        $prodi = DB::table('mprodis')->where('id', $id)->first();

        if (!$prodi) {
            return redirect()->route('program-studi.index')->with('error', 'Data Program Studi tidak ditemukan!');
        }

        // Hapus data program studi
        DB::table('mprodis')->where('id', $id)->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('program-studi.index')->with('success', 'Data Program Studi berhasil dihapus!');
    }
}
