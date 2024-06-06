@extends('reports.template.report')

@section('content.data')
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Jumlah</th>
                <th>Posisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->code_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori->nama_kategori_barang }}</td>
                    <td class="{{ $item->quantity > 0 ? '' : 'bg-danger text-white' }}">{{ $item->quantity }}</td>
                    <td>{{ $item->posisi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
