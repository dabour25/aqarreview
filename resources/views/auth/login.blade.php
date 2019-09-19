@extends('master')
@section('content')
@if(!Session::has('lang'))
<!-- Page Content-->
<h3 class="title">تسجيل دخول</h3>
@if(count($errors)>0)
    <br>
    <div class="alert alert-danger ar">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('m'))
      <?php $a=[]; $a=session()->pull('m'); ?>
      <div class="alert alert-{{$a[0]}} ar" style="width: 40%">
        {{$a[1]}}
      </div>
    @endif
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group loginform">
        <div class="row ar">
            <div class="col-sm-12">
                <label>البريد الإلكترونى</label>
                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email" value="{{ old('email') }}">
            </div>
            <div class="col-sm-12">
                <label>الرمز السرى (باسورد)</label>
                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
            </div>
            <div class="col-sm-12" style="margin-top:20px;">
                <a href="#">إسترجاع الرمز السرى؟</a>
            </div>
            <div class="col-sm-12">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span style="margin-right: 20px">تذكرنى</span>
            </div>
            <div class="col-sm-12" style="margin-top:20px;">
                <button class="btn btn-white">دخول</button>
            </div>
        </div>
    </div>
</form>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h3 class="title">Login</h3>
@if(count($errors)>0)
    <br>
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
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group loginform">
        <div class="row">
            <div class="col-sm-12">
                <label>E-Mail</label>
                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email" {{ old('remember') ? 'checked' : '' }}>
            </div>
            <div class="col-sm-12">
                <label>Password</label>
                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
            </div>
            <div class="col-sm-12" style="margin-top:20px;">
                <a href="#">Forget password?</a>
            </div>
            <div class="col-sm-12">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span>Remember Me</span>
            </div>
            <div class="col-sm-12" style="margin-top:20px;">
                <button class="btn btn-white" type="submit">Login</button>
            </div>
        </div>
    </div>
</form>
<!-- // End Page Content -->
@endif
@stop
