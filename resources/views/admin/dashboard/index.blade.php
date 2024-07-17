@extends('layouts.content')

@section('modal')
    @include('admin.berita.modal')
@endsection
@section('title', 'Dashboard')
@section('scriptPages')
    @vite('resources/js/topThreeBarang.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $.ajax({
            type: "GET",
            url: "test",
            dataType: "json",
            success: function(response) {
                // console.log(response, dipinjam);
                const canvas = document.getElementById('ketersedian');
                const labels = response.data.labels;
                const data = {
                    labels: response.data.labels,
                    datasets: [{
                            label: 'Stok',
                            data: response.data.stok,
                            backgroundColor: 'rgba(0, 165, 55, 0.4)',
                            borderColor: 'rgba(0, 165, 55, 1)',
                            borderWidth: 1,
                            tension: 0.2
                        },
                        {
                            label: 'Dipinjam',
                            data: response.data.dipinjam.map(item => item.jumlah_peminjaman),
                            backgroundColor: 'rgba(255, 0, 43, 0.4)',
                            borderColor: 'rgba(255, 0, 43, 1)',
                            borderWidth: 1,
                            tension: 0.2
                        }
                    ],
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                const myChart = new Chart(canvas, config);
            }
        });
    </script>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Barang</div>
                            <div class="row">
                                <div class="col-6">Tersedia</div>
                                <div class="col-6">: {{ $barang }}</div>
                                <div class="col-6">Dipinjam</div>
                                <div class="col-6">: {{ $pinjaman }}</div>
                                <div class="col-6">Total</div>
                                <div class="col-6">: {{ $barang + $pinjaman }}</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Dosen</div>
                            <div class="h5 mb-1 font-weight-bold text-gray-800">{{ $dosen }}</div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Mahasiswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mahasiswa }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kategori Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kategoriB }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pengguna Terverifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Stok Kategori Barang</h6>
                    <div class="dropdown no-arrow">
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="ketersedian" width="600px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">3 Barang Terbanyak</h6>
                    <div class="dropdown no-arrow">
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <canvas id="topThreeBarang"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
