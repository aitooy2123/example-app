@extends('layouts.master')

@php $header='Contact Us'; @endphp
@section('title',$header)

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
            <div class="card-body row">
                <div class="col-5 text-center d-flex align-items-center justify-content-center">
                    <div class="">
                        <h2>Admin<strong>LTE</strong></h2>
                        <p class="lead mb-5">123 Testing Ave, Testtown, 9876 NA<br>
                            Phone: +1 234 56789012
                        </p>

                        <!-- <img src="https://ddc.moph.go.th/ddcmap/img/itc.jpg" class="img-fluid"> -->
                    </div>
                </div>
                <div class="col-7">
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" id="inputName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">E-Mail</label>
                        <input type="email" id="inputEmail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputSubject">Subject</label>
                        <input type="text" id="inputSubject" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputMessage">Message</label>
                        <textarea id="inputMessage" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Send message">
                    </div>
                </div>
            </div>


        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div> <!-- Content Header (Page header) -->
@endsection

@section('custom-js-script')
@endsection

@section('custom-js')
@endsection