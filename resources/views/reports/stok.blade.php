@extends('layouts.content')

@section('title', 'Laporan Stok Barang')
@section('scriptPages')
    <script>
        $('#table_barang').dataTable();
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Laporan Stok Barang</h5>
                    <div>
                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" id="btnCetak">
                            <i class="fas fa-solid fa-print"></i>
                            Cetak
                        </a>
                        <a href="" class="btn btn-sm btn-danger" data-toggle="modal" id="btnLapor">
                            <i class="fas fa-solid fa-flag"></i>
                            Lapor
                        </a>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="table_barang" width="100%"
                                cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th style="text-align: center;" rowspan="2">No</th>
                                        <th rowspan="2" style="text-align: center;">Kode Barang</th>
                                        <th rowspan="2" style="text-align: center;">Nama Barang</th>
                                        <th rowspan="2" style="text-align: center;">Kategori Barang</th>
                                        <th colspan="3" style="text-align: center;">Stok</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;">Tersedia</th>
                                        <th style="text-align: center;">Dipinjam</th>
                                        <th style="text-align: center;">Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                        <th>Tersedia</th>
                                        <th>Dipinjam</th>
                                        <th style="text-align: center;">Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($barangs as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->code_barang }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->kategori->nama_kategori_barang }}</td>
                                            <td class="{{ $item->quantity == 0 ? 'bg-danger text-white' : '' }}">
                                                {{ $item->quantity }}</td>
                                            <td>
                                                {{ $item->peminjaman->sum('jumlah') != 0 ? $item->peminjaman->sum('jumlah') : '~' }}
                                            </td>
                                            <td>
                                                {{ $item->quantity + $item->peminjaman->sum('jumlah') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
