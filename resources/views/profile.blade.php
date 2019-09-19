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
@if(!Session::has('lang'))
<!-- Page Content-->
<h3 class="title">بيانات الصفحة الشخصية</h3>
<form action="/edituser" method="post">
	@csrf
	<div class="form-group loginform">
		<div class="row ar">
			<div class="col-sm-6">
				<label>الإسم</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required value="{{Auth::user()->name}}">
			</div>
			<div class="col-sm-6">
				<label>رقم الهاتف</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{Auth::user()->phone}}">
			</div>
			<div class="col-sm-6">
				<label>رقم سرى جديد</label>
				<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
			</div>
			<div class="col-sm-6">
				<label>تأكيد الرقم الجديد</label>
				<input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation">
			</div>
			<div class="col-sm-12">
				<label>نوع الحساب</label>
				<select class="form-control" name="role">
					<option value="user" {{Auth::user()->role=='user'?'selected':''}}>مستخدم عادى</option>
					<option value="developer"{{Auth::user()->role=='developer'?'selected':''}}>مطور</option>
					<option value="broker" {{Auth::user()->role=='broker'?'selected':''}}>وسيط</option>
					<option value="owner" {{Auth::user()->role=='owner'?'selected':''}}>مالك</option>
					<option value="renter" {{Auth::user()->role=='renter'?'selected':''}}>مؤجِر</option>
				</select>
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<button class="btn btn-white" type="submit">تعديل</button>
			</div>
		</div>
	</div>
</form>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h3 class="title">Profile Data</h3>
<form action="/edituser" method="post">
	@csrf
	<div class="form-group loginform">
		<div class="row">
			<div class="col-sm-6">
				<label>Name</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{Auth::user()->name}}">
			</div>
			<div class="col-sm-6">
				<label>Phone</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{Auth::user()->phone}}">
			</div>
			<div class="col-sm-6">
				<label>New Password</label>
				<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
			</div>
			<div class="col-sm-6">
				<label>New Password Confirmation</label>
				<input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation">
			</div>
			<div class="col-sm-12">
				<label>Account type</label>
				<select class="form-control" name="role">
					<option value="user" {{Auth::user()->role=='user'?'selected':''}}>Normal User</option>
					<option value="developer"{{Auth::user()->role=='developer'?'selected':''}}>Developer</option>
					<option value="broker" {{Auth::user()->role=='broker'?'selected':''}}>Broker</option>
					<option value="owner" {{Auth::user()->role=='owner'?'selected':''}}>Owner</option>
					<option value="renter" {{Auth::user()->role=='renter'?'selected':''}}>Renter</option>
				</select>
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<button class="btn btn-white">Edit</button>
			</div>
		</div>
	</div>
</form>
<!-- // End Page Content -->
@endif
@stop