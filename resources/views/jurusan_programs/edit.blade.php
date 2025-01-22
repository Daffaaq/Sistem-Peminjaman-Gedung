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
                                @foreach ($fakultas as $fakultas)
                                    <option value="{{ $fakultas->id }}"
                                        {{ old('FakultasID', $jurusanProgram->FakultasID) == $fakultas->id ? 'selected' : '' }}>
                                        {{ $fakultas->NamaFakultas }}
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
        $('#UniversitasID').change(function() {
            var universitasID = $(this).val();

            // Cek tipe universitas yang dipilih
            $.get("/master-management/getUniversitasType/" + universitasID, function(data) {
                if (data && data.TipeInstitusi === 'Universitas') {
                    // Jika tipe Universitas, tampilkan fakultas
                    $('#fakultas-filter').show();
                    $('#FakultasID').prop('required', true);
                } else {
                    // Jika tipe Politeknik, sembunyikan fakultas
                    $('#fakultas-filter').hide();
                    $('#FakultasID').prop('required', false); // Fakultas boleh kosong
                    $('#FakultasID').val(''); // Reset fakultas
                }
            });
        });

        // Trigger change event saat halaman pertama kali dimuat untuk mengecek apakah Fakultas perlu ditampilkan
        $('#UniversitasID').change();
    </script>
@endpush
