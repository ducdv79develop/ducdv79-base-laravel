<!-- use library plugin css -->
@section('usePluginsCss')
    @if(isset($jqvmap) && $jqvmap)
        <!-- jqvmap -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
    @endif
    @if(isset($datetimepicker) && $datetimepicker)
        <!-- dateRangePicker -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    @endif
    @if(isset($summernote) && $summernote)
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    @endif
    @if(isset($overlayScrollbars) && $overlayScrollbars)
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    @endif
    @if(isset($fullcalendar) && $fullcalendar)
        <!-- fullcalendar -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/fullcalendar/main.min.css') }}">
    @endif
    @if(isset($dropzone) && $dropzone)
        <!-- dropzone -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/min/dropzone.min.css') }}">
    @endif
    @if(isset($tempusdominus) && $tempusdominus)
        <!-- tempusdominus -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    @endif
    @if(isset($croppie) && $croppie)
        <!-- croppie -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/croppie/croppie.css') }}">
    @endif
    @if(isset($datatables) && $datatables)
        <!-- datatables -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endif
    @if(isset($select2) && $select2)
        <!-- select2 -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
    @endif
    @if(isset($treegrid) && $treegrid)
        <!-- select2 -->
        <script src="{{ asset('admin/plugins/treegrid/jquery.treegrid.min.js') }}"></script>
    @endif
@stop

<!-- Use library plugin js -->
@section('usePluginsJs')
    @if(isset($jqvmap) && $jqvmap)
        <!-- jqvmap -->
        <script src="{{ asset('admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    @endif
    @if(isset($datetimepicker) && $datetimepicker)
        <!-- dateRangePicker -->
        <script src="{{ asset('admin/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    @endif
    @if(isset($summernote) && $summernote)
        <!-- summernote -->
        <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    @endif
    @if(isset($overlayScrollbars) && $overlayScrollbars)
        <!-- overlayScrollbars -->
        <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    @endif
    @if(isset($chart) && $chart)
        <!-- chart -->
        <script src="{{ asset('admin/plugins/sparklines/sparkline.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    @endif
    @if(isset($validation) && $validation)
        <!-- validation -->
        <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    @endif
    @if(isset($fullcalendar) && $fullcalendar)
        <!-- fullcalendar -->
        <script src="{{ asset('admin/plugins/fullcalendar/main.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/fullcalendar/locales/vi.js') }}"></script>
    @endif
    @if(isset($dropzone) && $dropzone)
        <!-- dropzone -->
        <script src="{{ asset('admin/plugins/dropzone/min/dropzone.min.js') }}"></script>
    @endif
    @if(isset($tempusdominus) && $tempusdominus)
        <!-- tempusdominus -->
        <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    @endif
    @if(isset($croppie) && $croppie)
        <!-- croppie -->
        <script src="{{ asset('admin/plugins/croppie/croppie.min.js') }}"></script>
    @endif
    @if(isset($datatables) && $datatables)
        <!-- datatables -->
        <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    @endif
    @if(isset($moment) && $moment)
        <!-- moment -->
        <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    @endif
    @if(isset($select2) && $select2)
        <!-- select2 -->
        <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    @endif
    @if(isset($treegrid) && $treegrid)
        <!-- select2 -->
        <script src="{{ asset('admin/plugins/treegrid/jquery.treegrid.min.js') }}"></script>
    @endif
@stop
