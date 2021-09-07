<?php

use App\Models\CmsHelper as cms;
?>

@extends('layouts.master')

@php $header='รายละเอียดการสำรวจ'; @endphp
@section('title',$header)

@section('custom-css-script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
@endsection

@section('custom-css')
<style>
    .thumb-post img {
  object-fit: none; /* Do not scale the image */
  object-position: center; /* Center the image within the element */
  width: 100%;
  max-height: 250px;
  margin-bottom: 1rem;
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
                        <li class="breadcrumb-item"><a href="{{ route('workshop.list') }}">รายการ</a></li>
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

                <dl class="row">

                    <dt class="col-sm-3">ชื่อสถานที่</dt>
                    <dd class="col-sm-9">{{ $survey->store_name }}</dd>

                    <dt class="col-sm-3">ที่อยู่</dt>
                    <dd class="col-sm-9">
                        {{ 'บ้านเลขที่ '.$survey->store_no }}
                        {{ 'หมู่ที่ '.$survey->store_moo }}
                        {{ 'ซอย '.$survey->store_soi }}
                        {{ 'ถนน '.$survey->store_road }}
                        {{ cms::GetTumbon($survey->tumbon) }}
                        {{ cms::GetAmphoe($survey->amphoe) }}
                        {{ cms::GetProvince($survey->province) }}
                        {{ 'รหัสไปรษณีย์ '.$survey->zipcode }}
                    </dd>

                    <dt class="col-sm-3">เบอร์โทรศัพท์</dt>
                    <dd class="col-sm-9">{{ cms::TextFormat($survey->tel,'__-____-____') }}</dd>

                    <dt class="col-sm-3">วันที่บันทึก</dt>
                    <dd class="col-sm-9">{{ cms::DateThai($survey->date)['dMY'] }}</dd>

                </dl>

                <hr>

                <label for="">ภาพประกอบ</label>
                <div class="row">

                    @foreach($img as $val)
                    <div class="col-sm-12 col-md-4 col-lg-2">
                        <div class="form-group" >
                            <a href="{{ asset('uploads/survey/'.$val->img_name) }}" data-fancybox="gallery" data-caption="{{ $val->img_name }}">
                                <img src="{{ asset('uploads/survey/'.$val->img_name) }}" class=" img-thumbnail img-fluid m" style="width: 200px; height: 200px; object-fit: cover;">
                            </a>
                        </div>
                    </div>
                    @endforeach

                </div>


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
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
@endsection

@section('custom-js')
@endsection