@extends('layouts.content')

@section('scriptPages')
    {{-- <script src="{{ asset('js/barangM/index.js') }}"></script> --}}
    <script src="/js/pemasok/index.js"></script>
@endsection
@section('modal')
    @include('admin.pemasok.modal')
@endsection

@section('title', 'Pemasok')


@section('content')
    {{-- @dd($barangM) --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow shadow-warning mb-4 form-pemasok">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary form-title">Form Pemasok</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" class="form-control d-none" name="id" id="id" />
                        <label for="nama_pemasok" class="form-label">Nama Pemasok</label>
                        <input type="text" class="form-control" name="nama_pemasok" id="nama_pemasok"
                            placeholder="exp: budi sugiono">
                        <span id="nama_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="number" name="kode_pos" id="kode_pos" placeholder="exp: 25652" class="form-control">
                        <span id="kode_pos_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" name="kota" id="kota" placeholder="exp: Padang" class="form-control">
                        <span id="kota_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP (CP)</label>
                        <input type="number" name="no_hp" id="no_hp" placeholder="exp: 08*******"
                            class="form-control">
                        <span id="nohp_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="3"></textarea>
                        <span id="alamat_error" class="text-danger"></span>
                    </div>
                    <div class="divider"></div>
                    <div class="d-flex justify-content-end">
                        <div id="btn-cancel"></div> <button class="btn btn-sm btn-primary action-btn"
                            id="simpan">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Pemasok</h5>
                    <button type="button" class="btn btn-sm btn-light" id="btn_refresh" data-table="tablePemasok">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tablePemasok" width="100%"
                                cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pemasok</th>
                                        <th>Kode Pos</th>
                                        <th>No HP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pemasok</th>
                                        <th>Kode Pos</th>
                                        <th>No HP</th>
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
