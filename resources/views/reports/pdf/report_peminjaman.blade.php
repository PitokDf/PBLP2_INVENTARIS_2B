@extends('reports.template.report')

@section('content.data')
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th style="text-align: center;">kode Peminjaman</th>
                <th style="text-align: center;">Nama Peminjam</th>
                <th style="text-align: center;">Kode Barang</th>
                <th style="text-align: center;">Nama Barang</th>
                <th style="text-align: center;">Banyak Pinjam</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->kode_peminjaman }}</td>
                    <td>{{ $item->user->mahasiswa ? $item->user->mahasiswa->nama . ' - M' : ($item->user->dosen ? $item->user->dosen->name . ' - D' : $item->user->username . ' - S') }}
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
