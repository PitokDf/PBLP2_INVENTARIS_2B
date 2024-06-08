@extends('layouts.content')
@section('title', 'Daftar Barang')
@section('scriptPages')
    <script>
        $('#tablebarang').DataTable();
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header text-bold text-center" style="background-color: #001e959a">
                    <h4 style="color: white" class="text-bold">Akun</h4>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-auto text-center position-relative">
                                <label class="d-block position-relative" style="width: 120px; height: 120px;" for="file_image">
                                    <img class="img-profile rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover;" id="img-preview"
                                        src="https://ui-avatars.com/api/?name={{ auth()->user()->mahasiswa_id ? auth()->user()->mahasiswa->nama : (auth()->user()->dosen_id ? auth()->user()->dosen->name : Auth::user()->username) }}&background=4e73df&color=ffffff&size=100">
                                    <div class="overlayy">
                                        <span class="text btn btn-outline-light btn-small" >Ganti Foto Profil</span>
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
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-sm btn-primary" type="button" id="save">Save Changes</button>
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header text-bold text-center" style="background-color: #001e959a ">
                    <h4 style="color: white" class="text-bold">Detail Profil</h4>
                </div>
                <div class="card-body">
                    @if (auth()->user()->role == 3)
                        <div class="mb-3 mt-3">
                            <label for="">Nama</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                <input type="text" class="form-control" value="{{ auth()->user()->dosen->name }}"
                                    aria-label="Amount (to the nearest dollar)">
                            </div>
                            <label for="">NIP</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-digital-tachograph"></i></span>
                                <input type="text" class="form-control" value="{{ auth()->user()->dosen->nip }}"
                                    aria-label="Amount" disabled>
                            </div>
                            <label for="">Jabatan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                <input type="text" class="form-control" aria-label="Amount"
                                    value="{{ auth()->user()->dosen->jabatan->jabatan }}" disabled>
                            </div>
                            <label for="">Email</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="text" class="form-control" value="{{ auth()->user()->dosen->email }}"
                                    aria-label="Amount" disabled>
                            </div>
                            <label for="">No. Telepon</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                                <input type="text" class="form-control" value="{{ auth()->user()->dosen->phone_number }}"
                                    aria-label="Amount">
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->role == 4)
                        {{-- mahasiswa --}}
                        <div class="mb-3 mt-3">
                            <label for="">Nama</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                <input type="text" class="form-control" value="{{ auth()->user()->mahasiswa->nama }}"
                                    aria-label="Amount">
                            </div>
                            <label for="">NIM</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-digital-tachograph"></i></span>
                                <input type="text" class="form-control" value="{{ auth()->user()->mahasiswa->nim }}"
                                    disabled aria-label="Amount">
                            </div>
                            <label for="">Prodi</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                <input type="text" class="form-control" aria-label="Amount"
                                    value="{{ auth()->user()->mahasiswa->prodi->nama_prodi }}">
                            </div>
                            <label for="">Angkatan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                <input type="text" class="form-control"
                                    value="{{ auth()->user()->mahasiswa->angkatan }}" aria-label="Amount" disabled>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
