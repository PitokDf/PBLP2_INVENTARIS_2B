<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') - PBL P2</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    {{-- css boostrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/dataTables.css') }}" rel="stylesheet">

    {{-- css datatales --}}
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css">

    <link
        href="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/datatables/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/customBoostrap.css') }}">
</head>
