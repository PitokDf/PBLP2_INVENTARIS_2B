<!-- create/update data user Modal-->
<div class="modal fade" id="modalDosen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-kategori">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="id" id="id" />
                                <label for="name" class="form-label">Nama Dosen</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="exp: Budi Siregar" />
                                <span id="name_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="number" class="form-control" name="nip" id="nip"
                                    placeholder="exp: 1999270190" />
                                <span id="nip_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" id="jabatan"
                                    placeholder="exp: Kajur" />
                                <span id="jabatan_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="no_telpn" class="form-label">No Telepon</label>
                                <input type="tel" class="form-control" name="no_telpn" id="no_telpn"
                                    placeholder="exp: 081234567890" />
                                <span id="no_telpn_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="exp: budi@gmail.com" />
                                <span id="email_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="file_image" class="form-label">Foto
                                    <img src="{{ asset('images/download.png') }}" class="img-thumbnail" id="img-preview"
                                        style="width: 200px; display: none;" alt="">
                                    <span id="dir_foto_error" class="text-danger"></span>
                                </label>
                                <input type="file" class="form-control" onchange="previewImage()" name="dir_foto"
                                    id="file_image" accept="image/*" hidden />
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
