<div class="modal fade" id="detailBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="fs-5" id="staticBackdropLabel">Detail Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center mb-3">
                    <img src="" id="photo" class="img-circle img-thumbnail"
                        style="object-fit: cover; width: 150px; height: 150px;" alt="">
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="text-dark" style="min-width: 200px">Kode Barang</th>
                            <td>: <span id="txt_code_barang"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Nama Barang</th>
                            <td>: <span id="txt_nama_barang"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Kategori</th>
                            <td>: <span id="txt_kategori"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Merek</th>
                            <td>: <span id="txt_merek"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Pemasok</th>
                            <td>: <span id="txt_pemasok"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Tanggal Masuk</th>
                            <td>: <span id="txt_tgl_masuk"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Jumlah Barang</th>
                            <td>: <span id="txt_jumlah"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Posisi</th>
                            <td>: <span id="txt_posisi"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Deskripsi</th>
                            <td>: <span id="txt_deskripsi"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
