@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Organisasi Internal</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Organisasi Internal</a></div>
                <div class="breadcrumb-item">Tambah Organisasi Internal</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Organisasi Internal</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data Organisasi Internal</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('internal-organisasi.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="TipeOrganisasi">Tipe Organisasi</label>
                            <select class="form-control @error('TipeOrganisasi') is-invalid @enderror" id="TipeOrganisasi"
                                name="TipeOrganisasi">
                                <option value="">Pilih Tipe Organisasi</option>
                                <option value="Universitas">Universitas</option>
                                <option value="Fakultas">Fakultas</option>
                                <option value="JurusanProgram">Jurusan/Program</option>
                                <!-- Tambahkan tipe lainnya sesuai kebutuhan -->
                            </select>
                            @error('TipeOrganisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="Fakultas">
                            <label for="FakultasID">Fakultas</label>
                            <select class="form-control @error('FakultasID') is-invalid @enderror" id="FakultasID"
                                name="FakultasID">
                                <option value="">Pilih Fakultas</option>
                            </select>
                            @error('FakultasID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="JurusanProgram">
                            <label for="JurusanProgramID">Jurusan Program</label>
                            <select class="form-control @error('JurusanProgramID') is-invalid @enderror"
                                id="JurusanProgramID" name="JurusanProgramID">
                                <option value="">Pilih Jurusan Program</option>
                            </select>
                            @error('JurusanProgramID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="NamaInternalOrganisasi">Nama Organisasi Internal</label>
                            <input type="text" class="form-control @error('NamaInternalOrganisasi') is-invalid @enderror"
                                id="NamaInternalOrganisasi" name="NamaInternalOrganisasi"
                                placeholder="Enter Nama Organisasi Internal">
                            @error('NamaInternalOrganisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeInternalOrganisasi">Kode Organisasi Internal</label>
                            <input type="text" class="form-control @error('KodeInternalOrganisasi') is-invalid @enderror"
                                id="KodeInternalOrganisasi" name="KodeInternalOrganisasi"
                                placeholder="Enter Kode Organisasi Internal">
                            @error('KodeInternalOrganisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusInternalOrganisasi">Status Organisasi Internal</label>
                            <select class="form-control @error('StatusInternalOrganisasi') is-invalid @enderror"
                                id="StatusInternalOrganisasi" name="StatusInternalOrganisasi">
                                <option value="" disabled selected>Pilih Status Organisasi</option>
                                <option value="Active">Aktif</option>
                                <option value="InActive">Non Aktif</option>
                            </select>
                            @error('StatusInternalOrganisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Keterangan">Keterangan</label>
                            <textarea class="form-control @error('Keterangan') is-invalid @enderror" id="Keterangan" name="Keterangan"
                                placeholder="Keterangan Organisasi"></textarea>
                            @error('Keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('internal-organisasi.index') }}" class="btn btn-secondary">Kembali</a>
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
            $('#TipeOrganisasi').change(function() {
                const tipe = $(this).val();
                const fakultas = $('#Fakultas');
                const jurusan = $('#JurusanProgram');

                if (tipe === 'Universitas') {
                    fakultas.hide();
                    jurusan.hide();
                } else if (tipe === 'Fakultas') {
                    fakultas.show();
                    jurusan.hide();
                } else if (tipe === 'JurusanProgram') {
                    jurusan.show();
                    fakultas.show();
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
