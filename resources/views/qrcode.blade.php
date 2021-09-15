@extends('layouts.master')

@php $header='QR Code'; @endphp
@section('title', $header)

@section('custom-css-script')
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

          <?php
          if (empty($_GET['size'])) {
              $size = '350x350';
          } else {
              $size = $_GET['size'];
          }
          ?>

          <div class="form-group d-inline">
            <div class="row">
              <div class="col-6">
                <a href="?web=example-app" class="btn btn-default">Example-App</a>
                <a href="?web=ddc" class="btn btn-default">DDC</a>
                <a href="?web=google" class="btn btn-default">Google</a>
              </div>
              <div class="col-6">
                <form action="" method="get" class="d-inline">
                  <div class="row input-group">
                    <select name="size" class="form-control col-2">
                      <option value="200x200">200x200</option>
                      <option value="300x300">300x300</option>
                      <option value="400x400" selected>400x400</option>
                      <option value="500x500">500x500</option>
                    </select>
                    <input type="text" name="web" class="form-control col-8" placeholder="website">
                    <button type="submit" class="form-control col-2 btn-success">Gen Code</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="from-group my-4 alert alert-warning text-white">
            <h4 >
              @if (empty($_GET['web'])) {{ $url = url()->current() }}
              @elseif($_GET['web']=='ddc') {{ $url = 'http:://ddc.moph.go.th' }}
              @elseif($_GET['web']=='google') {{ $url = 'http://www.google.com' }}
              @elseif($_GET['web']=='example-app') {{ $url = url()->current() }}
              @else {{ $url = $_GET['web'] }}
              @endif
            </h4>
          </div>



          <div class="row text-center">
            <div class="col-md-4 form-group">
              <img src="https://chart.googleapis.com/chart?chs={{ $size }}&cht=qr&chl={{ $url }}&choe=UTF-8" class="img-fluid img-thumbnail elevation-2">
            </div>
            <div class="col-md-8 form-group">
              <textarea rows="7" class="form-control text-xl text-bold"><img src="https://chart.googleapis.com/chart?chs={{ $size }}&cht=qr&chl={{ $url }}&choe=UTF-8"></textarea>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div> <!-- Content Header (Page header) -->
@endsection

@section('custom-js-script')
@endsection

@section('custom-js')
@endsection
