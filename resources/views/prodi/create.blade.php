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
                            <label for="UniversitasID">Universitas</label>
                            <select class="form-control @error('UniversitasID') is-invalid @enderror" id="UniversitasID" name="UniversitasID">
                                <option value="">Pilih Universitas</option>
                                @foreach($universitas as $uni)
                                    <option value="{{ $uni->id }}">{{ $uni->NamaUniversitas }}</option>
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
                            <select class="form-control @error('FakultasID') is-invalid @enderror" id="FakultasID" name="FakultasID">
                                <option value="">Pilih Fakultas</option>
                            </select>
                            @error('FakultasID')
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
            // Ketika universitas berubah
            $('#UniversitasID').change(function() {
                const universitasID = $(this).val(); // Ambil ID Universitas
                const fakultasDropdown = $('#FakultasID'); // Dropdown Fakultas

                // Jika Universitas dipilih
                if (universitasID) {
                    fakultasDropdown.empty();
                    fakultasDropdown.append('<option value="" disabled selected>Loading...</option>');

                    // Kirim AJAX request
                    $.ajax({
                        url: "{{ route('getFakultas') }}",
                        type: "GET",
                        data: { UniversitasID: universitasID },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            fakultasDropdown.empty();
                            fakultasDropdown.append('<option value="" disabled selected>-- Pilih Fakultas --</option>');

                            if (response.length > 0) {
                                response.forEach(function(fakultas) {
                                    fakultasDropdown.append(
                                        `<option value="${fakultas.id}">${fakultas.NamaFakultas}</option>`
                                    );
                                });
                            } else {
                                fakultasDropdown.append('<option value="" disabled>Tidak ada fakultas tersedia</option>');
                            }
                        },
                        error: function() {
                            fakultasDropdown.empty();
                            fakultasDropdown.append('<option value="" disabled>Error memuat data</option>');
                        }
                    });
                } else {
                    fakultasDropdown.empty();
                    fakultasDropdown.append('<option value="" disabled selected>-- Pilih Fakultas --</option>');
                }
            });
        });
    </script>
@endpush
