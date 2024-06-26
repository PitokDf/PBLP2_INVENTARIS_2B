@extends('admin.reports.template.report')

@section('content.data')
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Pemasok</th>
                <th>Tanggal Masuk</th>
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
                    <td>{{ $item->barang->code_barang ?? 'not found' }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'not found' }}</td>
                    <td>{{ $item->pemasok->nama ?? 'not found' }}</td>
                    <td>{{ $item->tanggal_masuk }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
