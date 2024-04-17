<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h3>Silahkan verifikasi email anda!</h3>
    <h3>Kirim Ulang Tautan Verifikasi</h3>

    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <div class="form-group">
            <input type="hidden" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}"
                required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Kirim Tautan Verifikasi</button>
        </div>
    </form>
    <a href="{{ route('logout') }}">Kembali</a>
</body>

</html>
