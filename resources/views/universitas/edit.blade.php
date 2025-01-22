@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Universitas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Universitas</a></div>
                <div class="breadcrumb-item">Edit Universitas</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Universitas</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Data Universitas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('universitas.update', $universitas->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="NamaUniversitas">Nama Universitas</label>
                            <input type="text" class="form-control @error('NamaUniversitas') is-invalid @enderror"
                                id="NamaUniversitas" name="NamaUniversitas" value="{{ $universitas->NamaUniversitas }}"
                                placeholder="Enter Nama Universitas">
                            @error('NamaUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeUniversitas">Kode Universitas</label>
                            <input type="text" class="form-control @error('KodeUniversitas') is-invalid @enderror"
                                id="KodeUniversitas" name="KodeUniversitas" value="{{ $universitas->KodeUniversitas }}"
                                placeholder="Enter Kode Universitas">
                            @error('KodeUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="AlamatUniversitas">Alamat Universitas</label>
                            <input type="text" class="form-control @error('AlamatUniversitas') is-invalid @enderror"
                                id="AlamatUniversitas" name="AlamatUniversitas"
                                value="{{ $universitas->AlamatUniversitas }}" placeholder="Enter Alamat Universitas">
                            @error('AlamatUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="NoTelpUniversitas">No Telp Universitas</label>
                            <input type="text" class="form-control @error('NoTelpUniversitas') is-invalid @enderror"
                                id="NoTelpUniversitas" name="NoTelpUniversitas"
                                value="{{ $universitas->NoTelpUniversitas }}" placeholder="Enter No Telp Universitas">
                            @error('NoTelpUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="EmailUniversitas">Email Universitas</label>
                            <input type="email" class="form-control @error('EmailUniversitas') is-invalid @enderror"
                                id="EmailUniversitas" name="EmailUniversitas" value="{{ $universitas->EmailUniversitas }}"
                                placeholder="Enter Email Universitas">
                            @error('EmailUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusUniversitas">Status Universitas</label>
                            <select class="form-control @error('StatusUniversitas') is-invalid @enderror"
                                id="StatusUniversitas" name="StatusUniversitas">
                                <option value="" disabled>Pilih Status Universitas</option>
                                <option value="Active" {{ $universitas->StatusUniversitas == 'Active' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="InActive"
                                    {{ $universitas->StatusUniversitas == 'InActive' ? 'selected' : '' }}>
                                    Non Aktif
                                </option>
                            </select>
                            @error('StatusUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="TipeInstitusi">Tipe Institusi</label>
                            <select class="form-control @error('TipeInstitusi') is-invalid @enderror" id="TipeInstitusi"
                                name="TipeInstitusi">
                                <option value="" disabled>Pilih Tipe Institusi</option>
                                <option value="Universitas"
                                    {{ $universitas->TipeInstitusi == 'Universitas' ? 'selected' : '' }}>
                                    Universitas
                                </option>
                                <option value="Politeknik"
                                    {{ $universitas->TipeInstitusi == 'Politeknik' ? 'selected' : '' }}>
                                    Politeknik
                                </option>
                            </select>
                            @error('TipeInstitusi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Update</button>
                    <a class="btn btn-secondary" href="{{ route('universitas.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
