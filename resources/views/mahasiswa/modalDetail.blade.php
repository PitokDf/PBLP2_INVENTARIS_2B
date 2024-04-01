<!-- create/update data user Modal-->
<div class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form id="form"> --}}
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="col">
                        <div class="row-12">
                            <div class="mb-3">
                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa"
                                    placeholder="exp: Pito Desri Pauzi" @readonly(true) />
                                <span id="nama_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="number" @readonly(true) max="10" class="form-control"
                                    name="nim" id="nim" placeholder="exp: 2211083044" />
                                <span id="nim_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="prodi" class="form-label">Prodi</label>
                                <input class="form-control" type="text" @readonly(true) value="prodi"
                                    id="prodi">
                                <span id="prodi_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <input class="form-control" type="text" id="angkatan" @readonly(true)>
                                <span id="angkatan_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="ipk" class="form-label">IPK</label>
                                <input type="text" class="form-control" name="ipk" placeholder="exp: 3.60"
                                    id="ipk" @readonly(true)>
                                <span id="ipk_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
