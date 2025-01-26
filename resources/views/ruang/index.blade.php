@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Ruang List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ruang Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Ruang List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('ruang.create') }}">Create New
                                    Ruang</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i> Search Ruang</a>
                                <a class="btn btn-info btn-primary active filter">
                                    <i class="fa fa-filter" aria-hidden="true"></i> Filter Ruang</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-filter mb-3" style="display: none">
                                <form id="filter" method="GET" action="{{ route('ruang.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="UniversitasID">Universitas</label>
                                            <select name="UniversitasID" id="UniversitasID" class="form-control">
                                                <option value="" selected>-- Select Universitas --</option>
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
                                                <option value="" disabled selected>-- Select Fakultas --</option>
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
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('ruang.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('ruang.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="NamaRuang">Nama Ruang</label>
                                            <input type="text" name="NamaRuang" class="form-control" id="NamaRuang"
                                                placeholder="Nama Ruang" value="{{ request()->input('NamaRuang') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('ruang.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Ruang</th>
                                            <th>Kode Ruang</th>
                                            <th>Nama Gedung</th>
                                            <th>Nama Fakultas</th>
                                            <th>Nama Jurusan/Program</th>
                                            <th>Nama Universitas</th>
                                            <th>Status Ruang</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ruang as $key => $item)
                                            <tr>
                                                <td>{{ ($ruang->currentPage() - 1) * $ruang->perPage() + $key + 1 }}</td>
                                                <td>{{ $item->NamaRuang }}</td>
                                                <td>{{ $item->KodeRuang }}</td>
                                                <td>{{ $item->NamaGedung }}</td>
                                                <td style="text-align: center">{{ $item->NamaFakultas ?? '-' }}</td>
                                                <td style="text-align: center">{{ $item->NamaJurusanPrograms ?? '-' }}</td>
                                                <td>{{ $item->NamaUniversitas }}</td>
                                                <td>
                                                    @if ($item->StatusRuang === 'Active')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('ruang.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon"><i class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <a href="{{ route('ruang.show', $item->id) }}"
                                                            class="btn btn-sm btn-secondary btn-icon ml-2"><i
                                                                class="fas fa-eye"></i> Show</a>
                                                        <form action="{{ route('ruang.destroy', $item->id) }}"
                                                            method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $ruang->withQueryString()->links() }}
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
                $(".show-search").slideToggle("fast");
                $(".show-filter").hide();
            });
            $('.filter').click(function(event) {
                event.stopPropagation();
                $(".show-filter").slideToggle("fast");
                $(".show-search").hide();
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
