@extends('master')
@section('content')
@if(!Session::has('lang'))
<!-- Page Content-->
<h3 class="title">تواصل معنا</h3>
<div class="form-group contactform">
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
	<form action="/sendmes" method="post">
		@csrf
		<div class="row ar">
			<div class="col-sm-6">
				<label>الإسم:</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="text" class="form-control " placeholder="أدخل إسمك" name="name" value="{{Auth::user()?Auth::user()->name:''}}">
			</div>
			<div class="col-sm-6">
				<label>البريد الإلكترونى:</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="text" class="form-control " placeholder="بريدك الإلكترونى" name="email" value="{{Auth::user()?Auth::user()->email:''}}">
			</div>
			<div class="col-sm-12">
				<label>الموضوع:</label>
				<input type="text" class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="text" class="form-control " placeholder="كيف نساعدك ؟" name="subject">
			</div>
			<div class="col-sm-12">
				<label>الرسالة:</label>
				<input type="text" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<textarea type="text" class="form-control " placeholder="تفاصيل.." rows="4" name="message"></textarea>
			</div>
			<button type="submit" class="btn button-theme btn-search btn-block col-sm-2" style="margin-top:20px;margin-right:30px;">
				<i class="fa fa-envelope"></i><strong> إرسال </strong>
			</button>
		</div>

	</form>
</div>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h3 class="title">Contact Us</h3>
<div class="form-group contactform">
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
	<form action="/sendmes" method="post">
		@csrf
		<div class="row">
			<div class="col-sm-6">
				<label>Name:</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="text" class="form-control " placeholder="Enter Your Name" name="name" value="{{Auth::user()?Auth::user()->name:''}}">
			</div>
			<div class="col-sm-6">
				<label>E-Mail:</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="text" class="form-control " placeholder="E-Mail" name="email" value="{{Auth::user()?Auth::user()->email:''}}">
			</div>
			<div class="col-sm-12">
				<label>Subject:</label>
				<input type="text" class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="text" class="form-control " placeholder="How Can we help you ?" name="subject">
			</div>
			<div class="col-sm-12">
				<label>Message:</label>
				<input type="text" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<textarea type="text" class="form-control " placeholder="Details.." rows="4" name="message"></textarea>
			</div>
			<button type="submit" class="btn button-theme btn-search btn-block col-sm-2" style="margin-top:20px;margin-left:30px;">
				<i class="fa fa-envelope"></i><strong> Send </strong>
			</button>
		</div>
	</form>
</div>
<!-- // End Page Content -->
@endif
@stop