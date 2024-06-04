@extends('layouts.content')

@section('scriptPages')
    <script src="/js/request/peminjaman.js"></script>
@endsection
@section('modal')
@endsection

@section('title', 'Request Peminjaman')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Request Peminjaman</h5>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="table_request" width="100%"
                                cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>Kode Peminjaman</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Peminjam</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Kode Peminjaman</th>
                                        <th>Nama Barang</th>
                                        <th>Nama User</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    {{-- @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->kode_peminjaman }}</td>
                                            <td>{{ $item->barang->nama_barang }}</td>
                                            <td>{{ $item->user->username }}</td>
                                            <td>{!!  !!}
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
