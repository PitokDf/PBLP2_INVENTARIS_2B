@extends('layouts.content')
@section('title', 'Daftar Barang')
@section('modal')
    <div class="modal fade" id="detailBarang" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Detail Barang : <span class="text-dark" id="_barang"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Body</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptPages')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablebarang').DataTable();
            $('.detailBtn').on('click', function() {
                $('#detailBarang').modal('show')
                $.ajax({
                    type: "GET",
                    url: "/detail-barang/" + $(this).data('id'),
                    dataType: "json",
                    success: function(response) {
                        const data = response.data;
                        $('#_barang').text(
                            `${data.nama_barang} (${data.code_barang})`
                        );
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr)
                    }
                });
            });
            var clipboard = new ClipboardJS('.copyBtn', {
                text: function(trigger) {
                    return trigger.getAttribute('data-code');
                }
            });

            clipboard.on('success', function(e) {
                alert('Kode barang berhasil disalin: ' + e.text);
            });

            clipboard.on('error', function(e) {
                alert('Gagal menyalin kode barang.');
            });
        });
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">Daftar Barang Tersedia</h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-light btn-refresh" data-toggle="modal">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tablebarang" width="100%"
                                cellspacing="0">
                                <thead style="background-color: #2c3b42; color: #f6f6f6">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode barang</th>
                                        <th>Nama barang</th>
                                        <th>Kategori</th>
                                        <th>Merek/Type</th>
                                        <th>Stok</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="code-barang">{{ $item->code_barang }}</span> <button
                                                    class="btn btn-sm btn-secondary copyBtn"
                                                    data-code="{{ $item->code_barang }}"><i
                                                        class="fas fa-copy"></i></button>
                                            </td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->kategori->nama_kategori_barang }}</td>
                                            <td>{{ $item->merek->merk }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td><button class="btn btn-sm btn-info detailBtn"
                                                    data-id="{{ $item->id_barang }}"><i
                                                        class="fas fa-info-circle"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
