@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Organisasi Internal</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Organization</a></div>
                <div class="breadcrumb-item">Internal</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Manajemen Organisasi Internal</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Organisasi Internal</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('internal-organisasi.create') }}">
                                    Tambah Organisasi Internal</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i> Cari Organisasi Internal</a>
                                <a class="btn btn-info btn-primary active filter">
                                    <i class="fa fa-filter" aria-hidden="true"></i> Filter Organisasi Internal</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="show-filter mb-3" style="display: none">
                                <form id="filter" method="GET" action="{{ route('internal-organisasi.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="UniversitasID">Universitas</label>
                                            <select name="UniversitasID" id="UniversitasID" class="form-control">
                                                <option value="" selected>-- Pilih Universitas --</option>
                                                @foreach ($universitas as $univ)
                                                    <option value="{{ $univ->id }}"
                                                        data-tipe="{{ $univ->TipeInstitusi }}">{{ $univ->NamaUniversitas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="FakultasID">Fakultas</label>
                                            <select name="FakultasID" id="FakultasID" class="form-control">
                                                <option value="" disabled selected>-- Pilih Fakultas --</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="JurusanProgramID">Jurusan/Program</label>
                                            <select name="JurusanProgramID" id="JurusanProgramID" class="form-control">
                                                <option value="" disabled selected>-- Select Jurusan/Program --
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Terapkan</button>
                                        <a class="btn btn-secondary"
                                            href="{{ route('internal-organisasi.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('internal-organisasi.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="NamaInternalOrganisasi">Nama Organisasi</label>
                                            <input type="text" name="NamaInternalOrganisasi" class="form-control"
                                                id="NamaInternalOrganisasi" placeholder="Nama Organisasi"
                                                value="{{ request()->input('NamaInternalOrganisasi') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Cari</button>
                                        <a class="btn btn-secondary"
                                            href="{{ route('internal-organisasi.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Organisasi</th>
                                            <th>Kode Organisasi</th>
                                            <th>Fakultas</th>
                                            <th>Jurusan/Program</th>
                                            <th>Universitas</th>
                                            <th>Tipe Organisasi</th>
                                            <th>Status</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($organisasiInternal as $key => $item)
                                            <tr>
                                                <td>{{ ($organisasiInternal->currentPage() - 1) * $organisasiInternal->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $item->NamaInternalOrganisasi }}</td>
                                                <td>{{ $item->KodeInternalOrganisasi }}</td>
                                                <td>{{ $item->NamaFakultas ?? '-' }}</td>
                                                <td>{{ $item->NamaJurusanPrograms }}</td>
                                                <td>{{ $item->NamaUniversitas }}</td>
                                                <td>{{ $item->TipeOrganisasi }}</td>
                                                <td>
                                                    @if ($item->StatusInternalOrganisasi === 'Active')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('internal-organisasi.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon"><i class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form
                                                            action="{{ route('internal-organisasi.destroy', $item->id) }}"
                                                            method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete"><i
                                                                    class="fas fa-trash"></i> Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $organisasiInternal->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            $('.search').click(function(event) {
                event.stopPropagation();
                $('.show-search').slideToggle('fast');
                $('.show-filter').hide();
            });
            $('.filter').click(function(event) {
                event.stopPropagation();
                $('.show-filter').slideToggle('fast');
                $('.show-search').hide();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ketika Universitas dipilih
            $('#UniversitasID').change(function() {
                const universitasID = $(this).val(); // Ambil ID universitas yang dipilih
                const fakultasDropdown = $('#FakultasID');
                const jurusanProgramDropdown = $('#JurusanProgramID');
                const tipeInstitusi = $('#UniversitasID option:selected').data(
                    'tipe'); // Ambil tipe institusi

                // Bersihkan dropdown Fakultas dan Jurusan/Program
                fakultasDropdown.empty();
                jurusanProgramDropdown.empty();

                if (universitasID) {
                    if (tipeInstitusi === 'Universitas') {
                        // Tampilkan dropdown Fakultas untuk Universitas
                        fakultasDropdown.append('<option value="" selected>Loading...</option>');

                        // AJAX Request untuk Fakultas
                        $.ajax({
                            url: "{{ route('getFakultas') }}", // URL endpoint
                            type: "GET",
                            data: {
                                UniversitasID: universitasID
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                fakultasDropdown.empty();
                                fakultasDropdown.append(
                                    '<option value="" disabled selected>-- Select Fakultas --</option>'
                                );
                                if (response.length > 0) {
                                    response.forEach(function(fakultas) {
                                        fakultasDropdown.append(
                                            `<option value="${fakultas.id}">${fakultas.NamaFakultas}</option>`
                                        );
                                    });
                                } else {
                                    fakultasDropdown.append(
                                        '<option value="" disabled>No Fakultas Found</option>'
                                    );
                                }
                            },
                            error: function() {
                                fakultasDropdown.empty();
                                fakultasDropdown.append(
                                    '<option value="" disabled selected>Error loading data</option>'
                                );
                            },
                        });
                    }

                    // Tampilkan dropdown Jurusan/Program tanpa Fakultas untuk Politeknik
                    jurusanProgramDropdown.empty();
                    jurusanProgramDropdown.append('<option value="" disabled selected>Loading...</option>');

                    $.ajax({
                        url: "{{ route('getJurusanProgram') }}", // URL endpoint
                        type: "GET",
                        data: {
                            UniversitasID: universitasID,
                            TipeInstitusi: tipeInstitusi
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            jurusanProgramDropdown.empty();
                            jurusanProgramDropdown.append(
                                '<option value="" disabled selected>-- Select Jurusan/Program --</option>'
                            );
                            if (response.length > 0) {
                                response.forEach(function(jurusanProgram) {
                                    jurusanProgramDropdown.append(
                                        `<option value="${jurusanProgram.id}">${jurusanProgram.NamaJurusanPrograms}</option>`
                                    );
                                });
                            } else {
                                jurusanProgramDropdown.append(
                                    '<option value="" disabled>No Jurusan/Program Found</option>'
                                );
                            }
                        },
                        error: function() {
                            jurusanProgramDropdown.empty();
                            jurusanProgramDropdown.append(
                                '<option value="" disabled selected>Error loading data</option>'
                            );
                        },
                    });
                } else {
                    fakultasDropdown.empty();
                    fakultasDropdown.append(
                        '<option value="" disabled selected>-- Select Fakultas --</option>');
                    jurusanProgramDropdown.empty();
                    jurusanProgramDropdown.append(
                        '<option value="" disabled selected>-- Select Jurusan/Program --</option>');
                }
            });

            // Ketika Fakultas dipilih
            $('#FakultasID').change(function() {
                const universitasID = $('#UniversitasID').val();
                const fakultasID = $(this).val();
                const jurusanProgramDropdown = $('#JurusanProgramID');
                const tipeInstitusi = $('#UniversitasID option:selected').data(
                    'tipe'); // Ambil tipe institusi

                // Bersihkan dropdown Jurusan/Program
                jurusanProgramDropdown.empty();
                jurusanProgramDropdown.append('<option value="" disabled selected>Loading...</option>');

                if (universitasID && fakultasID) {
                    let data = {
                        UniversitasID: universitasID,
                        FakultasID: fakultasID,
                        TipeInstitusi: tipeInstitusi
                    };

                    $.ajax({
                        url: "{{ route('getJurusanProgram') }}", // URL endpoint
                        type: "GET",
                        data: data, // Kirim data yang sesuai
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            jurusanProgramDropdown.empty();
                            jurusanProgramDropdown.append(
                                '<option value="" disabled selected>-- Select Jurusan/Program --</option>'
                            );
                            if (response.length > 0) {
                                response.forEach(function(jurusanProgram) {
                                    jurusanProgramDropdown.append(
                                        `<option value="${jurusanProgram.id}">${jurusanProgram.NamaJurusanPrograms}</option>`
                                    );
                                });
                            } else {
                                jurusanProgramDropdown.append(
                                    '<option value="" disabled>No Jurusan/Program Found</option>'
                                );
                            }
                        },
                        error: function() {
                            jurusanProgramDropdown.empty();
                            jurusanProgramDropdown.append(
                                '<option value="" disabled selected>Error loading data</option>'
                            );
                        },
                    });
                } else {
                    jurusanProgramDropdown.empty();
                    jurusanProgramDropdown.append(
                        '<option value="" disabled selected>-- Select Jurusan/Program --</option>');
                }
            });
        });
    </script>
@endpush
