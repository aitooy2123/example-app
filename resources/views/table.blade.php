@extends('layouts.master')

@php $header='จังหวัด'; @endphp
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
        </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">

        <div class="card">
            <div class="card-header bg-gradient-info">
                <h5 class="card-title text-bold my-2">รายละเอียด</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#Add"><i class="fas fa-plus mr-2"></i>เพิ่มรายการ</button>
                </div>
            </div>
            <div class="card-body">

                @if(session()->has('Success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ session()->get('Success') }}</strong>
                </div>
                @elseif(session()->has('Error'))
                <div class="alert alert-warning" role="alert">
                    <strong>{{ session()->get('Error') }}</strong>
                </div>
                @endif

                <table id="example1" class="table table-bordered table-striped table-sm dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                    <thead>
                        <tr class="text-center">
                            <th>รหัส</th>
                            <th>จังหวัด</th>
                            <th>อำเภอ</th>
                            <th>ตำบล</th>
                            <th>รหัสไปรษณีย์</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <td class="text-center">{{ $val->id }}</td>
                            <td>{{ $val->province }}</td>
                            <td>{{ $val->amphoe }}</td>
                            <td>{{ $val->district }}</td>
                            <td class="text-center">{{ $val->zipcode }}</td>
                            <td class="text-center">
                                <a href="{{ route('table_edit',['id'=>$val->id]) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไข"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('table_delete',['id'=>$val->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="ลบ"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- /.card-body -->
            </div>

    </section>
    <!-- /.content -->
</div> <!-- Content Header (Page header) -->


<!-- Modal -->
<div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h5 class="modal-title">เพิ่มรายการ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('table_insert') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">จังหวัด</label>
                        <input type="text" name="province" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">ตำบล</label>
                        <input type="text" name="district" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">อำเภอ</label>
                        <input type="text" name="amphoe" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">รหัสไปรษณีย์</label>
                        <input type="text" name="zipcode" class="form-control" maxlength="5" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="sumbit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
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