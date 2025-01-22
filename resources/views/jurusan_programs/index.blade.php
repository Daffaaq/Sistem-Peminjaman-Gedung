@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Jurusan Program List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Jurusan Program Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Jurusan Program List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('jurusan-program.create') }}">Create New Jurusan Program</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Jurusan Program</a>
                                <a class="btn btn-info btn-primary active filter">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                    Filter Jurusan Program</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-filter mb-3" style="display: none">
                                <form id="filter" method="GET" action="{{ route('jurusan-program.index') }}"
                                    class="d-flex flex-wrap align-items-end">
                                    <div class="form-group col-md-4">
                                        <label for="UniversitasID">Universitas</label>
                                        <select name="UniversitasID" id="UniversitasID" class="form-control">
                                            <option value=""selected>-- Select Universitas --</option>
                                            @foreach ($universitas as $univ)
                                                <option value="{{ $univ->id }}"
                                                    {{ request('UniversitasID') == $univ->id ? 'selected' : '' }}>
                                                    {{ $univ->NamaUniversitas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Fakultas dropdown only shown if UniversitasID is selected and its type is "Universitas" -->
                                    <div class="form-group mr-3" id="fakultas-filter" style="display: none;">
                                        <label for="FakultasID">Fakultas</label>
                                        <select name="FakultasID" class="form-control">
                                            <option value="">Pilih Fakultas</option>
                                            @foreach ($fakultas as $fakultas)
                                                <option value="{{ $fakultas->id }}"
                                                    {{ request('FakultasID') == $fakultas->id ? 'selected' : '' }}>
                                                    {{ $fakultas->NamaFakultas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="ml-auto">
                                        <button class="btn btn-primary mr-2" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('jurusan-program.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>

                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('jurusan-program.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="NamaJurusanPrograms">Jurusan Program</label>
                                            <input type="text" name="NamaJurusanPrograms" class="form-control"
                                                id="NamaJurusanPrograms" placeholder="Nama Jurusan Program"
                                                value="{{ request()->input('NamaJurusanPrograms') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('jurusan-program.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Jurusan</th>
                                            <th>Kode Jurusan</th>
                                            <th>Fakultas</th>
                                            <th>Universitas</th>
                                            <th>Status</th>
                                            <th>Tipe</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jurusanPrograms as $key => $jurusan)
                                            <tr>
                                                <td>{{ ($jurusanPrograms->currentPage() - 1) * $jurusanPrograms->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $jurusan->NamaJurusanPrograms }}</td>
                                                <td>{{ $jurusan->KodeJurusanProgram }}</td>
                                                <td>{{ $jurusan->Fakultas ?? '-' }}</td>
                                                <td>{{ $jurusan->Universitas }}</td>
                                                <td>
                                                    @if ($jurusan->StatusJurusanPrograms === 'Active')
                                                        <span class="badge"
                                                            style="background-color: #20d800; color: #ffffff;">Aktif</span>
                                                    @elseif($jurusan->StatusJurusanPrograms === 'InActive')
                                                        <span class="badge"
                                                            style="background-color: #ff4d4f; color: #fff;">Non Aktif</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background-color: #d6d6d6; color: #6c757d;">Tidak
                                                            Diketahui</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($jurusan->TipeUniversitas === 'Universitas')
                                                        <span class="badge badge-info"
                                                            style="background-color: #17066e; color: #fff;">Universitas</span>
                                                    @elseif($jurusan->TipeUniversitas === 'Politeknik')
                                                        <span class="badge badge-warning"
                                                            style="background-color: #ff4d00; color: #fff;">Politeknik</span>
                                                    @else
                                                        <span class="badge badge-secondary"
                                                            style="background-color: #607d8b; color: #fff;">Tidak
                                                            Diketahui</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('jurusan-program.edit', $jurusan->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form action="{{ route('jurusan-program.destroy', $jurusan->id) }}"
                                                            method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $jurusanPrograms->withQueryString()->links() }}
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
            // Menangani klik pada search dan filter toggle
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

            // Fungsi untuk memeriksa tipe universitas dan menampilkan fakultas
            $('#UniversitasID').change(function() {
                var universitasID = $(this).val();

                // Cek tipe universitas yang dipilih
                $.get("/master-management/getUniversitasType/" + universitasID, function(data) {
                    if (data && data.TipeInstitusi === 'Universitas') {
                        // Jika tipe Universitas, tampilkan fakultas
                        $('#fakultas-filter').show();
                    } else {
                        // Jika tipe Politeknik, sembunyikan fakultas
                        $('#fakultas-filter').hide();
                    }
                });

            });

            // Jika Universitas sudah dipilih saat pertama kali halaman dibuka
            if ($('#UniversitasID').val()) {
                $('#UniversitasID').change();
            }

            // Hapus parameter kosong sebelum submit form
            $('form').on('submit', function(e) {
                $(this).find('select, input').each(function() {
                    if (!$(this).val()) {
                        $(this).prop('disabled', true); // Disable parameter kosong
                    }
                });
            });
        });
    </script>
@endpush

@push('customStyle')
@endpush
