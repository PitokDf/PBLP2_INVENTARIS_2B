<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Helper Command For Laravel</title>
    <link rel="stylesheet" href="/css/helper/style.css">
</head>

<body>
    <div class="animasi">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="container">
        <div class="content">
            <div class="title">Command Helper</div>
            <p>php artisan tidak perlu diketikan</p>
            <form action="{{ route('helper.exec') }}" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="command" class="command" placeholder="type a command artisan">
                <button type="submit">exec</button>
            </form>
            <p class="output">
                @if (!empty($response))
                    {{ $response }}
                @endif
            </p>
        </div>
    </div>
</body>

</html>
