@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Gedung</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Gedung</a></div>
                <div class="breadcrumb-item">Detail Gedung</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Informasi Gedung: {{ $gedung->NamaGedung }}</h2>
            <div class="row">
                <!-- Card Fakultas & Jurusan -->
                <div class="col-md-6">
                    <div class="card shadow-lg rounded h-100">
                        <div class="card-header">
                            <h4>Fakultas & Jurusan Program</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Universitas: </strong>
                                <span>{{ $gedung->universitas->NamaUniversitas }}</span>
                            </div>
                            @if ($gedung->Fakultas)
                                <div class="mb-3">
                                    <strong>Fakultas: </strong>
                                    <span>{{ $gedung->Fakultas->NamaFakultas ?? 'Tidak ada fakultas' }}</span>
                                </div>
                            @endif
                            @if ($gedung->JurusanPrograms)
                                <div class="mb-3">
                                    <strong>Jurusan Program: </strong>
                                    <span>{{ $gedung->JurusanPrograms->NamaJurusanPrograms ?? 'Tidak ada jurusan' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button id="toggleDetail" class="btn btn-primary btn-sm">Show Detail</button>
                        </div>
                    </div>
                </div>

                <!-- Card Detail Gedung (Hidden Initially) -->
                <div class="col-md-6" id="detailGedung" style="display:none;">
                    <div class="card shadow-lg rounded h-100">
                        <div class="card-header">
                            <h4>Detail Gedung</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Nama Gedung: </strong>
                                <span>{{ $gedung->NamaGedung }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Kode Gedung: </strong>
                                <span>{{ $gedung->KodeGedung }}</span>
                            </div>
                            @if ($gedung->JumlahLantaiGedung)
                                <div class="mb-3">
                                    <strong>Jumlah Lantai Gedung: </strong>
                                    <span>{{ $gedung->JumlahLantaiGedung ?? 'Tidak tersedia' }}</span>
                                </div>
                            @endif
                            @if ($gedung->kapasitasGedung)
                                <div class="mb-3">
                                    <strong>Kapasitas Gedung: </strong>
                                    <span>{{ $gedung->kapasitasGedung ?? 'Tidak tersedia' }}</span>
                                </div>
                            @endif
                            <div class="mb-3">
                                <strong>Status Gedung: </strong>
                                @if ($gedung->StatusGedung == 'Active')
                                    <span class="badge badge-success">{{ $gedung->StatusGedung }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $gedung->StatusGedung }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card-footer text-right mt-4">
                <a class="btn btn-secondary" href="{{ route('gedung.index') }}">Back</a>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            // Toggle between show and hide on the same button
            $('#toggleDetail').click(function() {
                if ($('#detailGedung').is(':visible')) {
                    $('#detailGedung').slideUp("slow"); // Hide the detail card with slide effect
                    $(this).text('Show Detail'); // Change button text to 'Show Detail'
                } else {
                    $('#detailGedung').slideDown("slow"); // Show the detail card with slide effect
                    $(this).text('Hide Detail'); // Change button text to 'Hide Detail'
                }
            });
        });
    </script>
@endpush
