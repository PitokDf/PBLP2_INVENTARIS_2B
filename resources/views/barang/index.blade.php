@extends('layouts.content')

@section('scriptPages')
    <script src="/js/barang/index.js"></script>
@endsection
@section('modal')
    @include('barang.modal')
    @include('barang.modalAddcategori')
@endsection

@section('title', 'Barang')


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
                        <a href="{{ route('barang.export') }}" class="btn btn-sm btn-primary""
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-solid fa-file-export"></i>
                            Export
                        </a>
                        <button type="button" class="btn btn-sm btn-primary showImport">
                            <i class="fas fa-solid fa-file-import"></i>
                            Import
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="deleteSelected" disabled>
                            <i class="fas fa-solid fa-trash"></i>
                            Delete
                        </button>
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
                                        <th><input type="checkbox" id="selectAll"> All</th>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                        <th>Merek</th>
                                        <th>Quantity</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>All</th>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                        <th>Merek</th>
                                        <th>Quantity</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
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
