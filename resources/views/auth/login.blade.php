@extends('master')
@section('content')
<!-- Page Content-->
<h3 class="title">@lang('strings.login')</h3>
@if(count($errors)>0)
    <br>
    <div class="alert alert-danger {{app()->getLocale()=='ar'?'ar':''}}">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('m'))
      <?php $a=[]; $a=session()->pull('m'); ?>
      <div class="alert alert-{{$a[0]}} {{app()->getLocale()=='ar'?'ar':''}}">
        {{$a[1]}}
      </div>
    @endif
<form method="POST" action="/log{{isset($key)&&$key=='my-Admin925'?'/my-admin':'/user'}}">
    @csrf
    <div class="form-group loginform">
        <div class="row {{app()->getLocale()=='ar'?'ar':''}}">
            <div class="col-sm-12">
                <label>@lang('strings.email'):</label>
                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email" value="{{ old('email') }}">
            </div>
            <div class="col-sm-12">
                <label>@lang('strings.password')</label>
                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
            </div>
            <div class="col-sm-12" style="margin-top:20px;">
                <a href="#">@lang('strings.reset_password')</a>
            </div>
            <div class="col-sm-12">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span style="margin-right: 20px">@lang('strings.remember')</span>
            </div>
            <div class="col-sm-12" style="margin-top:20px;">
                <button class="btn btn-white">@lang('strings.login')</button>
            </div>
        </div>
    </div>
</form>
<!-- // End Page Content -->
@stop
