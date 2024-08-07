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
                    {{-- <label for="dari">Dimulai dari : <input type="date" id="dari" name="dari"></label> --}}
                    <div>
                        <form action="/report-barang-masuk" method="GET" target="_blank">
                            <div class="input-group mb-3">
                                <input type="date" name="awal" class="form-control" placeholder="Tanggal Mulai"
                                    aria-describedby="button-addon2">
                                <input type="date" name="akhir" class="form-control" placeholder="Tanggal Akhir"
                                    aria-describedby="button-addon2">
                                <button class="btn btn-primary" type="submit" data-bs-toggle="tooltip" id="cetakLaporan"
                                    data-bs-placement="top" title="Cetak laporan">Cetak</button>
                            </div>
                        </form>
                        {{-- <a href="/report-barang-masuk" class="btn btn-sm btn-primary" target="_blank" id="btnCreate">
                            <i class="fas fa-solid fa-print"></i>
                            Cetak
                        </a> --}}
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
                                            <td>{!! $item->barang->code_barang ?? '<strong style="color:red;">not found</strong>' !!}</td>
                                            <td>{!! $item->barang->nama_barang ?? '<strong style="color:red;">not found</strong>' !!}</td>
                                            <td>{!! $item->pemasok->nama ?? '<strong style="color:red;">not found</strong>' !!}</td>
                                            <td>{{ $item->tanggal_masuk }}</td>
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
