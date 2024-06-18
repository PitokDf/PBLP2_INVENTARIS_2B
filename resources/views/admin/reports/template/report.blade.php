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
            background: rgba(0, 31, 204, 0.5);
            text: white;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .bg-danger {
            background: red;
        }

        .text-white {
            color: white;
        }

        .bg-warning {
            background: rgb(255, 230, 0);
            color: rgb(0, 0, 0);
        }

        .mb-3 {
            margin-bottom: 30px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .m-0 {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mb-3">
            <h1 class="text-capitalize m-0">{{ $header }}</h1>
            <h4 class="h6">{{ $time }} - PBLP2 Inventaris Labor TI</h4>
        </div>
    </div>
    <div class="main">
        @yield('content.data')
    </div>
</body>

</html>
