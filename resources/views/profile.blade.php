@extends('master')
@section('content')
@if(count($errors)>0)
<div class="alert alert-danger {{!session()->has('lang')?'ar':''}}">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('m'))
  <?php $a=[]; $a=session()->pull('m'); ?>
  <div class="alert alert-{{$a[0]}} {{!session()->has('lang')?'ar':''}}">
    {{$a[1]}}
  </div>
@endif
<!-- Page Content-->
<h3 class="title">@lang('strings.personal_data')</h3>
<form action="/edituser" method="post">
	@csrf
	<div class="form-group loginform">
		<div class="row {{app()->getLocale()=='ar'?'ar':''}}">
			<div class="col-sm-6">
				<label>@lang('strings.name')</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required value="{{Auth::user()->name}}">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.phone')</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{Auth::user()->phone}}">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.password')</label>
				<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.password_confirm')</label>
				<input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation">
			</div>
			<div class="col-sm-12">
				<label>@lang('strings.account_type')</label>
				<select class="form-control" name="role">
					<option value="user" {{Auth::user()->role=='user'?'selected':''}}>@lang('strings.user')</option>
					<option value="developer"{{Auth::user()->role=='developer'?'selected':''}}>@lang('strings.developer')</option>
					<option value="broker" {{Auth::user()->role=='broker'?'selected':''}}>@lang('strings.broker')</option>
					<option value="owner" {{Auth::user()->role=='owner'?'selected':''}}>@lang('strings.owner')</option>
					<option value="renter" {{Auth::user()->role=='renter'?'selected':''}}>@lang('strings.renter')</option>
				</select>
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<button class="btn btn-white" type="submit">@lang('strings.edit')</button>
			</div>
		</div>
	</div>
</form>
<!-- // End Page Content -->
@stop