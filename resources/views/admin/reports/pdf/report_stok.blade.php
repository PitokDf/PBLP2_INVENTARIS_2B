@extends('admin.reports.template.report')

@section('content.data')
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th style="text-align: center;" rowspan="2">No</th>
                <th rowspan="2" style="text-align: center;">Kode</th>
                <th rowspan="2" style="text-align: center;">Nama</th>
                <th rowspan="2" style="text-align: center;">Kategori</th>
                <th colspan="3" style="text-align: center;">Keterangan</th>
            </tr>
            <tr>
                <th style="text-align: center;">tersedia</th>
                <th style="text-align: center;">dipinjam</th>
                <th style="text-align: center;">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr
                    class="{{ $item->quantity == 0 ? 'bg-danger text-white' : ($item->quantity <= 15 ? 'bg-warning' : '') }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->code_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori->nama_kategori_barang }}</td>
                    <td>
                        {{ $item->quantity + $item->peminjaman->sum('jumlah') }}
                    </td>

                    <td>
                        {{ $item->peminjaman->sum('jumlah') != 0 ? $item->peminjaman->sum('jumlah') : '~' }}
                    </td>
                    <td>
                        {{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
