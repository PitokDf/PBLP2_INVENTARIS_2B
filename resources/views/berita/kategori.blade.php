@extends('layouts.content')

@section('scriptPages')
    <script src="{{ asset('js/kategori/index.js') }}"></script>
@endsection
@section('modal')
    @include('berita.modal')
@endsection

@section('title', 'Kategory Berita')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Data Kategori Berita</h5>
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
                            <table class="table table-bordered" id="table_kategori" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategory</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategory</th>
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
