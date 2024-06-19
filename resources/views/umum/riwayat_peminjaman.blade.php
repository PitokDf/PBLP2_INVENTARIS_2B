@extends('layouts.content')
@section('title', 'Riwayat Peminjaman')
@section('scriptPages')
    <script src="/js/umum/riwayat_peminjaman.js"></script>
@endsection

@section('modal')
    @include('umum.modal')
    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Detail Peminjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Riwayat Peminjaman</h5>
                    <div>
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
                                        <th>Kode peminjaman</th>
                                        <th>Nama barang</th>
                                        <th>Tanggal peminjaman</th>
                                        <th>Batas pengembalian</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjaman as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_peminjaman ?? '~' }}</td>
                                            <td>{{ $item->barang->nama_barang }}</td>
                                            <td>{{ $item->tgl_peminjaman }}</td>
                                            <td>{{ $item->batas_pengembalian }}</td>
                                            <td>{!! $item->status == 1
                                                ? ($item->tgl_pengembalian === null
                                                    ? '<span class="badge text-bg-info">Belum dikembalikan</span>'
                                                    : '<span class="badge text-bg-success">Sudah dikembalikan</span>')
                                                : ($item->status == 2
                                                    ? '<span class="badge text-bg-danger"><i class="fas fa-ban"></i> Request ditolak</span>'
                                                    : '<span class="badge text-bg-warning"><i class="fas fa-clock"></i> Pending Request</span>') !!}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-id="{{ $item->id }}"
                                                    id="btnDetail">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
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
