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
                            <div class="mb-3" style="border-bottom: 2px solid rgb(141, 141, 141);">
                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control-plaintext" name="nama_mahasiswa"
                                    id="nama_mahasiswa" value="Pito Desri Pauzi" />
                            </div>
                            <div class="mb-3" style="border-bottom: 2px solid rgb(141, 141, 141);">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control-plaintext" name="nim" id="nim"
                                    value="2211083044" />
                            </div>
                            <div class="mb-3" style="border-bottom: 2px solid rgb(141, 141, 141);">
                                <label for="prodi" class="form-label">Prodi</label>
                                <input type="text" class="form-control-plaintext" name="prodi" id="prodi"
                                    value="TRPL" />
                            </div>
                            <div class="mb-3" style="border-bottom: 2px solid rgb(141, 141, 141);">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <input type="text" class="form-control-plaintext" name="angkatan" id="angkatan"
                                    value="2022" />
                            </div>
                            <div class="mb-3" style="border-bottom: 2px solid rgb(141, 141, 141);">
                                <label for="ipk" class="form-label">IPK</label>
                                <input type="text" class="form-control-plaintext" name="ipk" id="ipk"
                                    value="3.58" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
