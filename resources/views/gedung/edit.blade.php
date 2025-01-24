@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Gedung</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Gedung</a></div>
                <div class="breadcrumb-item">Edit Gedung</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Gedung</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Data Gedung</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gedung.update', $gedung->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="TipeGedung">Tipe Gedung</label>
                            <select class="form-control @error('TipeGedung') is-invalid @enderror" id="TipeGedung"
                                name="TipeGedung">
                                <option value="" disabled>Pilih Tipe Gedung</option>
                                <option value="Mandiri" {{ $gedung->TipeGedung === 'Mandiri' ? 'selected' : '' }}>Mandiri
                                </option>
                                <option value="Fakultas" {{ $gedung->TipeGedung === 'Fakultas' ? 'selected' : '' }}>
                                    Fakultas/Jurusan</option>
                            </select>
                            @error('TipeGedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="UniversitasID">Universitas</label>
                            <select class="form-control @error('UniversitasID') is-invalid @enderror" id="UniversitasID"
                                name="UniversitasID">
                                <option value="">Pilih Universitas</option>
                                @foreach ($universitas as $uni)
                                    <option value="{{ $uni->id }}" data-tipe="{{ $uni->TipeInstitusi }}"
                                        {{ $gedung->UniversitasID == $uni->id ? 'selected' : '' }}>
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
                                @foreach ($fakultas as $fak)
                                    <option value="{{ $fak->id }}"
                                        {{ $gedung->FakultasID == $fak->id ? 'selected' : '' }}>
                                        {{ $fak->NamaFakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('FakultasID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jurusan Program Dropdown -->
                        <div class="form-group" id="JurusanProgram">
                            <label for="JurusanProgramID">Jurusan Program</label>
                            <select class="form-control @error('JurusanProgramID') is-invalid @enderror"
                                id="JurusanProgramID" name="JurusanProgramID">
                                <option value="">Pilih Jurusan Program</option>
                                @foreach ($jurusanProgram as $jp)
                                    <option value="{{ $jp->id }}"
                                        {{ $gedung->JurusanProgramID == $jp->id ? 'selected' : '' }}>
                                        {{ $jp->NamaJurusanPrograms }}
                                    </option>
                                @endforeach
                            </select>
                            @error('JurusanProgramID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="NamaGedung">Nama Gedung</label>
                            <input type="text" class="form-control @error('NamaGedung') is-invalid @enderror"
                                id="NamaGedung" name="NamaGedung" value="{{ old('NamaGedung', $gedung->NamaGedung) }}">
                            @error('NamaGedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeGedung">Kode Gedung</label>
                            <input type="text" class="form-control @error('KodeGedung') is-invalid @enderror"
                                id="KodeGedung" name="KodeGedung" value="{{ old('KodeGedung', $gedung->KodeGedung) }}">
                            @error('KodeGedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusGedung">Status Gedung</label>
                            <select class="form-control @error('StatusGedung') is-invalid @enderror" id="StatusGedung"
                                name="StatusGedung">
                                <option value="" disabled>Pilih Status Gedung</option>
                                <option value="Active" {{ $gedung->StatusGedung === 'Active' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="InActive" {{ $gedung->StatusGedung === 'InActive' ? 'selected' : '' }}>Non
                                    Aktif</option>
                            </select>
                            @error('StatusGedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="JumlahLantaiGedung">
                            <label for="JumlahLantaiGedung">Jumlah Lantai Gedung</label>
                            <input type="number" class="form-control @error('JumlahLantaiGedung') is-invalid @enderror"
                                id="JumlahLantaiGedung" name="JumlahLantaiGedung"
                                value="{{ old('JumlahLantaiGedung', $gedung->JumlahLantaiGedung) }}">
                            @error('JumlahLantaiGedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="kapasitasGedung">
                            <label for="kapasitasGedung">Kapasitas Gedung</label>
                            <input type="number" class="form-control @error('kapasitasGedung') is-invalid @enderror"
                                id="kapasitasGedung" name="kapasitasGedung"
                                value="{{ old('kapasitasGedung', $gedung->kapasitasGedung) }}">
                            @error('kapasitasGedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Keterangan">Keterangan Gedung</label>
                            <div>
                                <textarea id="Keterangan" class="form-control @error('Keterangan') is-invalid @enderror" name="Keterangan"
                                    rows="4" cols="130">{{ old('Keterangan', $gedung->Keterangan) }}</textarea>
                            </div>
                            @error('Keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-secondary" href="{{ route('gedung.index') }}">Cancel</a>
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
            function updateVisibility() {
                const tipeGedung = $('#TipeGedung').val();
                const tipeInstitusi = $('#UniversitasID option:selected').data('tipe');
                const fakultas = $('#Fakultas');
                const jurusan = $('#JurusanProgram');
                const fakultasDropdown = $('#FakultasID');
                const jumlahlantaigedung = $('#JumlahLantaiGedung');
                const kapasitasGedung = $('#kapasitasGedung');

                console.log("Tipe Gedung:", tipeGedung);
                console.log("Tipe Institusi:", tipeInstitusi);

                if (tipeGedung === 'Mandiri') {
                    fakultas.hide();
                    jurusan.hide();
                    jumlahlantaigedung.hide();
                    kapasitasGedung.show();
                } else if (tipeGedung === 'Fakultas') {
                    jumlahlantaigedung.show(); // Tampilkan JumlahLantaiGedung
                    kapasitasGedung.hide(); // Sembunyikan KapasitasGedung
                    if (tipeInstitusi === 'Universitas') {
                        fakultas.show();
                        jurusan.hide(); // Sembunyikan jurusan sampai FakultasID dipilih
                        loadFakultas($('#UniversitasID').val());
                    } else {
                        fakultas.hide();
                        jurusan.show();
                        loadJurusanProgram($('#UniversitasID').val(), null, tipeInstitusi);
                    }
                } else {
                    fakultas.hide();
                    jurusan.hide();
                }
            }

            function loadFakultas(universitasID) {
                const fakultasDropdown = $('#FakultasID');
                const jurusanDropdown = $('#JurusanProgramID'); // Clear jurusan initially
                jurusanDropdown.empty().append(
                    '<option value="" disabled selected>-- Pilih Jurusan Program --</option>');

                fakultasDropdown.append('<option value="" disabled selected>Loading...</option>');

                $.ajax({
                    url: "{{ route('getFakultas') }}",
                    type: "GET",
                    data: {
                        UniversitasID: universitasID
                    },
                    success: function(response) {
                        fakultasDropdown.empty().append(
                            '<option value="" disabled selected>-- Pilih Fakultas --</option>'
                        );
                        if (response.length > 0) {
                            response.forEach(function(fakultas) {
                                fakultasDropdown.append(
                                    `<option value="${fakultas.id}">${fakultas.NamaFakultas}</option>`
                                );
                            });

                            // If FakultasID is already set, select the correct fakultas
                            if ("{{ $gedung->FakultasID }}") {
                                fakultasDropdown.val("{{ $gedung->FakultasID }}").trigger('change');
                            }

                            // Event FakultasID
                            fakultasDropdown.change(function() {
                                const jurusan = $('#JurusanProgram');
                                const fakultasID = $(this).val();
                                const tipeInstitusi = $('#UniversitasID option:selected').data(
                                    'tipe');
                                if (fakultasID) {
                                    jurusan
                                        .show(); // Tampilkan dropdown jurusan setelah fakultas dipilih
                                    loadJurusanProgram($('#UniversitasID').val(), fakultasID,
                                        tipeInstitusi);
                                }
                            });
                        } else {
                            fakultasDropdown.append(
                                '<option value="" disabled>Tidak ada Fakultas tersedia</option>'
                            );
                        }
                    },
                    error: function() {
                        fakultasDropdown.empty().append(
                            '<option value="" disabled>Error memuat data Fakultas</option>'
                        );
                    },
                });
            }

            function loadJurusanProgram(universitasID, fakultasID, tipeInstitusi) {
                const jurusanDropdown = $('#JurusanProgramID');
                jurusanDropdown.empty().append('<option value="" disabled selected>Loading...</option>');

                if (tipeInstitusi === 'Universitas' && !fakultasID) {
                    jurusanDropdown.empty().append(
                        '<option value="" disabled>Pilih Fakultas terlebih dahulu</option>'
                    );
                    return;
                }

                $.ajax({
                    url: "{{ route('getJurusanProgram') }}",
                    type: "GET",
                    data: {
                        UniversitasID: universitasID,
                        FakultasID: fakultasID,
                        TipeInstitusi: tipeInstitusi,
                    },
                    success: function(response) {
                        jurusanDropdown.empty().append(
                            '<option value="" disabled selected>-- Pilih Jurusan Program --</option>'
                        );
                        if (response.length > 0) {
                            response.forEach(function(jurusanProgram) {
                                jurusanDropdown.append(
                                    `<option value="${jurusanProgram.id}">${jurusanProgram.NamaJurusanPrograms}</option>`
                                );
                            });

                            // If JurusanProgramID is already set, select the correct jurusan program
                            if ("{{ $gedung->JurusanProgramID }}") {
                                jurusanDropdown.val("{{ $gedung->JurusanProgramID }}");
                            }
                        } else {
                            jurusanDropdown.append(
                                '<option value="" disabled>Tidak ada Jurusan Program tersedia</option>'
                            );
                        }
                    },
                    error: function() {
                        jurusanDropdown.empty().append(
                            '<option value="" disabled>Error memuat data Jurusan Program</option>'
                        );
                    },
                });
            }

            // Event untuk tipe gedung
            $('#TipeGedung').change(updateVisibility);

            // Event untuk universitas
            $('#UniversitasID').change(function() {
                const universitasID = $(this).val();
                const tipeInstitusi = $('#UniversitasID option:selected').data('tipe');
                updateVisibility();

                if (universitasID) {
                    if (tipeInstitusi === 'Universitas') {
                        loadFakultas(universitasID);
                    } else {
                        $('#FakultasID').empty().append(
                            '<option value="" disabled selected>Fakultas tidak tersedia</option>'
                        );
                        loadJurusanProgram(universitasID, null, tipeInstitusi);
                    }
                }
            });

            // Inisialisasi awal
            updateVisibility();

            // Load Fakultas and Jurusan Program based on initial data if available
            if ("{{ $gedung->UniversitasID }}") {
                loadFakultas("{{ $gedung->UniversitasID }}");
            }
        });
    </script>
@endpush
