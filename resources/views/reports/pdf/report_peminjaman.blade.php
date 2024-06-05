@extends('reports.template.report')

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
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->barang->code_barang ? $item->user->mahasiswa->nama . ' - M' : ($item->user->dosen ? $item->user->dosen->name . ' - D' : $item->user->username . ' - S') }}
                    </td>
                    <td>{{ $item->barang->code_barang }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->tgl_pengembalian ? 'Sudah Dikembalikan' : 'Belum Dikembalikan' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
