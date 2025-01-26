@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Jurusan Program</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Jurusan Program</a></div>
                <div class="breadcrumb-item">Edit Jurusan Program</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Jurusan Program</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Data Jurusan Program</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jurusan-program.update', $jurusanProgram->id) }}" method="post">
                        @csrf
                        @method('PUT') <!-- Menandakan ini adalah request UPDATE -->

                        <div class="form-group">
                            <label for="NamaJurusanPrograms">Nama Jurusan Program</label>
                            <input type="text" class="form-control @error('NamaJurusanPrograms') is-invalid @enderror"
                                id="NamaJurusanPrograms" name="NamaJurusanPrograms"
                                value="{{ old('NamaJurusanPrograms', $jurusanProgram->NamaJurusanPrograms) }}">
                            @error('NamaJurusanPrograms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeJurusanProgram">Kode Jurusan Program</label>
                            <input type="text" class="form-control @error('KodeJurusanProgram') is-invalid @enderror"
                                id="KodeJurusanProgram" name="KodeJurusanProgram"
                                value="{{ old('KodeJurusanProgram', $jurusanProgram->KodeJurusanProgram) }}">
                            @error('KodeJurusanProgram')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="StatusJurusanPrograms">Status Jurusan Program</label>
                            <select class="form-control @error('StatusJurusanPrograms') is-invalid @enderror"
                                id="StatusJurusanPrograms" name="StatusJurusanPrograms">
                                <option value="" disabled>Pilih Status Jurusan Program</option>
                                <option value="Active"
                                    {{ $jurusanProgram->StatusJurusanPrograms == 'Active' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="InActive"
                                    {{ $jurusanProgram->StatusJurusanPrograms == 'InActive' ? 'selected' : '' }}>Non Aktif
                                </option>
                            </select>
                            @error('StatusJurusanPrograms')
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
                                    <option value="{{ $uni->id }}"
                                        {{ $uni->id == $jurusanProgram->UniversitasID ? 'selected' : '' }}>
                                        {{ $uni->NamaUniversitas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('UniversitasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Fakultas Filter, Initially Hidden -->
                        <div class="form-group" id="fakultas-filter"
                            style="{{ $jurusanProgram->UniversitasID &&DB::table('muniversitas')->where('id', $jurusanProgram->UniversitasID)->value('TipeInstitusi') == 'Universitas'? '': 'display: none;' }}">
                            <label for="FakultasID">Fakultas</label>
                            <select class="form-control @error('FakultasID') is-invalid @enderror" id="FakultasID"
                                name="FakultasID">
                                <option value="">Pilih Fakultas</option>
                                @foreach ($fakultas as $fak)
                                    <option value="{{ $fak->id }}"
                                        {{ $fak->id == $jurusanProgram->FakultasID ? 'selected' : '' }}>
                                        {{ $fak->NamaFakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('FakultasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                            <a class="btn btn-secondary" href="{{ route('jurusan-program.index') }}">Cancel</a>
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
            function loadFakultas(universitasID, selectedFakultasID = null) {
                var fakultasDropdown = $('#FakultasID');
                var fakultasFilter = $('#fakultas-filter');

                fakultasDropdown.empty();
                fakultasDropdown.append('<option value="" selected>Loading...</option>');

                if (universitasID) {
                    $.get(`/master-management/getUniversitasType/${universitasID}`, function(data) {
                        if (data && data.TipeInstitusi === 'Universitas') {
                            fakultasFilter.show();

                            // Fetch fakultas
                            $.ajax({
                                url: "{{ route('getFakultas') }}",
                                type: "GET",
                                data: {
                                    UniversitasID: universitasID
                                },
                                success: function(response) {
                                    fakultasDropdown.empty();
                                    fakultasDropdown.append(
                                        '<option value="">Pilih Fakultas</option>');
                                    response.forEach(function(fakultas) {
                                        fakultasDropdown.append(
                                            `<option value="${fakultas.id}" ${
                                        fakultas.id == selectedFakultasID ? 'selected' : ''
                                    }>${fakultas.NamaFakultas}</option>`
                                        );
                                    });
                                },
                                error: function(xhr) {
                                    console.error("Error memuat Fakultas:", xhr.responseText);
                                    fakultasDropdown.empty();
                                    fakultasDropdown.append(
                                        '<option value="">Error memuat data Fakultas</option>'
                                        );
                                },
                            });
                        } else {
                            fakultasFilter.hide();
                            fakultasDropdown.empty();
                            fakultasDropdown.append('<option value="">Fakultas tidak diperlukan</option>');
                        }
                    }).fail(function(xhr) {
                        console.error("Error memuat tipe Universitas:", xhr.responseText);
                        fakultasFilter.hide();
                        fakultasDropdown.empty();
                        fakultasDropdown.append('<option value="">Error memuat tipe Universitas</option>');
                    });
                } else {
                    fakultasFilter.hide();
                    fakultasDropdown.empty();
                    fakultasDropdown.append('<option value="">Pilih Universitas terlebih dahulu</option>');
                }
            }

            // Event listener untuk dropdown Universitas
            $('#UniversitasID').change(function() {
                loadFakultas($(this).val());
            });

            // Saat halaman pertama kali dimuat
            var initialUniversitasID = $('#UniversitasID').val();
            var initialFakultasID = "{{ $jurusanProgram->FakultasID }}"; // ID Fakultas lama
            if (initialUniversitasID) {
                loadFakultas(initialUniversitasID, initialFakultasID);
            }
        });
    </script>
@endpush
