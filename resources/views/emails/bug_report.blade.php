<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bug</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #444;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Bug Baru</h1>
        <div class="deskripsi">
            <p>pelapor : {{ $bugReport->pelapor }}</p>
            <p>email : {{ $bugReport->email }}</p>
        </div>
        <p>Deskripsi : {{ $bugReport->description }}</p>
    </div>
</body>

</html>
