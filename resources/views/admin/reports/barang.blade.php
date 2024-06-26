@extends('layouts.content')

@section('title', 'Laporan Barang')
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
                    <h5 class="m-0 font-weight-bold text-secondary">Laporan Barang</h5>
                    <div>
                        <a href="/report-barang" class="btn btn-sm btn-primary" target="_blank" id="btnCreate">
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
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                        <th>Jumlah</th>
                                        <th>Posisi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                        <th>Jumlah</th>
                                        <th>Posisi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($barangs as $item)
                                        <tr
                                            class="{{ $item->quantity == 0 ? 'bg-danger text-light' : ($item->quantity <= 15 ? 'bg-warning text-light' : '') }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->code_barang }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{!! $item->kategori->nama_kategori_barang ?? '<strong style="color:red;">not found</strong>' !!}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->posisi }}</td>
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
