<!-- Bootstrap core JavaScript-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery.easing.min.js"></script>
<!-- Core plugin JavaScript-->
<!-- Custom scripts for all pages-->
<script src="vendor/startbootstrap/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@vite(['resources/js/reloadTable.js', 'resources/js/setupAjax.js', 'resources/js/preview.js'])
@if (auth()->user()->role == '1')
    @vite(['resources/js/activity_log.js'])
@endif
{{-- script per pages --}}
@yield('scriptPages')
@if (auth()->user()->role != '1')
    @vite(['resources/js/bug_report.js'])
@endif
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
