@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Universitas List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Universitas Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Universitas List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('universitas.create') }}">Create New Universitas</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Universitas</a>
                                <a class="btn btn-info btn-primary active filter">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                    Filter Universitas</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-filter mb-3" style="display: none">
                                <form id="filter" method="GET" action="{{ route('universitas.index') }}"
                                    class="d-flex flex-wrap align-items-end">
                                    <div class="form-group mr-3">
                                        <label for="TipeInstitusi">Tipe</label>
                                        <select name="TipeInstitusi" class="form-control">
                                            <option value="">Pilih Tipe Institusi</option>
                                            <option value="Universitas"
                                                {{ request('TipeInstitusi') == 'Universitas' ? 'selected' : '' }}>
                                                Universitas</option>
                                            <option value="Politeknik"
                                                {{ request('TipeInstitusi') == 'Politeknik' ? 'selected' : '' }}>Politeknik
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="StatusUniversitas">Status</label>
                                        <select name="StatusUniversitas" class="form-control">
                                            <option value="">Pilih Status Universitas</option>
                                            <option value="Active"
                                                {{ request('StatusUniversitas') == 'Active' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="InActive"
                                                {{ request('StatusUniversitas') == 'InActive' ? 'selected' : '' }}>Non Aktif
                                            </option>
                                        </select>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-primary mr-2" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('universitas.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('universitas.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="NamaUniversitas">Universitas</label>
                                            <input type="text" name="NamaUniversitas" class="form-control"
                                                id="NamaUniversitas" placeholder="Nama Universitas"
                                                value="{{ request()->input('NamaUniversitas') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('universitas.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Kode</th>
                                            <th>Alamat</th>
                                            <th>No Telp</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Tipe</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($universitas as $key => $univ)
                                            <tr>
                                                <td>{{ ($universitas->currentPage() - 1) * $universitas->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $univ->NamaUniversitas }}</td>
                                                <td>{{ $univ->KodeUniversitas }}</td>
                                                <td>{{ $univ->AlamatUniversitas }}</td>
                                                <td>{{ $univ->NoTelpUniversitas }}</td>
                                                <td>{{ $univ->EmailUniversitas }}</td>
                                                <td>
                                                    @if ($univ->StatusUniversitas === 'Active')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @elseif($univ->StatusUniversitas === 'InActive')
                                                        <span class="badge badge-danger">Non Aktif</span>
                                                    @else
                                                        <span class="badge badge-secondary">Tidak Diketahui</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($univ->TipeInstitusi === 'Universitas')
                                                        <span class="badge badge-info"
                                                            style="background-color: #17066e; color: #fff;">Universitas</span>
                                                    @elseif($univ->TipeInstitusi === 'Politeknik')
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
                                                        <a href="{{ route('universitas.edit', $univ->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form action="{{ route('universitas.destroy', $univ->id) }}"
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
                                    {{ $universitas->withQueryString()->links() }}
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
