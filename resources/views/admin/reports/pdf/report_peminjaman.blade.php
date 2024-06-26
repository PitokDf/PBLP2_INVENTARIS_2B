@extends('admin.reports.template.report')

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
            @if (count($data) == 0)
                <tr>
                    <td colspan="6" style="text-align: center;">Data kosong</td>
                </tr>
            @endif
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->kode_peminjaman }}</td>
                    <td>{{ $item->user ? ($item->user->mahasiswa ? $item->user->mahasiswa->nama : ($item->user->dosen ? $item->user->dosen->name : $item->user->username . ' - S')) : 'not found' }}
                    </td>
                    <td>{{ $item->barang->code_barang ?? 'not found' }}</td>
                    <td>{{ $item->barang->nama_barang ?? 'not found' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->tgl_pengembalian ? 'Sudah Dikembalikan' : 'Belum Dikembalikan' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
