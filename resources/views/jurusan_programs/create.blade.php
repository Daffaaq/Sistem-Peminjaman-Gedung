@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Jurusan Program</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Jurusan Program</a></div>
                <div class="breadcrumb-item">Tambah Jurusan Program</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Jurusan Program</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data Jurusan Program</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jurusan-program.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="NamaJurusanPrograms">Nama Jurusan Program</label>
                            <input type="text" class="form-control @error('NamaJurusanPrograms') is-invalid @enderror"
                                id="NamaJurusanPrograms" name="NamaJurusanPrograms"
                                placeholder="Enter Nama Jurusan Program">
                            @error('NamaJurusanPrograms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="KodeJurusanProgram">Kode Jurusan Program</label>
                            <input type="text" class="form-control @error('KodeJurusanProgram') is-invalid @enderror"
                                id="KodeJurusanProgram" name="KodeJurusanProgram" placeholder="Enter Kode Jurusan Program">
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
                                <option value="" disabled selected>Pilih Status Jurusan Program</option>
                                <option value="Active">Aktif</option>
                                <option value="InActive">Non Aktif</option>
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
                                    <option value="{{ $uni->id }}">{{ $uni->NamaUniversitas }}</option>
                                @endforeach
                            </select>
                            @error('UniversitasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Fakultas Filter, Initially Hidden -->
                        <div class="form-group" id="fakultas-filter" style="display: none;">
                            <label for="FakultasID">Fakultas</label>
                            <select name="FakultasID" id="FakultasID" class="form-control">
                                <option value="">Pilih Fakultas</option>
                            </select>
                            @error('FakultasID')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
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
            // Event ketika Universitas dipilih
            $('#UniversitasID').change(function() {
                var universitasID = $(this).val(); // Ambil ID Universitas yang dipilih
                var fakultasDropdown = $('#FakultasID'); // Dropdown Fakultas
                var fakultasFilter = $('#fakultas-filter'); // Wrapper Fakultas filter

                // Reset dropdown Fakultas
                fakultasDropdown.empty();
                fakultasDropdown.append('<option value="" selected>Loading...</option>');

                if (universitasID) {
                    // Cek tipe Universitas menggunakan AJAX
                    $.get("/master-management/getUniversitasType/" + universitasID, function(data) {
                        if (data && data.TipeInstitusi === 'Universitas') {
                            // Jika Universitas, tampilkan Fakultas
                            fakultasFilter.show();

                            // Fetch Fakultas menggunakan AJAX
                            $.ajax({
                                url: "{{ route('getFakultas') }}", // Route ke controller untuk mendapatkan data Fakultas
                                type: "GET",
                                data: {
                                    UniversitasID: universitasID
                                },
                                success: function(response) {
                                    fakultasDropdown
                                .empty(); // Kosongkan dropdown Fakultas
                                    if (response.length > 0) {
                                        // Jika Fakultas ditemukan, tambahkan opsi ke dropdown
                                        fakultasDropdown.append(
                                            '<option value="" selected>Pilih Fakultas</option>'
                                            );
                                        response.forEach(function(fakultas) {
                                            fakultasDropdown.append(
                                                `<option value="${fakultas.id}">${fakultas.NamaFakultas}</option>`
                                            );
                                        });
                                    } else {
                                        // Jika tidak ada Fakultas
                                        fakultasDropdown.append(
                                            '<option value="">Tidak ada Fakultas tersedia</option>'
                                            );
                                    }
                                },
                                error: function(xhr) {
                                    // Tangani error saat AJAX gagal
                                    console.error(xhr.responseText);
                                    fakultasDropdown.empty();
                                    fakultasDropdown.append(
                                        '<option value="">Error memuat data Fakultas</option>'
                                        );
                                }
                            });
                        } else {
                            // Jika Politeknik atau tipe lain, sembunyikan Fakultas
                            fakultasFilter.hide();
                        }
                    }).fail(function(xhr) {
                        // Tangani error jika request ke Universitas gagal
                        console.error(xhr.responseText);
                        fakultasDropdown.empty();
                        fakultasDropdown.append(
                            '<option value="">Error memuat data tipe Universitas</option>');
                        fakultasFilter.hide();
                    });
                } else {
                    // Jika Universitas tidak dipilih, sembunyikan Fakultas
                    fakultasFilter.hide();
                    fakultasDropdown.empty();
                    fakultasDropdown.append('<option value="">Pilih Universitas terlebih dahulu</option>');
                }
            });

            // Jika Universitas sudah dipilih saat halaman pertama kali dimuat
            if ($('#UniversitasID').val()) {
                $('#UniversitasID').change();
            }
        });
    </script>
@endpush
