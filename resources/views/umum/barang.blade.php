@extends('layouts.content')
@section('title', 'Daftar Barang')
@section('scriptPages')
    <script>
        $('#tablebarang').DataTable();
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Daftar Barang Tersedia</h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-light btn-refresh" data-toggle="modal">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tablebarang" width="100%"
                                cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode barang</th>
                                        <th>Nama barang</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->code_barang }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->kategori->nama_kategori_barang }}</td>
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
