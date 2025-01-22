@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Universitas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Universitas</a></div>
                <div class="breadcrumb-item">Tambah Universitas</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Universitas</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data Universitas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('universitas.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="NamaUniversitas">Nama Universitas</label>
                            <input type="text" class="form-control @error('NamaUniversitas') is-invalid @enderror"
                                id="NamaUniversitas" name="NamaUniversitas" placeholder="Enter Nama Universitas">
                            @error('NamaUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeUniversitas">Kode Universitas</label>
                            <input type="text" class="form-control @error('KodeUniversitas') is-invalid @enderror"
                                id="KodeUniversitas" name="KodeUniversitas" placeholder="Enter Kode Universitas">
                            @error('KodeUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="AlamatUniversitas">Alamat Universitas</label>
                            <input type="text" class="form-control @error('AlamatUniversitas') is-invalid @enderror"
                                id="AlamatUniversitas" name="AlamatUniversitas" placeholder="Enter Alamat Universitas">
                            @error('AlamatUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="NoTelpUniversitas">No Telp Universitas</label>
                            <input type="text" class="form-control @error('NoTelpUniversitas') is-invalid @enderror"
                                id="NoTelpUniversitas" name="NoTelpUniversitas" placeholder="Enter No Telp Universitas">
                            @error('NoTelpUniversitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="EmailUniversitas">Email Universitas</label>
                            <input type="email" class="form-control @error('EmailUniversitas') is-invalid @enderror"
                                id="EmailUniversitas" name="EmailUniversitas" placeholder="Enter Email Universitas">
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
                                <option value="" disabled selected>Pilih Status Universitas</option>
                                <option value="Active">Aktif</option>
                                <option value="InActive">Non Aktif</option>
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
                                <option value="" disabled selected>Pilih Tipe Institusi</option>
                                <option value="Universitas">Universitas</option>
                                <option value="Politeknik">Politeknik</option>
                            </select>
                            @error('TipeInstitusi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('universitas.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
