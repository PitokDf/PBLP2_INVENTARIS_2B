<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
</script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js') }}">
</script>
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script> --}}

<!-- Custom scripts for all pages-->
<script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/chart.js/Chart.min.js') }}"></script> --}}

{{-- script dattaables --}}
<script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/datatables/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('vendors/startbootstrap-sb-admin-2-gh-pages/vendor/datatables/dataTables.bootstrap4.min.js') }}">
</script>

{{-- script sweet allert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/reloadTable.js') }}"></script>
<script src="{{ asset('js/setupAjax.js') }}"></script>
<script src="{{ asset('js/preview.js') }}"></script>
@if (auth()->user()->role == '1')
    <script src="{{ asset('js/activity/log.js') }}"></script>
@endif

{{-- script per pages --}}
@yield('scriptPages')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
