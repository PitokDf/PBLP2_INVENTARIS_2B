<!-- create/update data user Modal-->
<div class="modal fade" id="modalProdi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" class="needs-validation">
                <div class="modal-body">
                    <div class="col">
                        <div class="row-12">
                            <div class="error"></div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="id" id="id"
                                    data-id="" />
                            </div>
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Prodi</label>
                                <input type="text" class="form-control" name="kode" id="kode"
                                    placeholder="exp: TRPL" />
                                <span id="kode_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama_prodi" class="form-label">Nama Prodi</label>
                                <input type="nama_prodi" class="form-control" name="nama_prodi" id="nama_prodi"
                                    placeholder="exp: Teknologi Rekayasa Perangkat Lunak" />
                                <span id="nama_error" class="text-danger"></span>
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
