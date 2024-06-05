<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
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

        .bg-danger {
            background: red;
        }

        .text-white {
            color: white;
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
