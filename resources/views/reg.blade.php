@extends('master')
@section('content')
@if(!Session::has('lang'))
<!-- Page Content-->
<h3 class="title"> تسجيل</h3>
<div class="form-group loginform">
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
    <form action="/reg" method="post">
		@csrf
		<div class="row ar">
			<div class="col-sm-6">
				<label>الإسم</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="name" value="{{old('name')}}">
			</div>
			<div class="col-sm-6">
				<label>البريد الإلكترونى</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email" value="{{old('email')}}">
			</div>
			<div class="col-sm-6">
				<label>الرمز السرى (باسورد)</label>
				<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
			</div>
			<div class="col-sm-6">
				<label>تأكيد الرمز السر</label>
				<input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation">
			</div>
			<div class="col-sm-6">
				<label>رقم الهاتف</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="إختيارى" name="phone">
			</div>
			<div class="col-sm-6">
				<label>نوع الحساب</label>
				<select class="form-control" name="role">
					<option value="user">مستخدم عادى</option>
					<option value="developer">مطور</option>
					<option value="broker">وسيط</option>
					<option value="owner">مالك</option>
					<option value="renter">مؤجِر</option>
				</select>
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<button class="btn btn-white" type="submit">تسجيل</button>
			</div>
		</div>
	</form>
</div>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h3 class="title">Register</h3>
<div class="form-group loginform">
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
    <form action="/reg" method="post">
		@csrf
		<div class="row">
			<div class="col-sm-6">
				<label>Name</label>
				<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name">
			</div>
			<div class="col-sm-6">
				<label>E-Mail</label>
				<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
			</div>
			<div class="col-sm-6">
				<label>Password</label>
				<input type="text" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="password" class="form-control " name="password">
			</div>
			<div class="col-sm-6">
				<label>Password Confirmation</label>
				<input type="text" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="password" class="form-control " name="password_confirmation">
			</div>
			<div class="col-sm-6">
				<label>Phone</label>
				<input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="example@example.com" name="email">
				<input type="text" class="form-control " placeholder="Optional" name="phone">
			</div>
			<div class="col-sm-6">
				<label>Account type</label>
				<select class="form-control" name="role">
					<option value="user">Normal User</option>
					<option value="developer">Developer</option>
					<option value="broker">Broker</option>
					<option value="owner">Owner</option>
					<option value="renter">Renter</option>
				</select>
			</div>
			<div class="col-sm-12" style="margin-top:20px;">
				<button class="btn btn-white" type="submit">Register</button>
			</div>
		</div>
	</form>
</div>
<!-- // End Page Content -->
@endif
@stop