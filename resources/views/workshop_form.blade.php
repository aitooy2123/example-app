<?php

use App\Models\CmsHelper as cms;
?>
@extends('layouts.master')

@php $header='ฟอร์มสำรวจ'; @endphp
@section('title',$header)

@section('custom-css-script')
<link rel="stylesheet" href="{{ asset('plugins/datepicker-thai/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .ui-sortable-placeholder {
        border: 1px dashed black !important;
        visibility: visible !important;
        background: #eeeeee78 !important;
    }

    .ui-sortable-placeholder * {
        visibility: hidden;
    }

    .RearangeBox.dragElemThumbnail {
        opacity: 0.6;
    }

    .RearangeBox {
        width: 180px;
        height: 240px;
        padding: 10px 5px;
        cursor: all-scroll;
        float: left;
        border: 1px solid #9E9E9E;
        /* font-family: sans-serif; */
        display: inline-block;
        margin: 5px !important;
        text-align: center;
        /* color: #673ab7; */
        /* background: #000; */
        color: rgb(34, 34, 34);
        background: #f3f2f1;    
    }

    .IMGthumbnail {
        max-width: 168px;
        height: 220px;
        margin: auto;
        background-color: #ececec;
        padding: 2px;
        border: none;
    }

    .IMGthumbnail img {
        max-width: 100%;
        max-height: 100%;
    }

    .imgThumbContainer {
        margin: 4px;
        border: solid;
        display: inline-block;
        justify-content: center;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.14);
        -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0 0 4px 0 rgba(0, 0, 0, .2);
    }

    .imgThumbContainer>.imgName {
        text-align: center;
        padding: 2px 6px;
        margin-top: 4px;
        font-size: 10px;
        height: 15px;
        overflow: hidden;
    }

    .imgThumbContainer>.imgRemoveBtn {
        position: absolute;
        color: red;
        right: 2px;
        top: 2px;
        cursor: pointer;
        display: none;
    }

    .RearangeBox:hover>.imgRemoveBtn {
        display: block;
    }
</style>
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
                        <!-- <li class="breadcrumb-item"><a href="#">{{ $header }}</a></li> -->
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
            <div class="card-header bg-gradient-info">
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


                <form action="{{ route('workshop.form_insert') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-12">

                            <div class="form-group">
                                <label>วันที่บันทึก</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <!-- <input class="input-medium form-control datepicker" type="text" name="date" data-provide="datepicker" data-date-language="th-th"> -->

                                    <input type="text" name="date" class="form-control datepicker" data-target="#reservationdate" readonly>
                                    <div class="input-group-append" id="btn_date" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="">ชื่อสถานที่</label>
                                <input type="text" class="form-control" name="store_name" placeholder="ชื่อสถานที่" required>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">เลขที่</label>
                                <input type="text" class="form-control" name="store_no" placeholder="เลขที่">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">หมู่ที่</label>
                                <input type="text" class="form-control" name="store_moo" placeholder="หมู่ที่">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">ตรอก/ซอย</label>
                                <input type="text" class="form-control" name="store_soi" placeholder="ตรอก/ซอย">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">ถนน</label>
                                <input type="text" class="form-control" name="store_road" placeholder="ถนน">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">จังหวัด</label>
                                <select id="input_province" name="province" class="form-control custom-select select2bs4" onchange="showAmphoes()">
                                    <option value="">กรุณาเลือกจังหวัด</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">อำเภอ</label>
                                <select id="input_amphoe" name="amphoe" class="form-control custom-select select2bs4" onchange="showDistricts()">
                                    <option value="">กรุณาเลือกอำเภอ</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">ตำบล</label>
                                <select id="input_district" name="tumbon" class="form-control custom-select select2bs4" onchange="showZipcode()">
                                    <option value="">กรุณาเลือกตำบล</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">รหัสไปรษณีย์</label>
                                <input id="input_zipcode" name="zipcode" class="form-control" placeholder="รหัสไปรษณีย์" />
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="">หมายเลขโทรศัพท์</label>
                                <input name="tel" class="form-control" placeholder="หมายเลขโทรศัพท์" maxlength="10" />
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Text Editor</label>
                                <textarea id="summernote" name="summernote"></textarea>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <label for="">ภาพ</label>
                                <input type="file" id="files" class="form-control" name="image[]" id="" multiple accept=".jpg,.jpeg,.gif,.png">
                            </div>
                        </div>

                        <div style='padding:14px; margin:auto' ;>
                            <div id="sortableImgThumbnailPreview"></div>
                        </div>

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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('plugins/datepicker-thai/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('plugins/datepicker-thai/js/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>
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
    }).datepicker("setDate", "0");
</script>

@if($msg = session()->get('Error'))
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

<script>
    $(function() {
        $("#sortableImgThumbnailPreview").sortable({
            connectWith: ".RearangeBox",


            start: function(event, ui) {
                $(ui.item).addClass("dragElemThumbnail");
                ui.placeholder.height(ui.item.height());

            },
            stop: function(event, ui) {
                $(ui.item).removeClass("dragElemThumbnail");
            }
        });
        $("#sortableImgThumbnailPreview").disableSelection();
    });




    document.getElementById('files').addEventListener('change', handleFileSelect, false);

    function handleFileSelect(evt) {

        var files = evt.target.files;
        var output = document.getElementById("sortableImgThumbnailPreview");

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    var imgThumbnailElem = "<div class='RearangeBox imgThumbContainer'><i class='material-icons imgRemoveBtn' onclick='removeThumbnailIMG(this)'>cancel</i><div class='IMGthumbnail' ><img  src='" + e.target.result + "'" + "title='" + theFile.name + "'/></div><div class='imgName'>" + theFile.name + "</div></div>";

                    output.innerHTML = output.innerHTML + imgThumbnailElem;

                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }

    function removeThumbnailIMG(elm) {
        elm.parentNode.outerHTML = '';
    }
</script>
@endsection