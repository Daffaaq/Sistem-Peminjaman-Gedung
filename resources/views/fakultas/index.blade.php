@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Fakultas List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Fakultas Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Fakultas List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('fakultas.create') }}">Create
                                    New Fakultas</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Fakultas</a>
                                <a class="btn btn-info btn-primary active filter">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                    Search Fakultas</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-filter mb-3" style="display: none">
                                <form id="filter" method="GET" action="{{ route('fakultas.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="UniversitasID">Universitas</label>
                                            <select name="UniversitasID" id="UniversitasID" class="form-control">
                                                <option value="" disabled>-- Select Universitas --</option>
                                                @foreach ($universitas as $univ)
                                                    <option value="{{ $univ->id }}"
                                                        {{ request()->input('UniversitasID') == $univ->id ? 'selected' : '' }}>
                                                        {{ $univ->NamaUniversitas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('fakultas.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('fakultas.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="NamaFakultas">Nama Fakultas</label>
                                            <input type="text" name="NamaFakultas" class="form-control" id="NamaFakultas"
                                                placeholder="Nama Fakultas" value="{{ request()->input('NamaFakultas') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('fakultas.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Fakultas</th>
                                            <th>Kode Fakultas</th>
                                            <th>Nama Universitas</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($fakultas as $key => $fak)
                                            <tr>
                                                <td>{{ ($fakultas->currentPage() - 1) * $fakultas->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $fak->NamaFakultas }}</td>
                                                <td>{{ $fak->KodeFakultas }}</td>
                                                <td>{{ $fak->NamaUniversitas }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('fakultas.edit', $fak->id) }}"
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i> Edit</a>
                                                        <form action="{{ route('fakultas.destroy', $fak->id) }}"
                                                            method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $fakultas->withQueryString()->links() }}
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
@endpush

@push('customStyle')
@endpush
