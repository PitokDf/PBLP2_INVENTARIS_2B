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
                        <a href="{{ route('cetak.pdf') }}" target="_blank" class="btn btn-sm btn-primary"id="btnCetak">
                            <i class="fas fa-solid fa-print"></i>
                            Cetak
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
                                        <th colspan="3" style="text-align: center;">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;">Jumlah barang tersedia</th>
                                        <th style="text-align: center;">Jumlah barang dipinjam</th>
                                        <th style="text-align: center;">Stok</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                        <th>Jumlah barang tersedia</th>
                                        <th>Jumlah barang dipinjam</th>
                                        <th style="text-align: center;">Stok</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($barangs as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->code_barang }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{!! $item->kategori->nama_kategori_barang ?? '<strong style="color: red;">not found</strong>' !!}
                                            </td>
                                            <td>
                                                {{ $item->quantity + $item->peminjaman->sum('jumlah') }}
                                            </td>

                                            <td>
                                                {{ $item->peminjaman->sum('jumlah') != 0 ? $item->peminjaman->sum('jumlah') : '~' }}
                                            </td>
                                            <td class="{{ $item->quantity == 0 ? 'bg-danger text-white' : '' }}">
                                                {{ $item->quantity }}</td>
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
