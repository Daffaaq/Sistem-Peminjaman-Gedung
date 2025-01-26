@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Program Studi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Program Studi</a></div>
                <div class="breadcrumb-item">Tambah Program Studi</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Program Studi</h2>

            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h4>Validasi Tambah Data Program Studi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gedung.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="TipeGedung">Tipe Gedung</label>
                            <select class="form-control @error('TipeGedung') is-invalid @enderror" id="TipeGedung"
                                name="TipeGedung">
                                <option value=""selected>Pilih Status Jurusan Program</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="Fakultas">Fakultas/Jurusan</option>
                            </select>
                            @error('TipeGedung')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="UniversitasID">Universitas</label>
                            <select class="form-control @error('UniversitasID') is-invalid @enderror" id="UniversitasID"
                                name="UniversitasID">
                                <option value="">Pilih Universitas</option>
                                @foreach ($universitas as $uni)
                                    <option value="{{ $uni->id }}" data-tipe="{{ $uni->TipeInstitusi }}">
                                        {{ $uni->NamaUniversitas }} - {{ $uni->TipeInstitusi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('UniversitasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group" id="Fakultas">
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

                        <div class="form-group" id="JurusanProgram">
                            <label for="JurusanProgramID">Jurusan Program</label>
                            <select class="form-control @error('JurusanProgramID') is-invalid @enderror"
                                id="JurusanProgramID" name="JurusanProgramID">
                                <option value="">Pilih Jurusan Program</option>
                            </select>
                            <small>Jika Tipe Universitas adalah Universitas, maka Jurusan Program opsional boleh diisi wajib
                                atau tidak</small>
                            @error('JurusanProgramID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="NamaGedung">Nama Gedung</label>
                            <input type="text" class="form-control @error('NamaGedung') is-invalid @enderror"
                                id="NamaGedung" name="NamaGedung" placeholder="Enter Nama Gedung">
                            @error('NamaGedung')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeGedung">Kode Gedung</label>
                            <input type="text" class="form-control @error('KodeGedung') is-invalid @enderror"
                                id="KodeGedung" name="KodeGedung" placeholder="Enter Kode Program Studi">
                            @error('KodeGedung')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group" id="kapasitasGedung">
                            <label for="kapasitasGedung">Kapasitas Gedung</label>
                            <input type="number" class="form-control @error('kapasitasGedung') is-invalid @enderror"
                                id="kapasitasGedung" name="kapasitasGedung" placeholder="Enter Kode Program Studi">
                            @error('kapasitasGedung')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group" id="JumlahLantaiGedung">
                            <label for="JumlahLantaiGedung">Jumlah Lantai Gedung</label>
                            <input type="number" class="form-control @error('JumlahLantaiGedung') is-invalid @enderror"
                                id="JumlahLantaiGedung" name="JumlahLantaiGedung" placeholder="Enter Kode Program Studi">
                            @error('JumlahLantaiGedung')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusGedung">Status Gedung</label>
                            <select class="form-control @error('StatusGedung') is-invalid @enderror" id="StatusGedung"
                                name="StatusGedung">
                                <option value="" disabled selected>Pilih Status Gedung</option>
                                <option value="Active">Aktif</option>
                                <option value="InActive">Non Aktif</option>
                            </select>
                            @error('StatusGedung')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="statusGedungMandiri">Status Gedung</label>
                            <select class="form-control @error('statusGedungMandiri') is-invalid @enderror"
                                id="statusGedungMandiri" name="statusGedungMandiri">
                                <option value="" disabled selected>Pilih Status Jurusan Program</option>
                                <option value="Booked">Booked</option>
                                <option value="Available">Available</option>
                            </select>
                            @error('statusGedungMandiri')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Keterangan">Keterangan Gedung</label>
                            <div>
                                <textarea id="Keterangan" name="Keterangan" rows="4" cols="80">
                                </textarea>
                            </div>
                            @error('Keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('gedung.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            $('#TipeGedung').change(function() {
                const tipeGedung = $(this).val();
                const fakultas = $('#Fakultas');
                const jurusan = $('#JurusanProgram');
                const JumlahLantaiGedung = $('#JumlahLantaiGedung');
                const kapasitasGedung = $('#kapasitasGedung');
                if (tipeGedung === 'Mandiri') {
                    fakultas.hide();
                    jurusan.hide();
                    JumlahLantaiGedung.hide();
                    kapasitasGedung.show();
                } else if (tipeGedung === 'Fakultas') {
                    fakultas.show();
                    jurusan.show();
                    JumlahLantaiGedung.show();
                    kapasitasGedung.hide();
                }
            });


            $('#UniversitasID').change(function() {
                const universitasID = $(this).val();
                const tipeInstitusi = $('#UniversitasID option:selected').data(
                    'tipe');
                const fakultasDropdown = $('#FakultasID');
                const jurusanDropdown = $('#JurusanProgramID');

                fakultasDropdown.empty();
                jurusanDropdown.empty();

                if (universitasID) {
                    if (tipeInstitusi === 'Universitas') {
                        fakultasDropdown.append('<option value="" disabled selected>Loading...</option>');

                        $.ajax({
                            url: "{{ route('getFakultas') }}",
                            type: "GET",
                            data: {
                                UniversitasID: universitasID
                            },
                            success: function(response) {
                                console.log(
                                    response); // Pastikan response memiliki data yang benar
                                fakultasDropdown.empty();
                                if (response.length > 0) { // response adalah array langsung
                                    fakultasDropdown.append(
                                        '<option value="" disabled selected>-- Pilih Fakultas --</option>'
                                    );
                                    response.forEach(function(fakultas) {
                                        fakultasDropdown.append(
                                            `<option value="${fakultas.id}">${fakultas.NamaFakultas}</option>`
                                        );
                                    });

                                    // Ketika Fakultas dipilih
                                    fakultasDropdown.change(function() {
                                        const fakultasID = $(this).val();
                                        jurusanDropdown.empty();
                                        jurusanDropdown.append(
                                            '<option value="" disabled selected>Loading...</option>'
                                        );

                                        if (fakultasID) {
                                            $.ajax({
                                                url: "{{ route('getJurusanProgram') }}",
                                                type: "GET",
                                                data: {
                                                    UniversitasID: universitasID,
                                                    FakultasID: fakultasID,
                                                    TipeInstitusi: tipeInstitusi
                                                },
                                                success: function(response) {
                                                    jurusanDropdown.empty();
                                                    jurusanDropdown.append(
                                                        '<option value="" selected>-- Pilih Jurusan Program --</option>'
                                                    );
                                                    response.forEach(
                                                        function(
                                                            jurusanProgram
                                                        ) {
                                                            jurusanDropdown
                                                                .append(
                                                                    `<option value="${jurusanProgram.id}">${jurusanProgram.NamaJurusanPrograms}</option>`
                                                                );
                                                        });
                                                },
                                                error: function() {
                                                    jurusanDropdown.empty();
                                                    jurusanDropdown.append(
                                                        '<option value="" disabled>Error memuat data jurusan program</option>'
                                                    );
                                                }
                                            });
                                        }
                                    });
                                } else {
                                    fakultasDropdown.append(
                                        '<option value="" disabled>Tidak ada fakultas tersedia</option>'
                                    );
                                }
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText); // Debug jika ada error
                                fakultasDropdown.empty();
                                fakultasDropdown.append(
                                    '<option value="" disabled>Error memuat data fakultas</option>'
                                );
                            }
                        });
                    } else if (tipeInstitusi === 'Politeknik') {
                        jurusanDropdown.append('<option value="" disabled selected>Loading...</option>');

                        $.ajax({
                            url: "{{ route('getJurusanProgram') }}",
                            type: "GET",
                            data: {
                                UniversitasID: universitasID,
                                TipeInstitusi: tipeInstitusi
                            },
                            success: function(response) {
                                jurusanDropdown.empty();
                                jurusanDropdown.append(
                                    '<option value="" disabled selected>-- Pilih Jurusan Program --</option>'
                                );
                                response.forEach(function(jurusanProgram) {
                                    jurusanDropdown.append(
                                        `<option value="${jurusanProgram.id}">${jurusanProgram.NamaJurusanPrograms}</option>`
                                    );
                                });
                            }
                        });
                    }
                }
            });
        });
    </script>
@endpush
