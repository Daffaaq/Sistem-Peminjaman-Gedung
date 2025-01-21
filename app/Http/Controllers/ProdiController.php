<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdiRequest;
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
            ->leftJoin('mfakultas', 'mprodis.FakultasID', '=', 'mfakultas.id')
            ->leftJoin('muniversitas', 'mfakultas.UniversitasID', '=', 'muniversitas.id')
            ->select(
                'mprodis.NamaProdi',
                'mprodis.KodeProdi',
                'mprodis.id',
                'mfakultas.NamaFakultas',
                'muniversitas.NamaUniversitas'
            )
            ->when($request->input('NamaProdi'), function ($query, $NamaProdi) {
                return $query->where('mprodis.NamaProdi', 'like', '%' . $NamaProdi . '%');
            })
            ->when($request->input('FakultasID'), function ($query, $FakultasID) {
                return $query->where('mprodis.FakultasID', $FakultasID);
            })
            ->when($request->input('UniversitasID'), function ($query, $UniversitasID) {
                return $query->where('mfakultas.UniversitasID', $UniversitasID);
            })
            ->paginate(10);

        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();

        return view('prodi.index', compact('prodi', 'universitas'));
    }


    // Tambahkan di controller Anda
    public function getFakultasByUniversitas(Request $request)
    {
        $fakultas = DB::table('mfakultas')
            ->where('UniversitasID', $request->UniversitasID)
            ->select('id', 'NamaFakultas')
            ->get();
        Log::info('Fakultas data:', $fakultas->toArray());

        return response()->json($fakultas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universitas = DB::table('muniversitas')->select('id', 'NamaUniversitas')->get();

        return view('prodi.create', compact('universitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdiRequest $request)
    {
        DB::table('mprodis')->insert($request->validated());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
