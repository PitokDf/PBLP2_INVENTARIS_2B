<!-- import data user Modal-->
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
                    <h5 class="title">Pastikan file diimport terdapat kolom name, email, role</h5>
                    <input type="file" name="file" id="file" accept="excel/csv,xlsx" />
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

<!-- create/update data user Modal-->
<div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" class="needs-validation">
                <div class="modal-body">
                    <div class="col">
                        <div class="row-12">
                            <div class="error"></div>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="id" id="id"
                                    data-id="" />
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="exp: Budi Siregar" />
                                <span id="name_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="exp: budi@gmail.com" />
                                <span id="email_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3 role">
                                <?php
                                $role = ['Admin', 'Pimpinan', 'Dosen', 'Mahasiswa', 'Staff'];
                                ?>
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option selected disabled>-- Pilih Role --</option>
                                    @for ($i = 0; $i < 5; $i++)
                                        <option value="{{ $i + 1 }}">{{ $role[$i] }}</option>
                                    @endfor
                                </select>
                                <span id="role_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label id="labelPass" for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" name="password" id="password"
                                    placeholder="ex: 12345678" />
                                <span id="pass_error" class="text-danger"></span>
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
