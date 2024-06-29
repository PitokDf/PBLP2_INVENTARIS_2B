<!-- Bootstrap core JavaScript-->
<script src="/vendors/startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js"></script>
<script src="/vendors/startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<!-- Core plugin JavaScript-->
<script src="/vendors/startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script> --}}

<!-- Custom scripts for all pages-->
<script src="/vendors/startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script src="/vendors/startbootstrap-sb-admin-2-gh-pages/vendor/chart.js/Chart.min.js"></script> --}}

{{-- script dattaables --}}
<script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>

<!-- Page level plugins -->
<script src="/vendors/startbootstrap-sb-admin-2-gh-pages/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendors/startbootstrap-sb-admin-2-gh-pages/vendor/datatables/dataTables.bootstrap4.min.js">
    type = "text/javascript" >
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
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
