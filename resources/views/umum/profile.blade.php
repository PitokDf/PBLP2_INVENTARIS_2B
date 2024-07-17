@extends('layouts.content')
@section('title', 'Profile')
@section('scriptPages')
    <script>
        $('#tablebarang').DataTable();
    </script>
    @vite('resources/js/umum/profile.js')
@endsection
@section('content')
    @if (!auth()->user()->mahasiswa_id && !auth()->user()->dosen_id)
        <h3>Harap Lengkapi data anda.</h3>
    @else
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header text-bold text-center" style="background-color: #001e959a">
                        <h4 style="color: white" class="text-bold">Akun</h4>
                    </div>
                    <div class="card-body">
                        <div id="area-message-akun"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center mt-3 d-flex flex-column justify-content-center"
                                    style="align-items: center">
                                    <label class="d-block position-relative"
                                        style="width: 120px; height: 120px; z-index: 99" for="file_image">
                                        <div class="rainbow-border">
                                            <img class="img-profile rounded-circle avatar"
                                                style="width: 120px; height: 120px; object-fit: cover;" id="img-preview"
                                                src=" {{ auth()->user()->avatar
                                                    ? auth()->user()->avatar
                                                    : 'https://ui-avatars.com/api/?name=' .
                                                        (auth()->user()->mahasiswa_id
                                                            ? auth()->user()->mahasiswa->nama
                                                            : (auth()->user()->dosen_id
                                                                ? auth()->user()->dosen->name
                                                                : Auth::user()->username)) .
                                                        '&background=4e73df&color=ffffff&size=100' }} ">
                                        </div>
                                        <div class="overlayy">
                                            <i class="fas fa-edit opacity-70"></i>
                                        </div>
                                    </label>
                                    <h5 class="mt-3">
                                        {{ auth()->user()->mahasiswa_id ? auth()->user()->mahasiswa->nama : (auth()->user()->dosen_id ? auth()->user()->dosen->name : Auth::user()->username) }}
                                    </h5>
                                    <input type="file" id="file_image" onchange="previewImage()" accept="image/*" hidden>
                                </div>
                            </div>
                        </div>
                        <table class="table mt-5">
                            <tr>
                                <th>Username</th>
                                <td>: <span class="nama">{{ auth()->user()->username }}</span></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: <span class="nim">{{ auth()->user()->email }}</span></td>
                            </tr>
                        </table>
                        <label for="">Ganti Password (opsional)</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" placeholder="Masukkan password baru" class="form-control" id="password"
                                aria-label="Amount">
                        </div>
                        <span id="pass_error"></span>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" type="button" id="saveAkun">Save Changes</button>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card shadow mb-4">
                    <div class="card-header text-bold text-center" style="background-color: #001e959a ">
                        <h4 style="color: white" class="text-bold">Detail Profil</h4>
                    </div>
                    <div class="card-body">
                        <div id="area-message-profile"></div>
                        @if (in_array(auth()->user()->role, ['2', '3', '5']))
                            <div class="mb-3">
                                <label for="">Nama</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" class="form-control" value="{{ auth()->user()->dosen->name }}"
                                        aria-label="Amount (to the nearest dollar)" id="namaD">
                                </div>
                                <span id="namaD_error"></span>
                                <label for="">NIP</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-digital-tachograph"></i></span>
                                    <input type="text" class="form-control" value="{{ auth()->user()->dosen->nip }}"
                                        aria-label="Amount" disabled>
                                </div>
                                <label for="">Jabatan</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    <select class="form-control" id="jabatan"
                                        {{ auth()->user()->role == '2' ? 'disabled' : '' }}>
                                        <option value="">--Pilih Jabatan--</option>
                                        @foreach ($jabatans as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id === auth()->user()->dosen->jabatan->id ? 'selected' : '' }}>
                                                {{ $item->jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span id="jabatan_error"></span>
                                <label for="">Email</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="text" class="form-control" value="{{ auth()->user()->dosen->email }}"
                                        aria-label="Amount" disabled>
                                </div>
                                <label for="no_telp">No. Telepon</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->dosen->phone_number }}" id="no_telp"
                                        aria-label="Amount">
                                </div>
                                <span id="no_telp_error"></span>
                            </div>
                        @endif

                        @if (auth()->user()->role == 4)
                            {{-- mahasiswa --}}
                            <div class="mb-3">
                                <label for="">Nama</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" id="namaM" class="form-control"
                                        value="{{ auth()->user()->mahasiswa->nama }}" aria-label="Amount">
                                </div>
                                <span id="namaM_error"></span>
                                <label for="">NIM</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-digital-tachograph"></i></span>
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->mahasiswa->nim }}" disabled aria-label="Amount">
                                </div>
                                <label for="">Prodi</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    {{-- <input type="text" id="prodi" class="form-control" aria-label="Amount"
                                        value="{{ auth()->user()->mahasiswa->prodi->code_prodi }}"> --}}
                                    <select name="prodi" id="prodi" class="form-control">
                                        <option value="">--pilih prodi--</option>
                                        @foreach ($prodis as $item)
                                            <option value="{{ $item->code_prodi }}"
                                                {{ $item->code_prodi === auth()->user()->mahasiswa->prodi->code_prodi ? 'selected' : '' }}>
                                                {{ $item->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span id="prodi_error"></span>
                                <label for="">Angkatan</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                    <select name="angkatan" id="angkatan" class="form-control">
                                        @for ($i = 2009; $i < date('Y'); $i++)
                                            <option {{ $i == auth()->user()->mahasiswa->angkatan ? 'selected' : '' }}
                                                value="{{ $i }}">
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <span id="angkatan_error"></span>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" type="button" id="saveProfile">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
