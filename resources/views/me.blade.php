<!doctype html>
<html lang="en">

<head>
    <title>Copy Right To Me</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main class="container d-flex justify-content-center" style="height: 100vh; align-items: center">
        @if (empty($data))
            <div class="card shadow border-0 d-flex justify-content-center">
                <div class="card-body">
                    <form action="{{ route('copyrighttome.store') }}" method="post">
                        @csrf
                        <button class="btn btn-sm btn-warning">Claim Copyright</button>
                    </form>
                </div>
            </div>
        @else
            <div class="card shadow border-0">
                <div class="card-body gap-3">
                    {!! $data->copyrighttome
                        ? '<div class="alert alert-success" role="alert">this website is <strong>Aktif</strong></div>'
                        : '<div class="alert alert-danger" role="alert">this website is <strong>Non Aktif</strong></div>' !!}
                    <div class="d-flex gap-2 justify-content-center">
                        <form action="copyrighttome/{{ $data->id }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-sm btn-success">Aktiffed</button>
                        </form>
                        <form action="copyrighttome/{{ $data->id }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="0">
                            <button type="submit" class="btn btn-sm btn-danger">Deaktiffed</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </main>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
