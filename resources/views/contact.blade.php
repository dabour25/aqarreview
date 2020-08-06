@extends('master')
@section('content')
<!-- Page Content-->
<h3 class="title">@lang('strings.contact')</h3>
<div class="form-group contactform">
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
	<form action="/contact" method="post">
		@csrf
		<div class="row {{app()->getLocale()=='ar'?'ar':''}}">
			<div class="col-sm-6">
				<label>@lang('strings.name'):</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="@lang('strings.enter_name')" name="name" value="{{Auth::user()?Auth::user()->name:''}}">
			</div>
			<div class="col-sm-6">
				<label>@lang('strings.email'):</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="@lang('strings.your_email')" name="email" value="{{Auth::user()?Auth::user()->email:''}}">
			</div>
			<div class="col-sm-12">
				<label>@lang('strings.subject'):</label>
				<input type="text" class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="@lang('strings.how_help')" name="subject">
			</div>
			<div class="col-sm-12">
				<label>@lang('strings.message'):</label>
				<textarea type="text" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="@lang('strings.details').." rows="4" name="message"></textarea>
			</div>
			<button type="submit" class="btn button-theme btn-search btn-block col-sm-2" style="margin-top:20px;margin-right:30px;">
				<i class="fa fa-envelope"></i><strong> @lang('strings.send') </strong>
			</button>
		</div>

	</form>
</div>
<!-- // End Page Content -->

@stop
