@extends('layouts.content')
@section('title', 'Daftar Barang')
@section('modal')
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
                    url: "detail-barang/" + $(this).data('id'),
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
    <form action="" method="POST">
        @csrf
        <div class="mb-3">
            <label for="content" class="form-label">Masalah</label>
            <input type="text" class="form-control" name="content" id="content" aria-describedby="helpId" placeholder="" />
        </div>
        <div class="mb-3">
            <button class="btn btn-sm btn-primary">Send</button>
        </div>
    </form>
@endsection
