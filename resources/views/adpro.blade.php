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
  <div class="alert alert-{{$a[0]}} {{!session()->has('lang')?'ar':''}}" style="width: 40%">
    {{$a[1]}}
  </div>
@endif
@if(!Session::has('lang'))
<!-- Page Content-->
<h3 class="title">بيانات الصفحة الشخصية</h3>
@if(auth::user())
<p class="title">
	تريد ان تظهر نفس بياناتك الشخصية السابقة ؟
	<br>
	<input type="radio" id="same" name="data" value="0" checked> لا
	<input type="radio" id="nosame" name="data" value="1"> نعم
</p>
<hr>
@endif
<form action="/addpro/{{$adid}}" method="post">
	@csrf
	<div class="form-group loginform">
		<div class="row ar">
			<div class="col-sm-6">
				<label>الإسم</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" required value="{{Auth::user()?Auth::user()->name:old('name')}}">
			</div>
			<div class="col-sm-6">
				<label>رقم الهاتف</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="phone" required value="{{Auth::user()?Auth::user()->phone:old('phone')}}">
			</div>
			<div class="col-sm-12">
				<label>البريد الإلكترونى</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email" id="email" value="{{Auth::user()?Auth::user()->email:old('email')}}">
				<input type="checkbox" name="showemail" id="showemail"> أظهر البريد للمستخدمين
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<div class="btn btn-white" id="review">مراجعة</div>
				<button class="btn btn-white" type="submit">نشر</button>
			</div>
		</div>
	</div>
</form>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h3 class="title">Profile Data</h3>
@if(auth::user())
<p class="title">
	Would you like to use your same profile information ?
	<br>
	<input type="radio" id="same" name="data" value="0" checked> yes
	<input type="radio" id="nosame" name="data" value="1"> no
</p>
<hr>
@endif
<form action="/addpro/{{$adid}}" method="post">
	@csrf
	<div class="form-group loginform">
		<div class="row">
			<div class="col-sm-6">
				<label>Name</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : old('name') }}" name="name" id="name" value="{{Auth::user()?Auth::user()->name:''}}">
			</div>
			<div class="col-sm-6">
				<label>Phone</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : old('phone') }}" name="phone" id="phone" value="{{Auth::user()?Auth::user()->phone:''}}">
			</div>
			<div class="col-sm-12">
				<label>E-Mail</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : old('email') }}" placeholder="example@example.com" name="email" id="email" value="{{Auth::user()?Auth::user()->email:''}}">
				<input type="checkbox" name="showemail" id="showemail"> Show E-Mail to User
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<div class="btn btn-white" id="review">Preview</div>
				<button class="btn btn-white">Publish</button>
			</div>
		</div>
	</div>
</form>
<!-- // End Page Content -->
@endif
<script type="text/javascript">
	$('#review').click(function(){
		if($('#name').val()==''||$('#phone').val()==''){
			@if(Session::has('lang'))
			alert('Error : You Must Complete Data First');
			@else
			alert('خطأ : عليك إكمال البيانات');
			@endif
		}else{
			if($('#showemail').prop("checked")==true){
				window.open(
				  '{{Request::root()}}/review/{{$adid}}/'+$('#name').val()+'/'+$('#phone').val()+'/'+$('#email').val(),
				  '_blank'
				);
			}else{
				window.open(
				  '{{Request::root()}}/review/{{$adid}}/'+$('#name').val()+'/'+$('#phone').val(),
				  '_blank'
				);
			}
		}
	});
	@if(Auth::user())
	$('#nosame').click(function(){
		$('#name').val('');
		$('#phone').val('');
		$('#email').val('');
	});
	$('#same').click(function(){
		$('#name').val('{{Auth::user()->name}}');
		$('#phone').val('{{Auth::user()->phone}}');
		$('#email').val('{{Auth::user()->email}}');
	});
	@endif
</script>
@stop