@extends('layouts.content')

@section('scriptPages')
    <script src="https://unpkg.com/html5-qrcode"></script>
    @vite(['resources/js/pemasok.js', 'resources/js/barang_masuk.js'])
@endsection
@section('modal')
    @include('admin.barang_masuk.modal')
    {{-- modal scan kode barang --}}
    <div class="modal fade" id="modal_scan_kode" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-secondary">
                        Scan Kode Barang.
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="qr-reader" style="width: 100%;"></div>
                        <div id="qr-reader-results"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title', 'Barang Masuk')

@section('content')
    {{-- @dd($barangM) --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Form Barang Masuk</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id" id="id" />
                        <label for="barang" class="form-label">Barang</label>
                        <div class="input-group">
                            <select name="barang" id="barangM" class="form-control">
                                <option value="">--Pilih Barang--</option>
                                @foreach ($barangs as $item)
                                    <option value="{{ $item->id_barang }}">
                                        {{ $item->nama_barang . ' - ' . $item->code_barang }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary" id="scan_kode"><i
                                    class="fas fa-barcode"></i></button>
                        </div>
                        <span id="barang_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Pemasok</label>
                        <div class="input-group">
                            <select name="barang" id="pemasok" class="form-control selectpicker">
                                {{-- <option value="">--Pilih Pemasok--</option>
                                @foreach ($pemasoks as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach --}}
                            </select>
                            <button type="button" class="btn btn-info" id='showModalPemasok'><i
                                    class="fas fa-plus"></i></button>
                        </div>
                        <span id="pemasok_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" placeholder="Quantity" class="form-control">
                        <span id="quantity_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="penerima" class="form-label">Penerima</label>
                        <div class="input-group">
                            <input type="text" name="penerima" id="penerima" placeholder="penerima"
                                class="form-control">
                        </div>
                        <span id="penerima_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tanggal Masuk</label>
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
                        <div id="tanggal_masuk_error" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="3"></textarea>
                        <span id="keterangan_error" class="text-danger"></span>
                    </div>
                    <div class="divider"></div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" id="simpanBarang">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Barang Masuk</h5>
                    <button type="button" class="btn btn-sm btn-light" id="btn_refresh" data-table="tableBarangM">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tableBarangM"
                                width="100%" cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Pemasok</th>
                                        <th>Quantity</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                {{-- <script src="{{ asset('js/preview.js') }}"></script> --}}
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Pemasok</th>
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
