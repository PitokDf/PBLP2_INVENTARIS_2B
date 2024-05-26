<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
    <style>
        .container {
            display: grid;
            place-items: center;
        }

        .alert {
            padding: 6px;
            border-radius: 6px;
        }

        .mb-1 {
            margin-bottom: 10px;
        }

        .alert-success {
            border: 1px solid rgb(0, 233, 0);
            background: rgba(0, 128, 0, 0.233);
            color: rgb(0, 94, 0);
        }

        .btn {
            border: none;
            text-transform: capitalize;
            padding: 10px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-primary {
            position: relative;
            background: #009f32;
            color: white;
            cursor: pointer;
        }

        .btn-primary:hover {
            transition: all ease-out .25s;
            transform: translate(-4px, -4px);
        }

        .btn-primary::before {
            position: absolute;
            content: '';
            border-radius: 6px;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -1;
            transition: transform ease-out .25s;
        }

        .btn-primary:hover::before {
            transform: translate(4px, 4px);
            outline: 2px solid #009f32;
        }

        .card {
            font-family: sans-serif;
            text-align: center;
            position: relative;
            top: 200px;
            padding: 16px;
            width: 380px;
            background-color: rgba(255, 255, 255, 0.514);
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(128, 128, 128, 0.644);
        }

        .h1 {
            font-size: 20px;
        }

        .h2 {
            font-size: 18px;
        }

        .text-gray {
            color: rgb(84, 84, 84);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            <h3 class="h1">Silahkan verifikasi email anda!</h3>
            <p class="text-gray">Tidak menerima tautan verifikasi?<br>Kirim ulang tautan verifikasi dengan mengklik
                tombol dibawah.</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="form-group">
                    <input type="hidden" class="form-control" id="email" name="email"
                        value="{{ auth()->user()->email }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Kirim Ulang</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
