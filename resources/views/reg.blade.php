@extends('master')
@section('content')
<!-- Page Content-->
<h3 class="title"> @lang('strings.register')</h3>
<div class="form-group loginform">
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
      <div class="alert alert-{{$a[0]}} {{app()->getLocale()=='ar'?'ar':''}}" style="width: 40%">
        {{$a[1]}}
      </div>
    @endif
    <form action="/reg" method="post">
		@csrf
		<div class="row {{app()->getLocale()=='ar'?'ar':''}}">
			<div class="col-sm-6">
				<label>@lang('strings.name')</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{old('name')}}">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.email')</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email" value="{{old('email')}}">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.password')</label>
				<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.password_confirm')</label>
				<input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.age')</label>
				<input type="date" class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" name="age">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.phone')</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="@lang('strings.optional')" name="phone">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.account_type')</label>
				<select class="form-control" name="role">
					<option value="user">@lang('strings.user')</option>
					<option value="developer">@lang('strings.developer')</option>
					<option value="broker">@lang('strings.broker')</option>
					<option value="owner">@lang('strings.owner')</option>
					<option value="renter">@lang('strings.renter')</option>
					<option value="engineer">@lang('strings.engineer')</option>
					<option value="contractor">@lang('strings.contractor')</option>
					<option value="corporation">@lang('strings.corporation')</option>
				</select>
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<button class="btn btn-white" type="submit">@lang('strings.register')</button>
			</div>
		</div>
	</form>
</div>
<!-- // End Page Content -->
@stop