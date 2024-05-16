<!-- create/update data user Modal-->
<div class="modal fade" id="modal_peminjaman" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                                <label for="namaBarang" class="form-label">Nama Barang</label>
                                <select name="namaBarang" class="form-control" id="namaBarang">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($barangs as $item)
                                        <option value="{{ $item->id_barang }}">{{ $item->code_barang }} -
                                            {{ $item->nama_barang }}</option>
                                    @endforeach
                                </select>
                                <span id="namaB_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="namaUser" class="form-label">Nama User</label>
                                <select name="namaUser" class="form-control" id="namaUser">
                                    <option value="">-- Pilih User --</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id_user }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span id="namaU_error" class="text-danger"></span>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="tglPeminjaman" class="form-label">Tanggal Peminjaman</label>
                                        <input type="date" class="form-control" name="tglPeminjaman"
                                            id="tglPeminjaman" value="{{ date('Y-m-d') }}" readonly />
                                        <span id="tglP_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="batasPengembalian" class="form-label">Batas Pengembalian</label>
                                        <input type="date" class="form-control" name="batasPengembalian"
                                            id="batasPengembalian" value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                            readonly />
                                        <span id="batasP_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal"><i
                            class="fas fa-window-close"></i>
                        Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary action" id="btnCreateform">
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
