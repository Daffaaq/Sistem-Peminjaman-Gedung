@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Prodi List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Prodi Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Prodi List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('program-studi.create') }}">Create
                                    New Fakultas</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Prodi</a>
                                <a class="btn btn-info btn-primary active filter">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                    Filter Prodi</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-filter mb-3" style="display: none">
                                <form id="filter" method="GET" action="{{ route('program-studi.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="UniversitasID">Universitas</label>
                                            <select name="UniversitasID" id="UniversitasID" class="form-control">
                                                <option value="" disabled selected>-- Select Universitas --</option>
                                                @foreach ($universitas as $univ)
                                                    <option value="{{ $univ->id }}">{{ $univ->NamaUniversitas }}
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
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('program-studi.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('program-studi.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="NamaProdi">Nama Prodi</label>
                                            <input type="text" name="NamaProdi" class="form-control" id="NamaProdi"
                                                placeholder="Nama Prodi" value="{{ request()->input('NamaProdi') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('program-studi.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Prodi</th>
                                            <th>Kode Prodi</th>
                                            <th>Nama Fakultas</th>
                                            <th>Nama Universitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($prodi as $key => $item)
                                            <tr>
                                                <td>{{ ($prodi->currentPage() - 1) * $prodi->perPage() + $key + 1 }}</td>
                                                <td>{{ $item->NamaProdi }}</td>
                                                <td>{{ $item->KodeProdi }}</td>
                                                <td>{{ $item->NamaFakultas }}</td>
                                                <td>{{ $item->NamaUniversitas }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $prodi->withQueryString()->links() }}
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
            $('#UniversitasID').change(function() {
                const universitasID = $(this).val(); // Ambil ID universitas yang dipilih
                const fakultasDropdown = $('#FakultasID');

                if (universitasID) {
                    // Bersihkan dropdown fakultas
                    fakultasDropdown.empty();
                    fakultasDropdown.append('<option value="" disabled selected>Loading...</option>');

                    // AJAX Request
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
                                    '<option value="" disabled>No Fakultas Found</option>');
                            }
                        },
                        error: function() {
                            fakultasDropdown.empty();
                            fakultasDropdown.append(
                                '<option value="" disabled selected>Error loading data</option>'
                            );
                        },
                    });
                } else {
                    fakultasDropdown.empty();
                    fakultasDropdown.append(
                        '<option value="" disabled selected>-- Select Fakultas --</option>');
                }
            });
        });
    </script>
@endpush
