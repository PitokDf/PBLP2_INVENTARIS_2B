<!-- create/update data user Modal-->
<div class="modal fade" id="modal-kategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-kategori">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="error"></div>
                    <div class="mb-3 d-none">
                        <input type="hidden" class="form-control" name="id" id="id" />
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" name="kode_barang" id="kode_barang"
                                    placeholder="exp: B121203" />
                                <span id="kode_error" class="text-danger"></span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="merek" class="form-label">Merek</label>
                                        <select name="merek" id="merek" class="form-control">
                                            <option value="">-- pilih merk --</option>
                                            @foreach ($merk as $item)
                                                <option value="{{ $item->id }}">{{ $item->merk }}</option>
                                            @endforeach
                                        </select>
                                        <span id="merek_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori Barang</label>
                                        <select name="kategori" class="form-control" id="kategori">
                                        </select>
                                        <span id="kategori_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pemasok" class="form-label">Pemasok</label>
                                <select name="pemasok" class="form-control" id="pemasok">
                                    <option value="">-- pilih pemasok --</option>
                                    @foreach ($pemasoks as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <span id="pemasok_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="8" id="deskripsi"></textarea>
                                <span id="deskripsi_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang" id="nama_barang"
                                    placeholder="exp: Samsung Monitor" />
                                <span id="nama_error" class="text-danger"></span>
                            </div>

                            <div class="row">
                                <div class="col-7">
                                    <div class="mb-3">
                                        <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                        <div class="input-group">
                                            <select id="tahun" class="form-control">
                                                <option value="">Tahun</option>
                                                @for ($i = date('Y'); $i > 1900; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <select id="bulan" class="form-control">
                                                <option value="">Bulan</option>
                                                <?php
                                                $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                ?>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i < 10 ? '0' . $i : $i }}">{{ $bulan[$i - 1] }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <select id="tanggal" class="form-control">
                                                <option value="">Tanggal</option>
                                            </select>
                                        </div>
                                        <span id="tgl_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" name="jumlah"
                                            placeholder="exp: 12" id="jumlah">
                                        <span id="jumlah_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="posisi" class="form-label">Posisi</label>
                                <input type="text" class="form-control" name="posisi" placeholder="exp: E201"
                                    id="posisi">
                                <span id="posisi_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="">Foto</label>
                                <div>
                                    <label for="file_image" class="form-label">
                                        <img src="{{ asset('images/download.png') }}" class="img-thumbnail"
                                            id="img-preview" style="width: 200px;" alt="">
                                        <span id="dir_foto_error" class="text-danger"></span>
                                    </label>
                                </div>
                                <input type="file" class="form-control" onchange="previewImage()" name="dir_foto"
                                    id="file_image" accept="image/*" hidden />
                                <span id="foto_error" class="text-danger"></span>
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
                <a href="{{ route('download.barang') }}" class="btn btn-sm btn-success download">
                    <i class="fas fa-download"></i> contoh file
                </a>
            </div>
        </div>
    </div>
</div>
