<?php

use App\Models\CmsHelper as cms;
?>

@extends('layouts.master')

@php $header='form relate'; @endphp
@section('title',$header)

@section('custom-css-script')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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

                @php
                $random_name = array_rand($User, 1);
                @endphp


                <form action="{{ route('form.relate_insert') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">ชื่อ-นามสกุล</label>
                        <input type="text" name="name" value="{{ $User[$random_name] }}" class="form-control border-success text-bold" placeholder="ชื่อ-นามสกุล">
                    </div>

                    <div class="form-group">
                        <label for="organize">หน่วยงาน</label>
                        <select name="organize" class="form-control select2bs4 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                            @foreach($Organize as $val)
                            <option value="{{ $val->id }}">{{ $val->org_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">จังหวัด</label>
                        <select id="input_province" name="province" class="form-control custom-select select2bs4" onchange="showAmphoes()">
                            <option value="">กรุณาเลือกจังหวัด</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">อำเภอ</label>
                        <select id="input_amphoe" name="amphoe" class="form-control custom-select select2bs4" onchange="showDistricts()">
                            <option value="">กรุณาเลือกอำเภอ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">ตำบล</label>
                        <select id="input_district" name="tumbon" class="form-control custom-select select2bs4" onchange="showZipcode()">
                            <option value="">กรุณาเลือกตำบล</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">รหัสไปรษณีย์</label>
                        <input id="input_zipcode" name="zipcode" class="form-control" placeholder="รหัสไปรษณีย์" />
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success" style="width: 100px;">บันทึก</button>
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
                            <th>id</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>หน่วยงาน</th>
                            <th>ตำบล</th>
                            <th>อำเภอ</th>
                            <th>จังหวัด</th>
                            <th>รหัสไปรษณีย์</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($Relate as $val)
                        <tr>
                            <td class="text-center">{{ $val->id }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ cms::GetOrg($val->organize) }}</td>
                            <td>{{ cms::GetTumbon($val->tumbon) }}</td>
                            <td>{{ cms::GetAmphoe($val->amphoe) }}</td>
                            <td>{{ cms::GetProvince($val->province) }}</td>
                            <td>{{ $val->zipcode }}</td>
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
<!-- <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script> -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('custom-js')


<script>
    $(function() {
        $("#example1").DataTable({
            "oLanguage": {
                // "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Thai.json",
                "sEmptyTable": "ไม่มีข้อมูลในตาราง",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoThousands": ",",
                "sLengthMenu": "แสดง _MENU_ แถว",
                "sLoadingRecords": "กำลังโหลดข้อมูล...",
                "sProcessing": "กำลังดำเนินการ...",
                "sSearch": "ค้นหา: ",
                "sZeroRecords": "ไม่พบข้อมูล",
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "หน้าสุดท้าย"
                },
                "oAria": {
                    "sSortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                    "sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
                }
            },
            "responsive": true,
            "order": ['0', 'DESC'],
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>

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

@endsection