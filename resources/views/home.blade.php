@extends('adminlte::page')

@section('title', 'dashboard')

@section('content_header')
<div class="d-flex justify-content-end">
    <div class="pr-3">
        <span class="fa fa-sm fa-chart-line"></span> dashboard
    </div>
</div>
@stop

@section('sidebar_top')
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset('image/user.jpg') }}" class="img-circle elevation-2" alt="User Image" min-width="60px" min-height="60px">
    </div>
    <div class="info">
      <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      <span class=""></span>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Dashboard</h3>
    </div>
    <div class="card-body">
        <p>welcome to this beautiful admin panel.</p>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
