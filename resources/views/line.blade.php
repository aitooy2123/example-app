@extends('layouts.master')

@php $header='Line'; @endphp
@section('title', $header)

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

            <button class="btn btn-tool btn-default" data-toggle="modal" data-target="#AddModal2"><i class="fa fa-plus" aria-hidden="true"></i> ส่งด่วน</button>
            <button class="btn btn-tool btn-default" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่มข้อมูล</button>
          </div>

        </div>
        <div class="card-body">

          <table class="table table-striped" id="example1">
            <thead>
              <tr>
                <th>id</th>
                <th>title</th>
                <th>token</th>
                <th>message</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($line as $val)
                <tr>
                  <td>{{ $val->id }}</td>
                  <td>{{ $val->title }}</td>
                  <td>{{ $val->token }}</td>
                  <td>{{ $val->message }}</td>
                  <td>
                    <form action="{{ route('line_send') }}" method="POST">
                      @csrf
                      <input type="hidden" name="token" value="{{ $val->token }}">
                      <input type="hidden" name="message" value="{{ $val->message }}">
                      <input type="hidden" name="sticker" value="13">
                      <button type="submit" class="btn btn-success btn-sm">Send</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div><!-- /.card-body -->
      </div><!-- /.card -->

    </section><!-- /.content -->
  </div>
  <!-- Content Header (Page header) -->


  <!-- Modal -->
  <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-gradient-info">
          <h5 class="modal-title">{{ $header }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">

            <form action="{{ route('line_insert') }}" method="POST">
              @csrf

              <div class="form-group">
                <label for="">Title</label>
                <input type="text" class="form-control" name="title">
              </div>

              <div class="form-group">
                <label for="">Sticker</label>
                <select name="sticker" class="form-control">
                  <option value="1">หลับ</option>
                  <option value="2">ยิ้ม</option>
                  <option value="3">ตกใจ</option>
                </select>
              </div>

              <div class="form-group">
                <label for="">Line Token</label>
                <input type="text" class="form-control" name="token">
              </div>

              <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" class="form-control" rows="3"></textarea>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="AddModal2" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-gradient-info">
          <h5 class="modal-title">{{ $header }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">

            <form action="{{ route('line_send') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="">Title</label>
                <input type="text" class="form-control" name="title" value="example-app">
              </div>

              <div class="form-group">
                <label for="">Sticker</label>
                <select name="sticker" class="form-control">
                  <option value="1">หลับ</option>
                  <option value="2">ยิ้ม</option>
                  <option value="3">ตกใจ</option>
                </select>
              </div>

              <div class="form-group">
                <label for="">Line Token</label>
                <input type="text" class="form-control" name="token" value="PmhpXxkY7sUL6OSZG3PPxnn31EhUa1cSK8ouVYdYimf	">
              </div>

              <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" class="form-control" rows="3"></textarea>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
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
