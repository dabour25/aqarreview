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
<div class="col-md-12">
	<br>
	<div class="row {{app()->getLocale()=='ar'?'ar':''}}">
		<div class="col-sm-10">
			<form action="/report/{{$slug}}" method="post">
				@csrf
				<label>@lang('strings.report_input')</label>
				<textarea name="report" class="form-control" rows="8"></textarea>
				<br>
				<button class="btn btn-primary">@lang('strings.report')</button>
				<br>
				<br>
			</form>
		</div>
	</div>
</div>
@stop