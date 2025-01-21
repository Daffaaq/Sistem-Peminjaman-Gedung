@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Fakultas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Fakultas</a></div>
                <div class="breadcrumb-item">Tambah Fakultas</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Fakultas</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data Fakultas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('fakultas.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="NamaFakultas">Nama Fakultas</label>
                            <input type="text" class="form-control @error('NamaFakultas') is-invalid @enderror"
                                id="NamaFakultas" name="NamaFakultas" placeholder="Enter Nama Fakultas">
                            @error('NamaFakultas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeFakultas">Kode Fakultas</label>
                            <input type="text" class="form-control @error('KodeFakultas') is-invalid @enderror"
                                id="KodeFakultas" name="KodeFakultas" placeholder="Enter Kode Fakultas">
                            @error('KodeFakultas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="UniversitasID">Universitas</label>
                            <select class="form-control @error('UniversitasID') is-invalid @enderror" id="UniversitasID" name="UniversitasID">
                                <option value="">Pilih Universitas</option>
                                @foreach($universitas as $uni)
                                    <option value="{{ $uni->id }}">{{ $uni->NamaUniversitas }}</option>
                                @endforeach
                            </select>
                            @error('UniversitasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('fakultas.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
