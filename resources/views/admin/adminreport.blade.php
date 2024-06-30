@extends('layouts.content')

@section('scriptPages')
    <script src="/js/request/peminjaman.js"></script>
@endsection
@section('modal')
@endsection

@section('title', 'Admin Bug Report')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">ADMIN BUG REPORT</h5>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    {{-- admin bug report --}}

                    <div class="card mb-4 shadow-lg">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-addon3">Bug 1</span>
                            <div class="form-control flex-grow-1">
                                <label for="basic-url">siky@gmail.com <span class="badge rounded-pill bg-primary text-white">Mahasiswa</span></label>
                            </div>
                            <div class="form-control text-end">
                                <label for="basic-url" style="color: #b4b4b4">Solved <i class="far fa-check-circle" style="color: #04ff00;"></i></label>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5><b>Minggu, 30 Juni 2024</b></h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi ut ab repellendus nemo ullam veniam. Sint, voluptatum omnis, quibusdam neque excepturi molestias incidunt quaerat accusamus et provident debitis ex itaque? Rem nisi optio totam eos in omnis eligendi maiores, est reiciendis, ad cum maxime fugiat saepe cupiditate error eius voluptatum?</p>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="#" class="btn btn-primary me-md-2"><i class="fas fa-check"></i></a>
                                <a href="#" class="btn btn-warning"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-lg">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-addon3">Bug 2</span>
                            <div class="form-control flex-grow-1">
                                <label for="basic-url">siky@gmail.com <span class="badge rounded-pill bg-primary text-white">Mahasiswa</span></label>
                            </div>
                            <div class="form-control text-end">
                                <label for="basic-url" style="color: #b4b4b4">Unsolved <i class="far fa-times-circle" style="color: #eb0000;"></i></label>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5><b>Minggu, 30 Juni 2024</b></h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi ut ab repellendus nemo ullam veniam. Sint, voluptatum omnis, quibusdam neque excepturi molestias incidunt quaerat accusamus et provident debitis ex itaque? Rem nisi optio totam eos in omnis eligendi maiores, est reiciendis, ad cum maxime fugiat saepe cupiditate error eius voluptatum?</p>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="#" class="btn btn-primary me-md-2"><i class="fas fa-check"></i></a>
                                <a href="#" class="btn btn-warning"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-lg">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-addon3">Bug 3</span>
                            <div class="form-control flex-grow-1">
                                <label for="basic-url">siky@gmail.com <span class="badge rounded-pill bg-primary text-white">Mahasiswa</span></label>
                            </div>
                            <div class="form-control text-end">
                                <label for="basic-url" style="color: #b4b4b4">Unsolved <i class="far fa-times-circle" style="color: #eb0000;"></i></label>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5><b>Minggu, 30 Juni 2024</b></h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi ut ab repellendus nemo ullam veniam. Sint, voluptatum omnis, quibusdam neque excepturi molestias incidunt quaerat accusamus et provident debitis ex itaque? Rem nisi optio totam eos in omnis eligendi maiores, est reiciendis, ad cum maxime fugiat saepe cupiditate error eius voluptatum?</p>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="#" class="btn btn-primary me-md-2"><i class="fas fa-check"></i></a>
                                <a href="#" class="btn btn-warning"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>

                    {{-- end --}}
                    
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
