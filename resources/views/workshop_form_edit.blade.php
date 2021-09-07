<?php

use App\Models\CmsHelper as cms;
?>
@extends('layouts.master')

@php $header='แก้ไขฟอร์มสำรวจ'; @endphp
@section('title',$header)

@section('custom-css-script')
<link rel="stylesheet" href="{{ asset('plugins/datepicker-thai/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

@endsection

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <li class="breadcrumb-item"><a href="{{ route('workshop.list') }}">รายการ</a></li>
                        <li class="breadcrumb-item active">{{ $header }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-warning">
                <h3 class="card-title">{{ $header }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">


                <form action="{{ route('workshop.form_update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" value="{{ $Edit->id }}" name="id">

                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-12">

                            <div class="form-group">
                                <label>วันที่บันทึก</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="date" value="{{ cms::DateThai($Edit->date)['dMY'] }}" class="form-control datepicker" data-target="#reservationdate" readonly>
                                    <div class="input-group-append" id="btn_date" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="">ชื่อสถานที่</label>
                                <input type="text" class="form-control" name="store_name" placeholder="ชื่อสถานที่" value="{{ $Edit->store_name }}" required>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">เลขที่</label>
                                <input type="text" class="form-control" name="store_no" placeholder="เลขที่" value="{{ $Edit->store_no }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">หมู่ที่</label>
                                <input type="text" class="form-control" name="store_moo" placeholder="หมู่ที่" value="{{ $Edit->store_moo }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">ตรอก/ซอย</label>
                                <input type="text" class="form-control" name="store_soi" placeholder="ตรอก/ซอย" value="{{ $Edit->store_soi }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">ถนน</label>
                                <input type="text" class="form-control" name="store_road" placeholder="ถนน" value="{{ $Edit->store_road }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">จังหวัด</label>
                                <select id="input_province1" class="form-control custom-select select2bs4" onchange="showAmphoes()" disabled>
                                    <option value="{{ $Edit->province }}">{{ cms::GetProvince($Edit->province) }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">อำเภอ</label>
                                <select id="input_amphoe1" class="form-control custom-select select2bs4" onchange="showDistricts()" disabled>
                                    <option value="{{ $Edit->amphoe }}">{{ cms::GetAmphoe($Edit->amphoe) }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">ตำบล</label>
                                <select id="input_district1" class="form-control custom-select select2bs4" onchange="showZipcode()" disabled>
                                    <option value="{{ $Edit->tumbon }}">{{ cms::GetTumbon($Edit->tumbon) }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">รหัสไปรษณีย์</label>
                                <input id="input_zipcode" class="form-control" value="{{ $Edit->zipcode }}" placeholder="รหัสไปรษณีย์" />
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">หมายเลขโทรศัพท์</label>
                                <input name="tel" class="form-control" value="{{ $Edit->tel }}" placeholder="หมายเลขโทรศัพท์" maxlength="10" />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Text Editor</label>
                                <textarea id="summernote" name="summernote">{{ $Edit->summernote }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                {!! $Edit->summernote !!}
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">ภาพ</label>
                                        <input type="file" class="form-control" name="image[]" id="" multiple accept=".jpg,.jpeg,.gif,.png">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <table class="table table-sm table-bordered table-striped">
                            <tr class="bg-gradient-dark">
                                <th class="text-center" width="120px">ภาพ</th>
                                <th>ชื่อไฟล์</th>
                                <th width="100px">ลบ</th>
                            </tr>

                            @foreach($Img as $val)
                            <tr>
                                <td>
                                    <a href="{{ asset('uploads/survey/'.$val->img_name) }}" data-fancybox="gallery" data-caption="Optional caption">
                                        <img src="{{ asset('uploads/survey/'.$val->img_name) }}" class="img-thumbnail" style="width: 100px;height:100px;object-fit: cover;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ asset('uploads/survey/'.$val->img_name) }}" data-fancybox="gallery" data-caption="Optional caption">
                                        {{ $val->img_name }}
                                    </a>
                                </td>
                                <td>

                                    <a href="{{ route('workshop.detail_delete_img',[
                                        'id'=>$val->id,
                                        'img_name'=>$val->img_name
                                        ]) }}" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>


                                </td>
                            </tr>
                            @endforeach
                        </table>


                    </div><!-- end row -->


            </div><!-- /.card-body -->
            <div class="card-footer text-right">
                <a href="{{ route('workshop.list') }}" class="btn btn-danger" style="width:100px">ย้อนกลับ</a>
                <button type="submit" class="btn btn-success" style="width:100px">บันทึก</button>
            </div>
            </form>
        </div><!-- /.card -->
    </section><!-- /.content -->
</div> <!-- Content Header (Page header) -->
@endsection

@section('custom-js-script')
<!-- <script type="text/javascript" src="{{ asset('plugins/datepicker-thai/js/bootstrap-datepicker.js') }}"></script> -->
<script src="{{ asset('plugins/datepicker-thai/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('plugins/datepicker-thai/js/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        console.log("HELLO");
        showProvinces();
    });

    function showProvinces() {
        //PARAMETERS
        var url = "{{ url('/') }}/api/province";
        var callback = function(result) {
            $("#input_province").empty();
            for (var i = 0; i < result.length; i++) {
                $("#input_province").append(
                    $('<option></option>')
                    .attr("value", "" + result[i].province_code)
                    .html("" + result[i].province)
                );
            }
            showAmphoes();
        };
        //CALL AJAX
        ajax(url, callback);
    }

    function showAmphoes() {
        //INPUT
        var province_code = $("#input_province").val();
        //PARAMETERS
        var url = "{{ url('/') }}/api/province/" + province_code + "/amphoe";
        var callback = function(result) {
            //console.log(result);
            $("#input_amphoe").empty();
            for (var i = 0; i < result.length; i++) {
                $("#input_amphoe").append(
                    $('<option></option>')
                    .attr("value", "" + result[i].amphoe_code)
                    .html("" + result[i].amphoe)
                );
            }
            showDistricts();
        };
        //CALL AJAX
        ajax(url, callback);
    }

    function showDistricts() {
        //INPUT
        var province_code = $("#input_province").val();
        var amphoe_code = $("#input_amphoe").val();
        //PARAMETERS
        var url = "{{ url('/') }}/api/province/" + province_code + "/amphoe/" + amphoe_code + "/district";
        var callback = function(result) {
            //console.log(result);
            $("#input_district").empty();
            for (var i = 0; i < result.length; i++) {
                $("#input_district").append(
                    $('<option></option>')
                    .attr("value", "" + result[i].district_code)
                    .html("" + result[i].district)
                );
            }
            showZipcode();
        };
        //CALL AJAX
        ajax(url, callback);
    }

    function showZipcode() {
        //INPUT
        var province_code = $("#input_province").val();
        var amphoe_code = $("#input_amphoe").val();
        var district_code = $("#input_district").val();
        //PARAMETERS
        var url = "{{ url('/') }}/api/province/" + province_code + "/amphoe/" + amphoe_code + "/district/" + district_code;
        var callback = function(result) {
            //console.log(result);
            for (var i = 0; i < result.length; i++) {
                $("#input_zipcode").val(result[i].zipcode);
            }
        };
        //CALL AJAX
        ajax(url, callback);
    }

    function ajax(url, callback) {
        $.ajax({
                "url": url,
                "type": "GET",
                "dataType": "json",
            })
            .done(callback); //END AJAX
    }
</script>

<script>
    $('.datepicker').datepicker({
        format: 'd MM yyyy',
        language: 'th-th',
        endDate: '0',
        todayHighlight: true,
        daysOfWeekHighlighted: '06',
        autoclose: true,
        // enableOnReadonly: true,
        thaiyear: true
    }).datepicker();
</script>

@if($msg = session()->get('Success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ $msg }}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@elseif($msg = session()->get('Error'))
<script>
    Swal.fire({
        icon: 'error',
        title: '{{ $msg }}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

<script>
    $('#summernote').summernote({
        placeholder: 'ทดสอบ Summernote ',
        tabsize: 2,
        height: 200
    });
</script>
@endsection