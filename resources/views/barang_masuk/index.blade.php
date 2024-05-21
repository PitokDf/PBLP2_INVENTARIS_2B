@extends('layouts.content')

@section('scriptPages')
    <script src="{{ asset('js/barangM/index.js') }}"></script>
@endsection
@section('modal')
    @include('barang_masuk.modal')
@endsection

@section('title', 'Barang Masuk')


@section('content')
    {{-- @dd($barangM) --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Barang Masuk</h5>
                    <div>
                        <a href="" class="btn btn-sm btn-success" data-toggle="modal" id="btnCreate">
                            <i class="fas fa-solid fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tableBarangM" width="100%"
                                cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Pemasok</th>
                                        <th>Tgl. Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                {{-- <script src="{{ asset('js/preview.js') }}"></script> --}}
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Pemasok</th>
                                        <th>Tgl. Masuk</th>
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
