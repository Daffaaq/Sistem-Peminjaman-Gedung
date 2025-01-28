@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Organisasi Internal</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Organisasi Internal</a></div>
                <div class="breadcrumb-item">Edit Organisasi Internal</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Organisasi Internal</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Data Organisasi Internal</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('internal-organisasi.update', $minOrganisasi->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="TipeOrganisasi">Tipe Organisasi</label>
                            <select class="form-control @error('TipeOrganisasi') is-invalid @enderror" id="TipeOrganisasi"
                                name="TipeOrganisasi">
                                <option value="">Pilih Tipe Organisasi</option>
                                <option value="Universitas"
                                    {{ $minOrganisasi->TipeOrganisasi == 'Universitas' ? 'selected' : '' }}>Universitas
                                </option>
                                <option value="Fakultas"
                                    {{ $minOrganisasi->TipeOrganisasi == 'Fakultas' ? 'selected' : '' }}>Fakultas</option>
                                <option value="JurusanProgram"
                                    {{ $minOrganisasi->TipeOrganisasi == 'JurusanProgram' ? 'selected' : '' }}>
                                    Jurusan/Program</option>
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
                                    <option value="{{ $uni->id }}"
                                        {{ $minOrganisasi->UniversitasID == $uni->id ? 'selected' : '' }}
                                        data-tipe="{{ $uni->TipeInstitusi }}">
                                        {{ $uni->NamaUniversitas }}
                                    </option>
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
                                @foreach ($fakultas as $fak)
                                    <option value="{{ $fak->id }}"
                                        {{ $minOrganisasi->FakultasID == $fak->id ? 'selected' : '' }}>
                                        {{ $fak->NamaFakultas }}
                                    </option>
                                @endforeach
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
                                @foreach ($jurusanProgram as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ $minOrganisasi->JurusanProgramID == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->NamaJurusanPrograms }}
                                    </option>
                                @endforeach
                            </select>
                            @error('JurusanProgramID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="NamaInternalOrganisasi">Nama Organisasi Internal</label>
                            <input type="text" class="form-control @error('NamaInternalOrganisasi') is-invalid @enderror"
                                id="NamaInternalOrganisasi" name="NamaInternalOrganisasi"
                                value="{{ old('NamaInternalOrganisasi', $minOrganisasi->NamaInternalOrganisasi) }}"
                                placeholder="Enter Nama Organisasi Internal">
                            @error('NamaInternalOrganisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeInternalOrganisasi">Kode Organisasi Internal</label>
                            <input type="text" class="form-control @error('KodeInternalOrganisasi') is-invalid @enderror"
                                id="KodeInternalOrganisasi" name="KodeInternalOrganisasi"
                                value="{{ old('KodeInternalOrganisasi', $minOrganisasi->KodeInternalOrganisasi) }}"
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
                                <option value="Active"
                                    {{ $minOrganisasi->StatusInternalOrganisasi == 'Active' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="InActive"
                                    {{ $minOrganisasi->StatusInternalOrganisasi == 'InActive' ? 'selected' : '' }}>Non
                                    Aktif</option>
                            </select>
                            @error('StatusInternalOrganisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Keterangan">Keterangan</label>
                            <textarea class="form-control @error('Keterangan') is-invalid @enderror" id="Keterangan" name="Keterangan"
                                placeholder="Keterangan Organisasi">{{ old('Keterangan', $minOrganisasi->Keterangan) }}</textarea>
                            @error('Keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
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
                const tipeInstitusi = $('#UniversitasID option:selected').data('tipe');
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
                                fakultasDropdown.empty();
                                if (response.length > 0) {
                                    fakultasDropdown.append(
                                        '<option value="" disabled selected>-- Pilih Fakultas --</option>'
                                        );
                                    response.forEach(function(fakultas) {
                                        fakultasDropdown.append(
                                            `<option value="${fakultas.id}">${fakultas.NamaFakultas}</option>`
                                        );
                                    });

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
                                                    FakultasID: fakultasID
                                                },
                                                success: function(response) {
                                                    jurusanDropdown.empty();
                                                    if (response.length >
                                                        0) {
                                                        jurusanDropdown
                                                            .append(
                                                                '<option value="" disabled selected>-- Pilih Jurusan Program --</option>'
                                                                );
                                                        response.forEach(
                                                            function(
                                                                jurusan
                                                                ) {
                                                                jurusanDropdown
                                                                    .append(
                                                                        `<option value="${jurusan.id}">${jurusan.NamaJurusanProgram}</option>`
                                                                    );
                                                            });
                                                    }
                                                }
                                            });
                                        }
                                    });
                                }
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
