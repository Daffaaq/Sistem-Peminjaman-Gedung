@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Ruang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Ruang</a></div>
                <div class="breadcrumb-item">Tambah Ruang</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Ruang</h2>
            @if (session('error'))
                <div class="alert alert-light-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Ruang</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('ruang.store') }}" method="post">
                        @csrf

                        <!-- Dropdown Universitas -->
                        <div class="form-group">
                            <label for="UniversitasID">Universitas</label>
                            <select class="form-control @error('UniversitasID') is-invalid @enderror" id="UniversitasID"
                                name="UniversitasID">
                                <option value="">Pilih Universitas</option>
                                @foreach ($universitas as $uni)
                                    <option value="{{ $uni->id }}">{{ $uni->NamaUniversitas }}</option>
                                @endforeach
                            </select>
                            @error('UniversitasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Dropdown Fakultas -->
                        <div class="form-group" id="FakultasDiv" style="display: none;">
                            <label for="FakultasID">Fakultas</label>
                            <select class="form-control @error('FakultasID') is-invalid @enderror" id="FakultasID"
                                name="FakultasID">
                                <option value="">Pilih Fakultas</option>
                            </select>
                            @error('FakultasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Dropdown Jurusan Program -->
                        <div class="form-group" id="JurusanProgramDiv" style="display: none;">
                            <label for="JurusanProgramID">Jurusan Program</label>
                            <select class="form-control @error('JurusanProgramID') is-invalid @enderror"
                                id="JurusanProgramID" name="JurusanProgramID">
                                <option value="">Pilih Jurusan Program</option>
                            </select>
                            @error('JurusanProgramID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Dropdown Gedung -->
                        <div class="form-group">
                            <label for="GedungID">Gedung</label>
                            <select class="form-control @error('GedungID') is-invalid @enderror" id="GedungID"
                                name="GedungID">
                                <option value="">Pilih Gedung</option>
                            </select>
                            @error('GedungID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Input untuk Nama Ruang -->
                        <div class="form-group">
                            <label for="NamaRuang">Nama Ruang</label>
                            <input type="text" class="form-control @error('NamaRuang') is-invalid @enderror"
                                id="NamaRuang" name="NamaRuang" value="{{ old('NamaRuang') }}"
                                placeholder="Masukkan Nama Ruang">
                            @error('NamaRuang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeRuang">Kode Ruang</label>
                            <input type="text" class="form-control @error('KodeRuang') is-invalid @enderror"
                                id="KodeRuang" name="KodeRuang" value="{{ old('KodeRuang') }}"
                                placeholder="Masukkan Kode Ruang">
                            @error('KodeRuang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Input untuk Kapasitas -->
                        <div class="form-group">
                            <label for="KapasitasRuang">Kapasitas</label>
                            <input type="number" class="form-control @error('KapasitasRuang') is-invalid @enderror"
                                id="KapasitasRuang" name="KapasitasRuang" value="{{ old('KapasitasRuang') }}"
                                min="1">
                            @error('KapasitasRuang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusRuang">Status Ruangan</label>
                            <select class="form-control @error('StatusRuang') is-invalid @enderror" id="StatusRuang"
                                name="StatusRuang">
                                <option value="" disabled selected>Pilih Status Ruangan</option>
                                <option value="Active">Aktif</option>
                                <option value="InActive">Non Aktif</option>
                            </select>
                            @error('StatusRuang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusBooked">Status Ruangan (Booked/Available)</label>
                            <select class="form-control @error('StatusBooked') is-invalid @enderror" id="StatusBooked"
                                name="StatusBooked">
                                <option value="" disabled selected>Pilih Status Ruangan</option>
                                <option value="Booked">Booked</option>
                                <option value="Available">Available</option>
                            </select>
                            @error('StatusBooked')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Input untuk Deskripsi Ruang -->
                        <div class="form-group">
                            <label for="Deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('Deskripsi') is-invalid @enderror" id="Deskripsi" name="Deskripsi"
                                rows="3" placeholder="Masukkan Deskripsi Ruang">{{ old('Deskripsi') }}</textarea>
                            @error('Deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                            <a class="btn btn-secondary" href="{{ route('ruang.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            $('#UniversitasID').change(function() {
                const universitasID = $(this).val();
                const fakultasDropdown = $('#FakultasID');
                const jurusanDropdown = $('#JurusanProgramID');
                const gedungDropdown = $('#GedungID');
                const jurusanDiv = $('#JurusanProgramDiv');
                const fakultasDiv = $('#FakultasDiv');

                if (universitasID) {
                    // AJAX to get Gedung (building) and Fakultas (faculty)
                    $.ajax({
                        url: '/master-management/getGedung',
                        method: 'GET',
                        data: {
                            UniversitasID: universitasID
                        },
                        success: function(response) {
                            if (response.type === 'Universitas') {
                                fakultasDiv.show();
                                fakultasDropdown.empty().append(
                                    '<option value="">Pilih Fakultas</option>');

                                // Populate Fakultas dropdown
                                $.each(response.data, function(key, value) {
                                    fakultasDropdown.append('<option value="' + value
                                        .FakultasID + '">' + value.NamaFakultas +
                                        '</option>');
                                });

                                // If there's JurusanProgramID data, show the dropdown
                                if (response.data.some(item => item.JurusanProgramID !==
                                        null)) {
                                    jurusanDiv.show();
                                    jurusanDropdown.empty().append(
                                        '<option value="">Pilih Jurusan Program</option>');

                                    // Populate Jurusan Program dropdown if available
                                    $.each(response.data, function(key, value) {
                                        if (value.JurusanProgramID) {
                                            jurusanDropdown.append('<option value="' +
                                                value.JurusanProgramID + '">' +
                                                value.NamaJurusanPrograms +
                                                '</option>');
                                        }
                                    });
                                } else {
                                    jurusanDiv.hide(); // Hide if no JurusanProgram data
                                }
                            } else {
                                // Hide Fakultas and show Jurusan if no Universitas selected
                                fakultasDiv.hide();
                                jurusanDiv.show();
                                jurusanDiv.show();
                                jurusanDropdown.empty().append(
                                    '<option value="">Pilih Jurusan Program</option>');

                                // Populate Jurusan Program dropdown if available
                                $.each(response.data, function(key, value) {
                                    if (value.JurusanProgramID) {
                                        jurusanDropdown.append('<option value="' +
                                            value.JurusanProgramID + '">' +
                                            value.NamaJurusanPrograms +
                                            '</option>');
                                    }
                                });
                            }

                            // Fill Gedung dropdown
                            gedungDropdown.empty().append(
                                '<option value="">Pilih Gedung</option>');
                            $.each(response.data, function(key, value) {
                                gedungDropdown.append('<option value="' + value.id +
                                    '">' + value.NamaGedung + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error: ", status, error);
                        }
                    });
                } else {
                    // Hide Fakultas, Jurusan Program, and Gedung if no Universitas selected
                    fakultasDiv.hide();
                    jurusanDiv.hide();
                    gedungDropdown.empty().append('<option value="">Pilih Gedung</option>');
                }
            });
        });
    </script>
@endpush
