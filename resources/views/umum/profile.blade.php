@extends('layouts.content')
@section('title', 'Daftar Barang')
@section('scriptPages')
    <script>
        $('#tablebarang').DataTable();
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->

                <!-- Card Body -->
                <div class="card-body">
                    .tr
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="container">

                    <div class="mb-3 mt-3">
                        <label for="">Nama</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        </div>
                        <label for="">NIP</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        </div>
                        <label for="">Jabatan</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        </div>
                        <label for="">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        </div>
                        <label for="">No. Telepon</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        </div>

                    </div>
                </div>


                <!-- Card Body -->
                <div class="card-body">

                </div>
            </div>
        </div>

    </div>
@endsection
