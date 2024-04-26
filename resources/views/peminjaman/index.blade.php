@extends('layouts.content')

@section('scriptPages')
    <script src="{{ asset('js/peminjaman/index.js') }}"></script>
@endsection
@section('modal')
    @include('barang.modal')
    @include('barang.modalAddcategori')
@endsection

@section('title', 'Peminjaman')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Data Barang</h5>
                    <div>
                        <a href="" class="btn btn-sm btn-success" data-toggle="modal" id="btnCreate">
                            <i class="fas fa-solid fa-plus"></i>
                            Add
                        </a>
                        <a href="/export-users" class="btn btn-sm btn-primary">
                            <i class="fas fa-solid fa-file-export"></i>
                            Export
                        </a>
                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#import-user">
                            <i class="fas fa-solid fa-file-import"></i>
                            Import
                        </a>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="table_peminjaman"
                                width="100%" cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Nama User</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Batas Pengembalian</th>
                                        <th>Tanggal Dikembalikan</th>
                                        <th>Status</th>
                                        <th>Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
