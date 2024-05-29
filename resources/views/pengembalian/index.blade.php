@extends('layouts.content')

@section('scriptPages')
    {{-- <script src="{{ asset('js/barangM/index.js') }}"></script> --}}
    <script src="{{ asset('js/barang-keluar/index.js') }}"></script>
@endsection
@section('modal')
    @include('pengembalian.modal')
@endsection

@section('title', 'Pengembalian')


@section('content')
    {{-- @dd($barangM) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Form Pengembalian</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="code_barang">ID Peminjaman</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Masukkan ID Peminjaman!"
                                    aria-label="peminjaman" id="id_peminjaman">
                                <button class=" btn btn-success" id="cari_peminjaman"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" placeholder="Nama barang"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="kategori_barang" class="form-label">Kategori Barang</label>
                                <input type="text" class="form-control" id="kategori_barang"
                                    placeholder="Kategori barang" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" readonly>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="peminjam" class="form-label">Peminjam</label>
                                <input type="text" class="form-control" id="peminjam" readonly>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="tglpeminjaman" class="form-label">Tanggal peminjaman</label>
                                <input type="text" class="form-control" id="tglpeminjaman" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="bataspengembalian" class="form-label">Batas pengembalian</label>
                                <input type="text" class="form-control" id="bataspengembalian" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="reason" class="form-label">Alasan Peminjaman</label>
                                <textarea name="" id="reason" class="form-control" rows="7" readonly></textarea>
                                <span id="reason_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="reason" class="form-label">Kondisi barang</label>
                                <textarea name="" id="kondisi" class="form-control" rows="7"></textarea>
                                <span id="kondisi_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>




                    <div class="divider"></div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" id="kembalikan">Kembalikan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
