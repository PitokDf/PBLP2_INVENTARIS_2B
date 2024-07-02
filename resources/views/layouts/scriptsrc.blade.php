<!-- Bootstrap core JavaScript-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="/vendor/jquery.easing.min.js"></script>
<!-- Core plugin JavaScript-->
<!-- Custom scripts for all pages-->
<script src="/vendor/startbootstrap/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
</script>

{{-- script sweet allert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="/js/reloadTable.js"></script>
<script src="/js/setupAjax.js"></script>
<script src="/js/preview.js"></script>
@if (auth()->user()->role == '1')
    <script src="/js/activity/log.js"></script>
@endif
{{-- script per pages --}}
@yield('scriptPages')
@if (auth()->user()->role != '1')
    <script src="/js/bug_report.js"></script>
@endif
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
