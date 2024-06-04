@extends('layouts.content')
@section('title', 'Peminjaman')
@section('scriptPages')
    <script src="/js/umum/peminjaman.js"></script>
@endsection
@section('content')
    @if (Auth::user()->role == 5)
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>
        <div class="alert alert-warning d-flex align-items-center shadow" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                Pilih ingin sebagai <a href="{{ route('mahasiswa') }}">Mahasiswa</a> atau <a
                    href="{{ route('dosen') }}">Dosen</a>. Abaikan jika anda ingin sebagai staff.
            </div>
        </div>
    @endif

    @if (in_array(auth()->user()->role, ['3', '4']) &&
            auth()->user()->mahasiswa_id === null &&
            auth()->user()->dosen_id === null)
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>

        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                <use xlink:href="#info-fill" />
            </svg>
            <div>
                Click <a class="text-warning" id="showprofile" style="cursor: pointer"><strong>lengkapi
                        Profile</strong></a>, untuk melengkapi data anda, agar dapat melakukan peminjaman.
            </div>
        </div>
    @elseif(in_array(auth()->user()->role, ['3', '4']))
        <div id="message"></div>
        <div class="alert alert-success">
            Selamat Datang Kembali
            <strong>{{ auth()->user()->dosen_id !== null ? auth()->user()->dosen->name : auth()->user()->mahasiswa->nama }}</strong>.
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-secondary">Form Peminjaman</h5>
                        <div>
                            <div><span id="time"></span> <i class="fas fa-clock"></i></div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <form id="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="code_barang">Kode Barang</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Masukkan kode barang!"
                                            style="height: 50px" aria-label="code barang" name="code_barang"
                                            id="code_barang">
                                        <button type="button" class="btn btn-success" id="cari_barang"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="stok">Stok barang</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="Stok barang"
                                            aria-label="stok" id="stok" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang"
                                            placeholder="Nama barang" readonly>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="kategori_barang" class="form-label">Kategori Barang</label>
                                        <input type="text" class="form-control" id="kategori_barang"
                                            placeholder="Kategori barang" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah pinjam</label>
                                        <input type="number" class="form-control" name="jumlah" id="jumlah"
                                            placeholder="Min 1" readonly>
                                        <span id="jumlah_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-xl">
                                    <label for="reason" class="form-label">Alasan Peminjaman</label>
                                    <textarea id="reason" name="reason" class="form-control" rows="7"></textarea>
                                    <span id="reason_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary action" id="btnRequest_peminjaman" disabled>Request</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- modal lengkapi data mahasiswa --}}
    @if (auth()->user()->role == '4' && auth()->user()->mahasiswa_id === null)
        <div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Lengkapi Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" id="nama"
                                    aria-describedby="helpId" placeholder="exp: Budi Sugiono" />
                                <span id="nama_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">Nim</label>
                                <input type="text" class="form-control" name="nim" id="nim"
                                    aria-describedby="helpId" placeholder="exp: 2211******" />
                                <span id="nim_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="ipk" class="form-label">IPK</label>
                                <input type="number" class="form-control" name="ipk" id="ipk"
                                    aria-describedby="helpId" placeholder="min: 0.00, max: 4.00">
                                <span id="ipk_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="prodi" class="form-label">Prodi</label>
                                <select name="prodi" id="prodi" class="form-control">
                                    <option value="" selected>--Pilih Prodi--</option>
                                    @foreach ($prodis as $item)
                                        <option value="{{ $item->code_prodi }}">{{ $item->code_prodi }}</option>
                                    @endforeach
                                </select>
                                <span id="prodi_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <select name="angkatan" id="angkatan" class="form-control">
                                    @for ($i = 2009; $i < date('Y'); $i++)
                                        <option {{ $i == date('Y') - 1 ? 'selected' : '' }} value="{{ $i }}">
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                                <span id="angkatan_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-primary" id="saveData" type="button"><i
                                    class="fas fa-save"></i> save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- modal lengkapi data dosen --}}
    @if (auth()->user()->role == '3' && auth()->user()->dosen_id === null)
        <div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Lengkapi Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" id="nama"
                                    aria-describedby="helpId" placeholder="exp: Budi Sugiono" />
                                <span id="nama_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="number" class="form-control" name="nip" id="nip"
                                    aria-describedby="helpId" placeholder="exp: 1999121299" />
                                <span id="nip_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select name="jabatan" id="jabatan" class="form-control">
                                    <option value="" selected>--Pilih Jabatan--</option>
                                    @foreach ($jabatans as $item)
                                        <option value="{{ $item->id }}">{{ $item->jabatan }}</option>
                                    @endforeach
                                </select>
                                <span id="jabatan_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No Handphone</label>
                                <input type="text" class="form-control" name="no_hp" id="no_hp"
                                    aria-describedby="helpId" placeholder="exp: 08**********" />
                                <span id="no_hp_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-primary" id="saveData" type="button"><i
                                    class="fas fa-save"></i> save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
