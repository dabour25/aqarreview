@extends('master')
@section('content')
@if(count($errors)>0)
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('m'))
  <?php $a=[]; $a=session()->pull('m'); ?>
  <div class="alert alert-{{$a[0]}}" style="width: 40%">
    {{$a[1]}}
  </div>
@endif
@if(!Session::has('lang'))
<!-- Page Content-->
<h1 class="title" style="padding-top:150px;padding-bottom:150px;">خطأ 419 تعزر الطلب</h1>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h1 class="title" style="padding-top:150px;padding-bottom:150px;">Error 419 Pad Requist</h1>
<!-- // End Page Content -->
@endif
@stop