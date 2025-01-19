<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUniversitasRequest;
use App\Http\Requests\UpdateUniversitasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniversitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:universitas.index')->only('index');
        $this->middleware('permission:universitas.create')->only('create', 'store');
        $this->middleware('permission:universitas.edit')->only('edit', 'update');
        $this->middleware('permission:universitas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $universitas = DB::table('muniversitas')
            ->when($request->input('NamaUniversitas'), function ($query, $NamaUniversitas) {
                return $query->where('NamaUniversitas', 'like', '%' . $NamaUniversitas . '%');
            })
            ->select('id', 'NamaUniversitas', 'KodeUniversitas', 'AlamatUniversitas', 'NoTelpUniversitas', 'EmailUniversitas')
            ->paginate(10);

        return view('universitas.index', compact('universitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('universitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUniversitasRequest $request)
    {
        DB::table('muniversitas')->insert([
            'NamaUniversitas' => $request->NamaUniversitas,
            'KodeUniversitas' => $request->KodeUniversitas,
            'AlamatUniversitas' => $request->AlamatUniversitas,
            'NoTelpUniversitas' => $request->NoTelpUniversitas,
            'EmailUniversitas' => $request->EmailUniversitas
        ]);

        return redirect()->route('universitas.index')->with('success', 'Data berhasil disimpan');
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
        $universitas = DB::table('muniversitas')->where('id', $id)->first();
        return view('universitas.edit', compact('universitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversitasRequest $request, string $id)
    {
        DB::table('muniversitas')->where('id', $id)->update([
            'NamaUniversitas' => $request->NamaUniversitas,
            'KodeUniversitas' => $request->KodeUniversitas,
            'AlamatUniversitas' => $request->AlamatUniversitas,
            'NoTelpUniversitas' => $request->NoTelpUniversitas,
            'EmailUniversitas' => $request->EmailUniversitas
        ]);

        return redirect()->route('universitas.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('muniversitas')->where('id', $id)->delete();
        return redirect()->route('universitas.index')->with('success', 'Data berhasil dihapus');
    }
}
