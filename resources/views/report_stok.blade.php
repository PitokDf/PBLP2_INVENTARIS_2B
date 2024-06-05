<!DOCTYPE html>
<html>

<head>
    <title>test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        thead {
            background: rgba(0, 194, 120, 0.5);
            text: white;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mt-3">
            <h2 class="h2">{{ $header }}</h2>
            <h5 class="h6">{{ $time }}</h5>
        </div>
    </div>
    <div class="main">
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
                @empty($data)
                    <tr>
                        <td colspan="9">
                            Tidak ada Data!
                        </td>
                    </tr>
                @endempty
                @foreach ($data as $item)
                    <tr>
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
                        <td class="{{ $item->quantity == 0 ? 'bg-danger text-white' : '' }}">
                            {{ $item->quantity }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
