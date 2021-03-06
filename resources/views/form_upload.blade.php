@extends('layouts.master')

@php $header='form input'; @endphp
@section('title',$header)

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
@endsection

@section('custom-css')
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $header }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Example</a></li>
                        <li class="breadcrumb-item active">{{ $header }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header bg-gradient-info">
                <h3 class="card-title">{{ $header }}</h3>
                <!-- <div class="card-tools">
                    <button type="button" class="btn btn-default btn-tool" data-toggle="modal" data-target="#add">+ add</button>
                </div> -->
            </div>
            <div class="card-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($message = Session::get('Success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                <?php
                $title = [
                    '??????????????????????????????????????????????????????????????????????????????????????????????????? ????????????????????????????????????????????????????????????????????????',
                    '????????????????????????????????????????????? ??????????????????????????????????????????????????????????????????',
                    '????????????????????????????????????????????????????????????????????? ?????????????????????????????????????????????????????????????????????????????????????????????',
                    '?????????????????????????????????????????? ??????????????????????????????????????????????????????????????????????????????',
                    '??????????????????????????????????????????????????? ?????????????????????????????????????????????????????????????????????',
                    '???????????????????????????????????????????????? ????????????????????????????????????????????????????????????',
                    '????????????????????????..??????????????????????????????????????????????????????????????? ?????????????????????????????????????????????????????? ????????????????????????????????????????????????',
                    '?????????????????????????????????????????????????????????????????????????????????????????? ?????????????????????????????????????????? ????????????????????????????????????????????????????????????????????????????????? ?????????????????????????????????????????????????????????????????????',
                    '????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????',
                    '?????????????????????????????????????????????????????????????????????????????????',
                    '??????????????????????????????????????? ???????????????????????????????????????????????????',
                    '??????????????????????????????????????????????????????????????????????????? ??????????????????????????????????????????????????????????????????????????????????????????',
                    '???????????????????????????????????????????????????????????????????????????????????????????????????????????????',
                    '??????????????????????????? ???????????????????????????????????????'
                ];
                $random_name = array_rand($title, 1);
                ?>

                <form action="{{ route('form.upload_insert') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control text-bold" value="{{ $title[$random_name] }}" required>
                    </div>

                    <div class="form-group">
                        <label for="">File</label> (<span class="text-red text-bold">doc,docx,xls,xlsx,pdf ????????????????????? 2MB</span>)
                        <div class="custom-file">
                            <input type="file" id="customFile" name="file" class="custom-file-input" value="{{ old('file') }}" accept=".doc,.docx,.xls,.xlsx,.pdf" required>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>

                    <div class="text-right">
                        <!-- <button type="reset" class="btn btn-danger" style="width: 100px;">reset</button> -->
                        <button type="submit" class="btn btn-success" style="width: 100px;">save</button>
                    </div>
                </form>

            </div>
    </section>

    <!-- <section class="content">
        <div class="form-group">
            <div class="text-right">
                <a href="{{ route('form.upload_truncate') }}" class="btn btn-danger"><i class="fas fa-exclamation-triangle"></i> ?????????????????????????????????????????????</a>
            </div>
        </div>
    </section> -->

    <section class="content">
        <div class="card card-outline card-info">
            <!-- <div class="card-header">??????????????????????????????</div> -->
            <div class="card-body">

                <table id="example1" class="table table-striped table-sm table-bordered">
                    <thead class="bg-gradient-gray">
                        <tr>
                            <th width="1%">ID</th>
                            <th>Filename</th>
                            <th>Type</th>
                            <th width="20%">Download</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($file as $val)
                        <tr>
                            <td class="text-center">{{ $val->id }}</td>
                            <td>{{ $val->file_name }}</td>
                            <td class="text-center">

                                @if($val->file_type=='pdf') <i class="fas fa-file-pdf fa-2x text-red"></i>
                                @elseif($val->file_type=='doc' || $val->file_type=='docx') <i class="fas fa-file-word fa-2x text-blue"></i>
                                @elseif($val->file_type=='xls' || $val->file_type=='xlsx') <i class="fas fa-file-excel fa-2x text-green"></i>
                                @endif
                                <!-- {{ $val->file_type }} -->
                            </td>
                            <td class="text-nowrap text-center">
                                <a href="{{ asset('uploads/files/'.$val->file_path1 ) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Public"><i class="fas fa-download"></i></a>
                                <a href="{{ route('form.upload_download',['id'=>$val->id]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Stroage" style="width: 33px;"><i class="fas fa-download"></i></a>
                                <form action="{{ route('form.upload_delete') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $val->id }}">
                                    <input type="hidden" name="path1" value="{{ $val->file_path1 }}">
                                    <input type="hidden" name="path2" value="{{ $val->file_path2 }}">
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" style="width: 33px;"><i class="fas fa-trash-alt"></i></button>
                                </form>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>


            </div>
        </div>
    </section>



</div>

@endsection

@section('custom-js-script')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
@endsection

@section('custom-js')
<script>
    $(function() {
        $(" #example1").DataTable({
            "oLanguage": {
                "sEmptyTable": "??????????????????????????????????????????????????????",
                "sInfo": "???????????? _START_ ????????? _END_ ????????? _TOTAL_ ?????????",
                "sInfoEmpty": "???????????? 0 ????????? 0 ????????? 0 ?????????",
                "sInfoFiltered": "(?????????????????????????????? _MAX_ ??????????????????)",
                "sInfoThousands": ",",
                "sLengthMenu": "???????????? _MENU_ ?????????",
                "sLoadingRecords": "?????????????????????????????????????????????...",
                "sProcessing": "??????????????????????????????????????????...",
                "sSearch": "???????????????: ",
                "sZeroRecords": "?????????????????????????????????",
                "oPaginate": {
                    "sFirst": "?????????????????????",
                    "sPrevious": "????????????????????????",
                    "sNext": "???????????????",
                    "sLast": "?????????????????????????????????"
                },
                "oAria": {
                    "sSortAscending": ": ????????????????????????????????????????????????????????????????????????????????????????????????????????????",
                    "sSortDescending": ": ????????????????????????????????????????????????????????????????????????????????????????????????????????????"
                }
            },
            "order": ['0', 'DESC'],
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(function() {
        $('[data-toggle="tooltip" ]').tooltip()

        bsCustomFileInput.init();
    });
</script>
@endsection