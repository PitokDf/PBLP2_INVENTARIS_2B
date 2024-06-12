@extends('layouts.content')

@section('scriptPages')
    <script src="{{ asset('js/pemasok/index.js') }}"></script>
    <script src="{{ asset('js/barangM/index.js') }}"></script>
@endsection
@section('modal')
    @include('barang_masuk.modal')
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
                        <select name="barang" id="barangM" class="form-control">
                            <option value="">--Pilih Barang--</option>
                            @foreach ($barangs as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                        <span id="barang_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Pemasok</label>
                        <div class="input-group mb-3">
                            <select name="barang" id="pemasok" class="form-select" style="flex:1">
                                <option value="">--Pilih Pemasok--</option>
                                @foreach ($pemasoks as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
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
                    <label for="penerima" class="form-label">Penerima</label>
                    <div class="input-group">
                        <input type="text" name="penerima" id="penerima" placeholder="penerima" class="form-control">
                        <input type="date" class="form-control date-picker-button" id="tanggal">
                    </div>
                    <span id="penerima_error" class="text-danger"></span>
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
                    <h5 class="m-0 font-weight-bold text-secondary">Barang Masuk</h5>
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
