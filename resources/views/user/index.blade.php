@extends('layouts.content')

@section('scriptPages')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
@endsection
@section('title', 'Users')
@section('modal')
    @include('user.modal')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Data Users</h5>
                    <div>
                        <a href="" class="btn btn-sm btn-success" data-toggle="modal" id="btnCreate">
                            <i class="fas fa-solid fa-plus"></i>
                            Add
                        </a>
                        <a href="#" class="btn btn-sm btn-primary btnExport">
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
                            <table class="table table-bordered table-hover" id="tableUsers" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Peran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Peran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // $role = ['Admin', 'Pimpinan', 'Dosen', 'Mahasiswa', 'Staff'];
                                    ?>
                                    {{-- @foreach ($data as $item)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $role[$item->role - 1] }}</td>
                                            <td>
                                                @if ($item->role == 1)
                                                    <button disabled style="cursor: not-allowed;"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas a-solid fa-trash"></i>
                                                    </button> |
                                                    <button disabled style="cursor: not-allowed;"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-regular fa-pen"></i>
                                                    </button>
                                                @else
                                                    <button type="button" data-id="{{ $item->id_user }}"
                                                        class="btn btn-sm btn-danger btnDelete">
                                                        <i class="fas a-solid fa-trash"></i>
                                                    </button> |
                                                    <button class="btn btn-sm btn-warning btnEdit"
                                                        id="{{ $item->id_user }}">
                                                        <i class="fas fa-regular fa-pen"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
