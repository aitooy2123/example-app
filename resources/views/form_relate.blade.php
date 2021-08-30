@extends('layouts.master')

@php $header='form relate'; @endphp
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


                <form action="{{ route('form.relate_insert') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">ชื่อ-นามสกุล</label>
                        <input type="text" name="name" class="form-control" placeholder="ชื่อ-นามสกุล">
                    </div>
                    <div class="form-group">
                        <label for="">หน่วยงาน</label>
                        <input type="text" name="organize" class="form-control" placeholder="ที่อยู่">
                    </div>
                    <div class="form-group">
                        <label for="">จังหวัด</label>
                        <select id="input_province" class="form-control custom-select" onchange="showAmphoes()">
                            <option value="">กรุณาเลือกจังหวัด</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">อำเภอ</label>
                        <select id="input_amphoe" class="form-control custom-select" onchange="showDistricts()">
                            <option value="">กรุณาเลือกอำเภอ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">ตำบล</label>
                        <select id="input_district" class="form-control custom-select" onchange="showZipcode()">
                            <option value="">กรุณาเลือกตำบล</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">รหัสไปรษณีย์</label>
                        <input id="input_zipcode" class="form-control" placeholder="รหัสไปรษณีย์" />
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
                            <th>ดำเภอ</th>
                            <th>จังหวัด</th>
                            <th>รหัสไปรษณีย์</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

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
@endsection

@section('custom-js')
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection