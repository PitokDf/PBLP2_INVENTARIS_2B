<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: sans-serif;
            position: relative;
            background: url('{{ public_path('asset/waterwark-pdf.png') }}') center no-repeat;
            background-size: 60%;
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
        @yield('content.data')
    </div>
</body>

</html>
