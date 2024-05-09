<!-- create/update data user Modal-->
<div class="modal fade" id="modal-kategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-kategori">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="" id="form">
                <div class="modal-body">
                    <div class="col">
                        <div class="row-12">
                            <div class="error"></div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="id" id="id" />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Berita</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    placeholder="exp: Masalah labor" />
                                <span id="title_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <input type="hidden" class="form-control" id="content" name="content" />
                                <trix-editor input="content"></trix-editor>
                                <span id="content_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori Berita</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="">--Pilih Kategori--</option>
                                </select>
                                <span id="kategori_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="publikasi" class="form-label">Tanggal Publikasi</label>
                                <input type="date" class="form-control" name="publikasi" id="publikasi"
                                    placeholder="exp: Elektronik" />
                                <span id="publikasi_error" class="text-danger"></span>
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
