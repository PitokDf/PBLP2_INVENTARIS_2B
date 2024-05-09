<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - PBL P2</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/customBoostrap.css') }}">

</head>

<body class="bg-custom-light">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    @if (session('sukses'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('sukses') }}
                                        </div>
                                        <script>
                                            // Menjalankan kode setelah jeda waktu 1000 milidetik (1 detik)
                                            setTimeout(() => {
                                                // Tambahkan kode yang ingin Anda jalankan di sini
                                                window.location = "dashboard"
                                            }, 1000);
                                        </script>
                                    @endif
                                    @if (session('gagal'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('gagal') }}
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if (session('status'))
                                        <div class="alert alert-info">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form class="user" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email"
                                                name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" id="password" name="password"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('forgotpass') }}">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('logged'))
        <script>
            function showAlert() {
                Swal.fire({
                    title: "Opss..",
                    text: "Anda sudah login pada perangkat lain!.",
                    icon: "warning",
                    confirmButtonText: "Yes"
                });
            }
            showAlert();
        </script>
    @endif
    <script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js') }}">
    </script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
