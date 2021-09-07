<?php

use App\Models\CmsHelper as cms;
?>


@extends('layouts.master')

@php $header='รายการสำรวจ'; @endphp
@section('title',$header)

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

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


                <table class="table table-striped table-sm table-bordered" id="example1">
                    <thead class="">
                        <tr>
                            <th width="10%">รหัส</th>
                            <th>ชื่อสถานที่</th>
                            <th>ตำบล</th>
                            <th>อำเภอ</th>
                            <th>จังหวัด</th>
                            <th width="10%">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($survey as $val)
                        <tr>
                            <td class="text-center">{{ $val->id}}</td>
                            <td class="">{{ $val->store_name}}</td>
                            <td>{{ cms::GetTumbon($val->tumbon) }}</td>
                            <td>{{ cms::GetAmphoe($val->amphoe) }}</td>
                            <td>{{ cms::GetProvince($val->province) }}</td>
                            <td class="text-nowrap text-center">
                                <a href="{{ route('workshop.detail',['id'=>$val->id]) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="ดู"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('workshop.form_edit',['id'=>$val->id]) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไข"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('workshop.form_delete') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" value="{{ $val->id }}" name="id">
                                    <input type="hidden" value="{{ $val->img_name }}" name="img_name">
                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="ลบ"><i class="fas fa-trash-alt"></i></button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Footer
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div> <!-- Content Header (Page header) -->
@endsection

@section('custom-js-script')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('custom-js')

@if($msg = session()->get('Success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ $msg }}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

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
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection