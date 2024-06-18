<!-- create/update data user Modal-->
<div class="modal fade" id="modalJabatan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-kategori">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id" id="id" />
                        <label for="jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan"
                            placeholder="exp: Kepala labor" />
                        <span id="jabatan_error" class="text-danger"></span>
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
