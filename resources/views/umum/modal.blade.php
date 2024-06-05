{{-- Modal Detail Peminjaman --}}
<div class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="fs-5" id="staticBackdropLabel">Detail Peminjaman</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="text-dark">Kode Peminjaman</th>
                            <td>: <span id="txt_kode_peminjaman"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Kode Barang</th>
                            <td>: <span id="txt_kode_barang"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Nama Barang</th>
                            <td>: <span id="txt_nama_barang"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Tanggal Peminjaman</th>
                            <td>: <span id="txt_tgl_dipinjam"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Batas Peminjaman</th>
                            <td>: <span id="txt_batas_pinjam"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Status</th>
                            <td>: <span id="txt_status"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Denda</th>
                            <td>: <span id="txt_denda"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Alasan</th>
                            <td>: <span id="txt_alasan"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
