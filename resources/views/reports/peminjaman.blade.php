@extends('layouts.content')

@section('title', 'Laporan Peminjaman')
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
                    <h5 class="m-0 font-weight-bold text-secondary">Laporan Peminjaman</h5>
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
                                        <th style="text-align: center;">kode Peminjaman</th>
                                        <th style="text-align: center;">Kode Barang</th>
                                        <th style="text-align: center;">Nama Barang</th>
                                        <th style="text-align: center;">Banyak Pinjam</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center;">kode Peminjaman</th>
                                        <th style="text-align: center;">Kode Barang</th>
                                        <th style="text-align: center;">Nama Barang</th>
                                        <th style="text-align: center;">Banyak Pinjam</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($peminjamans as $item)
                                        <tr>
                                            <td>{{ $item->kode_peminjaman }}</td>
                                            <td>{{ $item->barang->code_barang }}</td>
                                            <td>{{ $item->barang->nama_barang }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td
                                                class="{{ $item->tgl_pengembalian ? 'text-success text-bold' : 'text-danger text-bold' }}">
                                                {{ $item->tgl_pengembalian ? 'sudah dikembalikan' : 'belum dikembalikan' }}
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
