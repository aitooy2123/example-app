<?php

use App\Models\CmsHelper as cms;
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('images/laravel-developer.png') }}" alt="Logo" class="brand-image img-circle ">
        <span class="brand-text font-weight-light">Example-APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- nav nav-pills nav-sidebar nav-compact nav-legacy flex-column nav-child-indent nav-collapse-hide-child -->
        <!-- Sidebar Menu -->
        <nav class="mt-2 ">
            <ul class="nav nav-pills nav-sidebar flex-column  nav-compact nav-flat nav-legacy nav-child-indent nav-collapse-hide-child"
                data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                @if (auth::user()->class == 'Admin')

                    <li class="nav-header">EXAMPLES</li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ active_route('dashboard') }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('home2') }}" class="nav-link {{ active_route('home2') }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Home</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('table') }}" class="nav-link {{ active_route('table*') }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>CRUD</p>
                        </a>
                    </li>

                    <li class="nav-item @ifActiveRoute('form.*') menu-open @endIfActiveRoute">
                        <a href="#" class="nav-link {{ active_route('form.*') }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Form<i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('form.upload') }}"
                                    class="nav-link {{ active_route('form.upload') }}">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Form (Upload) <span
                                            class="badge badge-warning right">{{ cms::CountFile() }}</span></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('form.image') }}"
                                    class="nav-link {{ active_route('form.image') }}">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Form (Image) <span class="badge badge-info right">{{ cms::CountImg() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('form.relate') }}"
                                    class="nav-link {{ active_route('form.relate') }}">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Form (Relate) <span
                                            class="badge badge-danger right">{{ cms::CountRelate() }}</span></p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('logs') }}" target="_blank" class="nav-link">
                            <i class="nav-icon fas fa-search"></i>
                            <p>Logs</p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">WORKSHOP : Survey</li>

                <li class="nav-item">
                    <a href="{{ route('workshop.form') }}" class="nav-link {{ active_route('workshop.form') }}">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>แบบฟอร์ม</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('workshop.list') }}" class="nav-link {{ active_route('workshop.list') }}">
                        <i class="nav-icon far fa-list-alt"></i>
                        <p>รายการ</p>
                    </a>
                </li>


                <li class="nav-header">Extra</li>
                <li class="nav-item">
                    <a href="{{ route('line') }}" class="nav-link {{ active_route('line') }}">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>Line Notify</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('qrcode') }}" class="nav-link {{ active_route('qrcode') }}">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>QR Code</p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
