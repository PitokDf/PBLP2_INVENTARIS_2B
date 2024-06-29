<!DOCTYPE html>
<html lang="en">

<head>
    {{-- @section('title', 'index2') --}}
    @include('layouts.head')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                @include('layouts.topnav')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                    <div id="alert-section"></div>
                    <!-- Logout Modal-->
                    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Select "Logout" below if you are ready to end your current
                                    session.</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button"
                                        data-dismiss="modal">Cancel</button>
                                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user()->role != '1')
                        <div class="bug-btn"><i class="fas fa-bug"></i></div>

                        <div class="modal fade" id="modalbugreport" tabindex="-1" data-bs-backdrop="static"
                            data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitleId">
                                            Laporkan Masalah Sistem
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Deskripsi</label>
                                            <textarea name="description" id="description" class="form-control" cols="20" rows="10"
                                                placeholder="jelaskan bug yang kamu alami"></textarea>
                                            <small id="desc_error" class="form-text text-danger"></small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Captcha</label>
                                            <div id="captcha_area" class="mb-2"></div>
                                            <input type="number" class="form-control" name="captcha" id="captcha">
                                            <small id="captcha_error" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm"
                                            id="send_bug_report">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Optional: Place to the bottom of scripts -->
                        <script>
                            const myModal = new bootstrap.Modal(
                                document.getElementById("modalId"),
                                options,
                            );
                        </script>
                    @endif
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    @yield('modal')

    @include('layouts.scriptsrc')
    <script>
        $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
            if (jqxhr.status === 401 || jqxhr.status === 419) {
                $('#alert-section').html(
                    `<span class="toast-cs">Sesi Anda telah habis, silahkan <a href="/login" style="margin-left: 3px; margin-right: 3px; color:inherit;"> login </a> kembali!.</span>`
                );
            }
        });
    </script>
</body>

</html>
