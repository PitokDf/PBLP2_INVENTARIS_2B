@extends('layouts.content')
@section('title', 'Peminjaman')
@section('scriptPages')
    <script>
        $(document).ready(function() {
            $('#showprofile').on('click', function() {
                $('#profile').modal('show');
            });
        });
    </script>
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
    @if (in_array(Auth::user()->role, ['3', '4']) && Auth::user()->mahasiswa_id == null)
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
                Lengkapi profil anda untuk dapat melakukan peminjaman, click tombol <button
                    class="btn btn-sm btn-transparent" id="showprofile">ini</button> untuk
                melengkapi profil anda.
            </div>
        </div>
    @endif

    @if (auth()->user()->role == '4')
        <div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-10">
                                    <div class="row mb-3">
                                        <div class="col-lg-12 d-flex justify-content-center">
                                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=4e73df&color=ffffff&size=150"
                                                alt="" class="img-profile rounded-circle">
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="exp: John Doe">
                                        <label for="nama">Nama Lengkap</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nama" name=""
                                            placeholder="exp: John Doe">
                                        <label for="nama">Nama Lengkap</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nama"
                                            placeholder="exp: John Doe">
                                        <label for="nama">Nama Lengkap</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-primary" type="button" data-bs-dismiss="modal"><i
                                    class="fas fa-window-close"></i>
                                save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if (auth()->user()->role == '3')
        <div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Profile Dosen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 d-flex justify-content-center">
                                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=4e73df&color=ffffff&size=150"
                                        alt="" class="img-profile rounded-circle" style="height: 150px;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" name="id" id="id" />
                                        <label for="name" class="form-label">Nama Dosen</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="exp: Budi Siregar" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input type="number" class="form-control" name="nip" id="nip"
                                            placeholder="exp: 1999270190" />
                                        <span id="nip_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <select class="form-control" name="jabatan" id="jabatan">
                                            <option value="">--Pilih Jabatan--</option>
                                            {{-- @foreach ($jabatans as $item)
                                    <option value="{{ $item->jabatan }}">{{ $item->jabatan }}</option>
                                @endforeach --}}
                                        </select>
                                        <span id="jabatan_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="no_telpn" class="form-label">No Telepon</label>
                                        <input type="tel" class="form-control" name="no_telpn" id="no_telpn"
                                            placeholder="exp: 081234567890" />
                                        <span id="no_telpn_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="exp: budi@gmail.com" />
                                        <span id="email_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="file_image" class="form-label">Foto
                                            <img src="{{ asset('images/download.png') }}" class="img-thumbnail"
                                                id="img-preview" style="width: 200px; display: none;" alt="">
                                            <span id="dir_foto_error" class="text-danger"></span>
                                        </label>
                                        <input type="file" class="form-control" onchange="previewImage()"
                                            name="dir_foto" id="file_image" accept="image/*" hidden />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal"><i
                                    class="fas fa-window-close"></i>
                                Cancel</button>
                            <button type="button" class="btn btn-sm btn-primary action">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
