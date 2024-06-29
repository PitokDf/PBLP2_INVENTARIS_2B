<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modalPeminjaman" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modalTitleId">
                    Form Peminjaman (<span id="kodeP"></span>)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <label for="code_barang">Kode Barang</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukkan kode barang!"
                                aria-label="code barang" id="code_barang">
                            <button class=" btn btn-success" id="cari_barang"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-lg">
                        <label for="code_barang">Stok barang</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Stok barang" aria-label="stok"
                                id="stok" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" placeholder="Nama barang"
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="kategori_barang" class="form-label">Kategori Barang</label>
                            <input type="text" class="form-control" id="kategori_barang"
                                placeholder="Kategori barang" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah pinjam</label>
                            <input type="number" class="form-control" id="jumlah" placeholder="Min 1" readonly>
                            <span id="jumlah_error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="namaUser" class="form-label">Peminjam</label>
                    <select name="namaUser" class="form-control" id="namaUser">
                        <option value="">-- Pilih Peminjam--</option>
                        @foreach ($users as $item)
                            <option value="{{ $item->id_user }}">
                                {{ $item->role == '5' ? $item->dosen->name . ' - Staf' : ($item->mahasiswa_id ? $item->mahasiswa->nama . ' - ' . $item->mahasiswa->nim . ' (Mahasiswa)' : ($item->dosen_id ? $item->dosen->name . ' - ' . $item->dosen->nip . ' (Dosen)' : '')) }}
                            </option>
                        @endforeach
                    </select>
                    <span id="namaU_error" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Alasan Peminjaman</label>
                    <textarea name="" id="reason" class="form-control" rows="7"></textarea>
                    <span id="reason_error" class="text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-window-close"></i> Close
                </button>
                <button type="button" class="btn btn-sm btn-primary action" disabled></button>
            </div>
        </div>
    </div>
</div>

{{-- modal kembalikan --}}
<div class="modal fade" id="modalKembalikan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modalTitleId">
                    Form Pengembalian - Denda <span id="txt_denda"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nama_barangK" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barangK" placeholder="Nama barang"
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="kode_barangK" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barangK"
                                placeholder="Kategori barang" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="jumlahK" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlahK" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="peminjamK" class="form-label">Peminjam</label>
                            <input type="text" class="form-control" id="peminjamK" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="tglpeminjamanK" class="form-label">Tanggal peminjaman</label>
                            <input type="text" class="form-control" id="tglpeminjamanK" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="bataspengembalianK" class="form-label">Batas pengembalian</label>
                            <input type="text" class="form-control" id="bataspengembalianK" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="reasonK" class="form-label">Alasan Peminjaman</label>
                            <textarea name="" id="reasonK" class="form-control" rows="7" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="kondisiK" class="form-label">Kondisi barang</label>
                            <textarea name="kondisiK" id="kondisiK" class="form-control" rows="7"></textarea>
                            <span id="kondisi_error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-window-close"></i> Close
                </button>
                <button class="btn btn-sm btn-primary" id="kembalikan">Kembalikan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail Peminjaman --}}
<div class="modal fade" id="modalDetailPeminjaman" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <td>: <span id="id_peminjaman"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Kode Barang</th>
                            <td>: <span id="kodeBarang"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Nama Barang</th>
                            <td>: <span id="namaBarang"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Nama Peminjam</th>
                            <td>: <span id="peminjam"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Tanggal Peminjaman</th>
                            <td>: <span id="dipinjam"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Batas Peminjaman</th>
                            <td>: <span id="batasPeminjaman"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Banyak Dipinjam</th>
                            <td>: <span id="banyakPinjam"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Status</th>
                            <td>: <span id="statusP"></span></td>
                        </tr>
                        <tr>
                            <th class="text-dark">Denda</th>
                            <td>: <span id="denda"></span></td>
                        </tr>
                    </table>
                </div>
                {{-- <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal"><i
                        class="fas fa-window-close"></i>
                    Cancel</button> --}}
            </div>
            {{-- <div class="modal-footer">
                
                <button type="button" class="btn btn-sm btn-primary action">
                </button>
            </div> --}}
        </div>
    </div>
</div>
