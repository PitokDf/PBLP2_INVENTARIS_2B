{{-- modal detail barang masuk --}}
<div class="modal fade" id="modalDetail" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Detail Barang Masuk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="text-dark">Kode Barang</th>
                            <td>: <span id="txt_kode_barang">B001 (dummy)</span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Nama Barang</th>
                            <td>: <span id="txt_namaBarang">HP Laptop (dummy)</span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Quantity</th>
                            <td>: <span id="txt_quantity">135 (dummy)</span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Pemasok</th>
                            <td>: <span id="txt_pemasok">PT. Anugrah Selalu (dummy)</span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Tgl Masuk</th>
                            <td>: <span id="txt_tgl_masuk">Minggu, 26 mei 2024 (dummy)</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal add pemasok --}}
<div class="modal fade" id="modalPemasok" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Form Add Pemasok
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="hidden" class="form-control" name="id" id="id" />
                    <label for="nama_pemasok" class="form-label">Nama Pemasok</label>
                    <input type="text" class="form-control" name="nama_pemasok" id="nama_pemasok"
                        placeholder="exp: budi sugiono">
                    <span id="nama_error" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="kode_pos" class="form-label">Kode Pos</label>
                    <input type="number" name="kode_pos" id="kode_pos" placeholder="exp: 25652" class="form-control">
                    <span id="kode_pos_error" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="kota" class="form-label">Kota</label>
                    <input type="text" name="kota" id="kota" placeholder="exp: Padang" class="form-control">
                    <span id="kota_error" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP (CP)</label>
                    <input type="number" name="no_hp" id="no_hp" placeholder="exp: 08*******"
                        class="form-control">
                    <span id="nohp_error" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="3"></textarea>
                    <span id="alamat_error" class="text-danger"></span>
                </div>
                <div class="divider"></div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-primary" id="simpan">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
