@extends('admin.reports.template.report')

@section('content.data')
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Penerima</th>
                <th>Tanggal Keluar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) == 0)
                <tr>
                    <td colspan="6" style="text-align: center;">Data kosong</td>
                </tr>
            @endif
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->barang->code_barang }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->user->username }}</td>
                    <td>{{ $item->tgl_keluar }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
