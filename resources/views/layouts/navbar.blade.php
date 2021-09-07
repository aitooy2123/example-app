<?php
 
 use Illuminate\Support\Facades\Auth;
 ?>
 
 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand  navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('contact') }}" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('clear-cache') }}" class="nav-link">ClearCache</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img 

          @if(empty(Auth::user()->avatar)) src="{{ asset('dist/img/avatar4.png') }}"
          @else src="{{ asset('uploads/avatar/'.Auth::user()->avatar) }}"
          @endif

          class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            
            @if(empty(Auth::user()->avatar)) <img  src="{{ asset('dist/img/avatar4.png') }}" class="img-circle elevation-2" alt="User Image">
            @else <img  src="{{ asset('uploads/avatar/'.Auth::user()->avatar) }}" class="img-circle elevation-2" alt="User Image">
            @endif
      
            <p>{{ Auth::user()->name }}
              <small>{{ Auth::user()->class }}</small>
            </p>
          </li>
          <!-- Menu Body -->
          <li class="user-body">
            <div class="row">
              <div class="col-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
            <!-- /.row -->
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="{{ route('profile') }}" class="btn btn-outline-info rounded-pill btn-flat">Profile</a>
            <a href="{{ route('logout') }}" class="btn btn-outline-danger rounded-pill btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
          </li>
        </ul>
      </li>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>


      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>

    </ul>
  </nav>