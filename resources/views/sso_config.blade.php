@extends('layouts.master')

@php $header='DDC SSO (Single Sign On)'; @endphp
@section('title',$header)

@section('custom-css-script')
  <!-- CodeMirror -->
  <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/codemirror/theme/monokai.css') }}">
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

              <label for="">Install Laravel & Auth</label>
              <ul>
                <li>composer create-project --prefer-dist laravel/laravel AuthSS0</li>
                <li>composer requre laravel/ui</li>
                <li>php artisan ui bootstrap --auth</li>
                <li>npm install</li>
                <li>npm run dev</li>
                <li>npm install resolve-url-loader@^4.0.0 --save-dev --legacy-peer-deps</li>
                <li>npm run dev</li>
                <li>create DB & edit .ENV</li>
                <li>php artisan migrate</li>
                <li>php artisan serv</li>
              </ul>



            </div><!-- /.card-body -->
        </div><!-- /.card -->

    </section><!-- /.content -->
</div>
<!-- Content Header (Page header) -->
@endsection

@section('custom-js-script')
<!-- CodeMirror -->
<script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
<script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
<script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
<script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
@endsection

@section('custom-js')
<script>
    $(function () {
      // Summernote
      $('#summernote').summernote()

      // CodeMirror
      CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
      });
    })
  </script>
@endsection
