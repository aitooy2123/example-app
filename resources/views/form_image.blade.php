<?php

use App\Models\CmsHelper as cms;
use Carbon\Carbon;
?>

@extends('layouts.master')

@php $header='form image'; @endphp
@section('title',$header)

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">

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

                <form action="{{ route('form.image_insert') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    </div>


                    <div class="form-group">
                        <label for="">Image</label> (<span class="text-red text-bold">jpg,png,gif,jpeg ขนาดไม่เกิน 2MB</span>)
                        <div class="custom-file">
                            <input type="file" id="customFile" name="file" class="custom-file-input" accept=".jpg,.png,.gif,.jpeg">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>


                    <div class="text-right">
                        <button type="reset" class="btn btn-danger" style="width: 100px;">reset</button>
                        <button type="submit" class="btn btn-success" style="width: 100px;">save</button>
                    </div>
                </form>

            </div>
    </section>

    <section class="content">
        <div class="card card-outline card-info">
            <!-- <div class="card-header">รายละเอียด</div> -->
            <div class="card-body">

                <table id="example1" class="table table-striped table-sm">
                    <thead class="bg-gradient-gray">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="10%">pic</th>
                            <th>Filename</th>
                            <th width="20%">Download</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($file as $val)
                        <tr>
                            <td class="text-center">{{ $val->id }}</td>
                            <td>

                                @if(empty($val->img_path1))
                                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-thumbnail" width="100px" style="opacity: 0.4;">
                                @else
                                <a href="{{ asset('uploads/images/'.$val->img_path1) }}" data-toggle="lightbox" data-title="{{ $val->img_name }}">
                                    <img src="{{ asset('uploads/images/thumbnail/'.$val->img_path1) }}" class="img-thumbnail" width="100px">
                                </a>
                                @endif


                            </td>
                            <td><span class="text-bold">{{ $val->img_name }}</span>
                                <p class="mt-4">สร้างเมื่อ : {{ cms::DateThai($val->created_at) }}</p>
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ asset('uploads/images/'.$val->img_path1) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Public"><i class="fas fa-download"></i></a>
                                <a href="{{ route('form.image_download',['id'=>$val->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Stroage"><i class="fas fa-download"></i></a>
                                <form action="{{ route('form.image_delete') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $val->id }}">
                                    <input type="hidden" name="path1" value="{{ $val->img_path1 }}">
                                    <input type="hidden" name="path2" value="{{ $val->img_path2 }}">
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}""></script>
<script src=" {{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>

@endsection

@section('custom-js')
<script>
    $(function() {
        $(" #example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(function() {
        $('[data-toggle="tooltip" ]').tooltip()
    })
</script>
< script>
    $(function() {
    bsCustomFileInput.init();
    });
    </script>

    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>
    @endsection