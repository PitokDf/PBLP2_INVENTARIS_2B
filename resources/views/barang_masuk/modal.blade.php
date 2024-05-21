<!-- create/update data user Modal-->
<div class="modal fade" id="modalBarangM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-kategori">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id" />
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id" id="id" />
                        <label for="barang" class="form-label">Barang</label>
                        <select name="barang" id="barangM" class="form-control">
                            <option value="">--Pilih Barang--</option>
                            @foreach ($barangs as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                        <span id="barang_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="barang" class="form-label">Quantity</label>
                        <input type="text" name="quantity" id="quantity" class="form-control">
                        <span id="quantity_error" class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Pemasok</label>
                        <input type="text" name="pemasok" id="pemasok" class="form-control">
                        <span id="pemasok_error" class="text-danger"></span>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('form').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah formulir untuk langsung disubmit

            // Mengambil nilai input gambar
            var imageInput = document.getElementById('dir_foto');
            var image = imageInput.files[0];

            // Memeriksa apakah input gambar tidak kosong
            if (image) {
                // Memeriksa tipe file gambar
                var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(image.type)) {
                    document.getElementById('dir_foto_error').innerHTML =
                        'File harus berupa gambar dengan format JPEG, JPG, atau PNG.';
                    return; // Menghentikan proses jika tipe file tidak sesuai
                }

                // Memeriksa ukuran file gambar (dalam bytes)
                var maxSize = 2 * 1024 * 1024; // 2MB
                if (image.size > maxSize) {
                    document.getElementById('dir_foto_error').innerHTML =
                        'Ukuran file tidak boleh melebihi 2MB.';
                    return; // Menghentikan proses jika ukuran file melebihi batas
                }
            }

            // Jika semua validasi berhasil, submit formulir
            this.submit();
        });
    });
</script>
