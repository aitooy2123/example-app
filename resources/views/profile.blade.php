<?php

use App\Models\CmsHelper as cms;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// dd(cms::DateThai(carbon::now()));
?>

@extends('layouts.master')

@php $header='Profile'; @endphp
@section('title',$header)

@section('custom-css-script')
<link rel="stylesheet" href="{{ asset('plugins/ijaboCropTool-master/ijaboCropTool.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('custom-css')
@endsection

@section('content')
<div class="content-wrapper">
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
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">

                                @if(empty($Profile->avatar))
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/avatar4.png') }}">
                                @else
                                <!-- <a class="img-fluid h-50 w-50" data-placement="right" data-toggle="tooltip" data-html="true" title="<img src='{{ asset('uploads/avatar/'.$Profile->avatar) }}'>"> -->
                                <img class="profile-user-img  img-circle" src="{{ asset('uploads/avatar/'.$Profile->avatar) }}">
                                <!-- </a> -->
                                @endif

                            </div>
                            <h3 class="profile-username text-center">{{ $Profile->name }}</h3>
                            <p class="text-muted text-center">
                                @if(auth::user()->class=='Admin')<i class="fas fa-crown text-yellow"></i>
                                @else <i class="fas fa-user-circle text-blue"></i>
                                @endif
                                {{ auth::user()->class }}
                            </p>

                            <input type="file" name="file" id="file" class="btn btn-default btn-block d-none" accept=".jpg,.jpeg,.png">
                            <a href="javascript:void(0)" id="change_file" class="btn bg-gradient-pink btn-block"><b>Change Picture</b></a>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Profile</a></li>
                                <li class="nav-item"><a class="nav-link " href="#settings" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">

                            <div class="tab-content">

                                <div class="active tab-pane" id="activity">
                                    <form action="{{ route('profile.update') }}" method="POST" class=" horizontal">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">ชื่อ-นามสกุล</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" placeholder="Name" value="{{ auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" placeholder="Email" value="{{ auth::user()->email }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">หน่วยงาน</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2" value="{{ cms::GetOrg($Profile->organize_id) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <!-- /.tab-pane -->


                                <div class=" tab-pane" id="settings">

                                    <!-- <div class="alert alert-warning" role="alert">
                                        <strong>{{ password_hash("123456", PASSWORD_DEFAULT) }}</strong>
                                    </div> -->

                                    <form action="{{ route('change_password') }}" class="form-horizontal" method="POST">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="Password" placeholder="Password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- /.tab-pane -->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
@endsection

@section('custom-js-script')
<script src="{{ asset('plugins/ijaboCropTool-master/ijaboCropTool.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
@endsection

@section('custom-js')
<script>
    $('#file').ijaboCropTool({
        preview: '.image-previewer',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        buttonsText: ['CROP', 'QUIT'],
        buttonsColor: ['#30bf7d', '#ee5155', -15],
        processUrl: '{{ route("crop") }}',
        withCSRF: ['_token', '{{ csrf_token() }}'],
        onSuccess: function(message, element, status) {
            //  alert(message);
            location.reload();

            // toastr.success(
            //     message,
            //     'Success :', {
            //         timeOut: 1000,
            //         fadeOut: 1000,
            //         onHidden: function() {
            //             window.location.reload();
            //         }
            //     }
            // );
        },
        onError: function(message, element, status) {
            alert(message);
        }
    });
</script>

@if ($message = Session::get('Success'))
<script>
    toastr.success('แก้ไขเรียบร้อย');
</script>
@endif


<script language="JavaScript">
    $(document).on('click', '#change_file', function() {
        $('#file').click();
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

@endsection