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
                <div class="card-header">
                    <h4>Validasi Tambah Data Program Studi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('program-studi.store') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="UniversitasID">Universitas</label>
                            <select class="form-control @error('UniversitasID') is-invalid @enderror" id="UniversitasID"
                                name="UniversitasID">
                                <option value="">Pilih Universitas</option>
                                @foreach ($universitas as $uni)
                                    <option value="{{ $uni->id }}" data-tipe="{{ $uni->TipeInstitusi }}">
                                        {{ $uni->NamaUniversitas }}</option>
                                @endforeach
                            </select>
                            @error('UniversitasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group">
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

                        <div class="form-group">
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

                        <div class="form-group">
                            <label for="NamaProdi">Nama Program Studi</label>
                            <input type="text" class="form-control @error('NamaProdi') is-invalid @enderror"
                                id="NamaProdi" name="NamaProdi" placeholder="Enter Nama Program Studi">
                            @error('NamaProdi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeProdi">Kode Program Studi</label>
                            <input type="text" class="form-control @error('KodeProdi') is-invalid @enderror"
                                id="KodeProdi" name="KodeProdi" placeholder="Enter Kode Program Studi">
                            @error('KodeProdi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="strata">Strata Program Studi</label>
                            <input type="text" class="form-control @error('strata') is-invalid @enderror" id="strata"
                                name="strata" placeholder="Enter Kode Program Studi">
                            @error('strata')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusProdi">Status Program Studi</label>
                            <select class="form-control @error('StatusProdi') is-invalid @enderror" id="StatusProdi"
                                name="StatusProdi">
                                <option value="" disabled selected>Pilih Status Jurusan Program</option>
                                <option value="Active">Aktif</option>
                                <option value="InActive">Non Aktif</option>
                            </select>
                            @error('StatusProdi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('program-studi.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
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
                                                        '<option value="" disabled selected>-- Pilih Jurusan Program --</option>'
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
