@extends('layouts.content')

@section('title', 'Laporan Barang Masuk')
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
                    <h5 class="m-0 font-weight-bold text-secondary">Laporan Barang Masuk</h5>
                    <div>
                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" id="btnCreate">
                            <i class="fas fa-solid fa-print"></i>
                            Cetak
                        </a>
                        @if (Auth::user()->role == 2)
                            <a href="" class="btn btn-sm btn-danger" data-toggle="modal" id="btnCreate">
                                <i class="fas fa-solid fa-flag"></i>
                                Lapor
                            </a>
                        @endif
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
                                        <th>Pemasok</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Pemasok</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($barangs as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->barang->code_barang }}</td>
                                            <td>{{ $item->barang->nama_barang }}</td>
                                            <td>{{ $item->pemasok->nama }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->quantity }}</td>
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
