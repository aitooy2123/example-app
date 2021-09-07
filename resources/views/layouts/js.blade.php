<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- pace-progress -->
<script src="{{ asset('plugins/pace-progress/pace.min.js') }}"></script>

<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

@if ($msg = Session::get('Clear') )
<script>
    toastr.success('{{ $msg }}');
</script>
@elseif ($msg = Session::get('Truncate') )
<script>
    toastr.success('{{ $msg }}');
</script>
@endif

<a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
</a>