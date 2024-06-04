<!-- create/update data user Modal-->
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="col">
                        <div class="row-12">
                            <div class="error"></div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="id" id="id" />
                            </div>
                            <div class="mb-3">
                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa"
                                    placeholder="exp: Pito Desri Pauzi" />
                                <span id="nama_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="number" max="10" class="form-control" name="nim" id="nim"
                                    placeholder="exp: 2211083044" />
                                <span id="nim_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="prodi" class="form-label">Prodi</label>
                                <select name="prodi" class="form-control" id="prodi">
                                    <option value="">--Pilih Prodi--</option>
                                    @foreach ($prodi as $item)
                                        <option value="{{ $item->code_prodi }}">{{ $item->nama_prodi }}</option>
                                    @endforeach
                                </select>
                                <span id="prodi_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <select name="angkatan" id="angkatan" class="form-control">
                                    @for ($i = date('Y'); $i > 2009; $i--)
                                        <option {{ $i == date('Y') - 1 ? 'selected' : '' }} value="{{ $i }}">
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                                <span id="angkatan_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="ipk" class="form-label">IPK</label>
                                <input type="text" class="form-control" name="ipk" placeholder="exp: 3.60"
                                    id="ipk">
                                <span id="ipk_error" class="text-danger"></span>
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


{{-- Modal Import --}}
<div class="modal fade" id="modalImport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih file</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="input-grub">
                        <label class="title" for="file">Upload file csv</label>
                        <input type="file" name="file" class="form-control" id="file"
                            accept="excel/csv,xlsx" />
                    </div>
                    <div class="error-area">

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
        </div>
    </div>
</div>
