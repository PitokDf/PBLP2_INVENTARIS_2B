<!-- create/update data user Modal-->
<div class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light">
                <h1 class="modal-title fs-5" id="modal">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form id="form"> --}}
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="col">
                        <div class="row-12">
                            <table class="table">
                                <tr>
                                    <th>Nama</th>
                                    <td>: <span class="nama"></span></td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>: <span class="nim"></span></td>
                                </tr>
                                <tr>
                                    <th>Prodi</th>
                                    <td>: <span class="prodi"></span></td>
                                </tr>
                                <tr>
                                    <th>Angkatan</th>
                                    <td>: <span class="angkatan"></span></td>
                                </tr>
                                <tr>
                                    <th>IPK</th>
                                    <td>: <span class="ipk"></span></td>
                                </tr>
                            </table>
                            {{-- <div class="mb-1">
                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                <div class="card mb-4 border-bottom-info">
                                    <span class="detail-item " style="margin: 8px" class="nama">Pito Desri
                                        Pauzi</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="nama_mahasiswa" class="form-label">NIM</label>
                                <div class="card mb-4 border-bottom-info">
                                    <span class="detail-item " style="margin: 8px" id="nim">2211083044</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="prodi" class="form-label">Prodi</label>
                                <div class="card mb-4 border-bottom-info">
                                    <span class="detail-item " style="margin: 8px" id="prodi">Teknologi Rekayasa
                                        Perangkat Lunak</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <div class="card mb-4 border-bottom-info">
                                    <span class="detail-item " style="margin: 8px" id="angkatan">Pito Desri
                                        Pauzi</span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label for="ipk" class="form-label">IPK</label>
                                <div class="card mb-4 border-bottom-info">
                                    <span class="detail-item " style="margin: 8px" id="ipk">3.65</span>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
