@extends('layouts.content')

@section('scriptPages')
    {{-- <script src="{{ asset('js/barangM/index.js') }}"></script> --}}
    <script src="/js/barang-keluar/index.js"></script>
@endsection
@section('modal')
    @include('admin.barang_keluar.modal')
@endsection

@section('title', 'Barang Keluar BHP')


@section('content')
    {{-- @dd($barangM) --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Form Barang Keluar BHP</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id" id="id" />
                        <label for="barang" class="form-label">Barang</label>
                        <select name="barang" id="barangM" class="form-control">
                            <option value="">--Pilih Barang--</option>
                            @foreach ($barangs as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang . ' - ' . $item->code_barang }}
                                </option>
                            @endforeach
                        </select>
                        <span id="barang_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="user" class="form-label">Penerima</label>
                        <select name="user" id="user" class="form-control">
                            <option value="">--Pilih penerima--</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id_user }}">
                                    {{ $item->mahasiswa_id ? $item->mahasiswa->nama . ' - ' . $item->mahasiswa->nim . ' (Mahasiswa)' : ($item->dosen_id ? $item->dosen->name . ' - ' . $item->dosen->nip . ' (Dosen)' : $item->username . ' (Staf)') }}
                                </option>
                            @endforeach
                        </select>
                        <span id="user_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="barang" class="form-label">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" placeholder="Jumlah" class="form-control">
                        <span id="quantity_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tanggal Keluar</label>
                        <div class="input-group">
                            <select id="tahun" class="form-control">
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i > 1999; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select id="bulan" class="form-control">
                                <option value="">Bulan</option>
                                <?php
                                $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                ?>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $bulan[$i - 1] }}</option>
                                @endfor
                            </select>
                            <select id="tanggal" class="form-control">
                                <option value="">Tanggal</option>
                            </select>
                        </div>
                        <div id="tgl_keluar_error" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="3"></textarea>
                        <span id="keterangan_error" class="text-danger"></span>
                    </div>
                    <div class="divider"></div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" id="simpan">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Barang Keluar BHP</h5>
                    <button type="button" class="btn btn-sm btn-light" id="btn_refresh" data-table="tableBarangKeluar">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tableBarangKeluar"
                                width="100%" cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Penerima</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Quantity</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Penerima</th>
                                        <th>Tanggal Keluar</th>
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
