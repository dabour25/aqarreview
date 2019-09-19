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
<h3 class="title">أضف إعلان جديد</h3>
<form action="/addnew" method="post" enctype="multipart/form-data">
@csrf
<div class="form-group loginform">
	<div class="row ar">
		<div class="col-sm-6">
			<label>إسم الإعلان</label>
			<input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{old('title')}}">
		</div>
		<div class="col-sm-6">
			<label>السعر</label>
			<input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="1000" name="price"  value="{{old('price')}}">
		</div>
		<div class="col-sm-12">
			<label>الوصف</label>
			<textarea class="form-control {{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc">{{old('desc')}}</textarea>
		</div>
		<div class="col-sm-6">
			<label>المساحة (متر مربع)</label>
			<input type="text" class="form-control {{ $errors->has('area') ? ' is-invalid' : '' }}" placeholder="120" name="area" value="{{old('area')}}">
		</div>
		<div class="col-sm-6">
			<label>النوع العام</label>
			<select class="form-control" id="gentype" name="gentype">
				<option value="1" {{old('gentype')==1?'selected':''}}>بيع</option>
				<option value="2" {{old('gentype')==2?'selected':''}}>إيجار</option>
			</select>
		</div>
		<div class="col-sm-6">
			<label>النوع</label>
			<select class="form-control" name="type" id="type">
				<option value="1" {{old('type')==1?'selected':''}}>شقة</option>
                <option value="2" {{old('type')==2?'selected':''}}>فيلا</option>
				<option id="land" value="3" {{old('type')==3?'selected':''}}>أرض</option>
				<option id="homes" value="4" {{old('type')==4?'selected':''}}>بيوت</option>
                <option value="5" {{old('type')==5?'selected':''}}>محل تجارى</option>
				<option value="6" {{old('type')==6?'selected':''}}>شالية</option>
			</select>
		</div>
		<script type="text/javascript">
			$('#gentype').change(function(){
				if($('#gentype').val()==2){
					$('#land').hide();
					$('#homes').hide();
				}else{
					$('#land').show();
					$('#homes').show();
				}
			});
			$('#type').change(function(){
				if($('#type').val()==3){
					$('#floor').hide();
					$('#rooms').hide();
					$('#pathroom').hide();
					$('#kitchens').hide();
					$('#finish').hide();
					$('#furniture').hide();
					$('#parking').hide();
				}else{
					$('#floor').show();
					$('#rooms').show();
					$('#pathroom').show();
					$('#kitchens').show();
					$('#finish').show();
					$('#furniture').show();
					$('#parking').show();
				}
			});
			@if(old('type')==3)
			function f(){
				$('#floor').hide();
				$('#rooms').hide();
				$('#pathroom').hide();
				$('#kitchens').hide();
				$('#finish').hide();
				$('#furniture').hide();
				$('#parking').hide();
			}
			f();
			@endif
		</script>
		<div class="col-sm-6" id="floor">
			<label>الطابق</label>
			<input type="text" class="form-control {{ $errors->has('floor') ? ' is-invalid' : '' }}" placeholder="1" name="floor" value="{{old('floor')}}">
		</div>
		<div class="col-sm-6" id="rooms">
			<label>الغرف</label>
			<input type="text" class="form-control {{ $errors->has('rooms') ? ' is-invalid' : '' }}" placeholder="3" name="rooms" value="{{old('rooms')}}">
		</div>
		<div class="col-sm-6" id="pathroom">
			<label>عدد الحمامات</label>
			<input type="text" class="form-control {{ $errors->has('pathroom') ? ' is-invalid' : '' }}" placeholder="2" name="pathroom" value="{{old('pathroom')}}">
		</div>
		<div class="col-sm-6" id="kitchens">
			<label>عدد المطابخ</label>
			<input type="text" class="form-control {{ $errors->has('kitchens') ? ' is-invalid' : '' }}" placeholder="1" name="kitchens" value="{{old('kitchens')}}">
		</div>
		<div class="col-sm-6" id="finish">
			<label>التشطيب</label>
			<select class="form-control" name="finish">
				<option value="1" {{old('finish')==1?'selected':''}}>كامل</option>
                <option value="2" {{old('finish')==2?'selected':''}}>غير كامل</option>
                <option value="3" {{old('finish')==3?'selected':''}}>طوب احمر</option>
			</select>
		</div>
		<div class="col-sm-6" id="furniture">
			<label>الفرش</label>
			<select class="form-control" name="furniture">
				<option value="1" {{old('furniture')==1?'selected':''}}>نعم</option>
                <option value="2" {{old('furniture')==2?'selected':''}}>لا</option>
			</select>
		</div>
		<div class="col-sm-6" id="parking">
			<label>الجراج</label>
			<select class="form-control" name="parking">
				<option value="1" {{old('parking')==1?'selected':''}}>نعم</option>
                <option value="2" {{old('parking')==2?'selected':''}}>لا</option>
			</select>
		</div>
		<div class="col-sm-12">
			<label style="{{ $errors->has('image') ? 'color:red;' : '' }}">الصور</label>
			<br>
			<input type="file" name="images[]" class="custom-file-input" multiple accept="image/gif, image/jpeg, image/png" id="profile-img">
			<div id="images">
				
			</div>
			<script type="text/javascript">
			    function readURL(input) {
			    	$('#images').html('');
			        var files = event.target.files; //FileList object
			        for (var i = 0; i < files.length; i++) {
			            var file = files[i];
			            //Only pics
			            if (!file.type.match('image')) continue;

			            var picReader = new FileReader();
			            picReader.addEventListener("load", function (event) {
			                var picFile = event.target;
			                $('#images').append('<img src="'+picFile.result+'" class="showimg">');
			            });
			            //Read the image
			            picReader.readAsDataURL(file);
			        }
			    }
			    $("#profile-img").change(function(){
			        readURL(this);
			    });
			</script>
		</div>
		<div class="col-sm-12">
			<label>العنوان</label>
			<textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address">{{old('address')}}</textarea>
		</div>
		<div class="col-sm-12" style="margin-top:20px;">
			<button type="submit" class="btn btn-white">تأكيد البيانات</button>
		</div>
	</div>
</div>
</form>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h3 class="title">Add New Advertise</h3>
<form action="/addnew" method="post" enctype="multipart/form-data">
@csrf
<div class="form-group loginform">
	<div class="row">
		<div class="col-sm-6">
			<label>Advertise title</label>
			<input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{old('title')}}">
		</div>
		<div class="col-sm-6">
			<label>price (EGP)</label>
			<input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="1000" name="price" value="{{old('price')}}">
		</div>
		<div class="col-sm-12">
			<label>description</label>
			<textarea class="form-control {{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc">{{old('desc')}}</textarea>
		</div>
		<div class="col-sm-6">
			<label>area (meter square)</label>
			<input type="text" class="form-control {{ $errors->has('area') ? ' is-invalid' : '' }}" placeholder="120" name="area" value="{{old('area')}}">
		</div>
		<div class="col-sm-6">
			<label>general type</label>
			<select class="form-control" id="gentype" name="gentype">
				<option value="1" {{old('gentype')==1?'selected':''}}>Sell</option>
				<option value="2" {{old('gentype')==2?'selected':''}}>Rent</option>
			</select>
		</div>
		<div class="col-sm-6">
			<label>type</label>
			<select class="form-control" name="type" id="type">
				<option value="1" {{old('type')==1?'selected':''}}>Apartments</option>
                <option value="2" {{old('type')==2?'selected':''}}>Villas</option>
				<option id="land" value="3" {{old('type')==3?'selected':''}}>Land</option>
				<option id="homes" value="4" {{old('type')==4?'selected':''}}>Homes</option>
                <option value="5" {{old('type')==5?'selected':''}}>Shops</option>
				<option value="6" {{old('type')==6?'selected':''}}>Chalets</option>
			</select>
		</div>
		<script type="text/javascript">
			$('#gentype').change(function(){
				if($('#gentype').val()==2){
					$('#land').hide();
					$('#homes').hide();
				}else{
					$('#land').show();
					$('#homes').show();
				}
			});
			$('#type').change(function(){
				if($('#type').val()==3){
					$('#floor').hide();
					$('#rooms').hide();
					$('#pathroom').hide();
					$('#kitchens').hide();
					$('#finish').hide();
					$('#furniture').hide();
					$('#parking').hide();
				}else{
					$('#floor').show();
					$('#rooms').show();
					$('#pathroom').show();
					$('#kitchens').show();
					$('#finish').show();
					$('#furniture').show();
					$('#parking').show();
				}
			});
		</script>
		<div class="col-sm-6" id="floor">
			<label>floor</label>
			<input type="text" class="form-control {{ $errors->has('floor') ? ' is-invalid' : '' }}" placeholder="1" name="floor" value="{{old('floor')}}">
		</div>
		<div class="col-sm-6" id="rooms">
			<label>Rooms</label>
			<input type="text" class="form-control {{ $errors->has('rooms') ? ' is-invalid' : '' }}" placeholder="3" name="rooms" value="{{old('rooms')}}">
		</div>
		<div class="col-sm-6" id="pathroom">
			<label>Pathrooms Count</label>
			<input type="text" class="form-control {{ $errors->has('pathroom') ? ' is-invalid' : '' }}" placeholder="2" name="pathroom" value="{{old('pathroom')}}">
		</div>
		<div class="col-sm-6" id="kitchens">
			<label>kitchens Count</label>
			<input type="text" class="form-control {{ $errors->has('kitchens') ? ' is-invalid' : '' }}" placeholder="1" name="kitchens" value="{{old('kitchens')}}">
		</div>
		<div class="col-sm-6" id="finish">
			<label>finish</label>
			<select class="form-control" name="finish">
				<option value="1" {{old('finish')==1?'selected':''}}>Full</option>
                <option value="2" {{old('finish')==2?'selected':''}}>Semi</option>
                <option value="3" {{old('finish')==3?'selected':''}}>Red Bricks</option>
			</select>
		</div>
		<div class="col-sm-6" id="furniture">
			<label>furniture</label>
			<select class="form-control" name="furniture">
				<option value="1" {{old('furniture')==1?'selected':''}}>Yes</option>
                <option value="2" {{old('furniture')==2?'selected':''}}>No</option>
			</select>
		</div>
		<div class="col-sm-6" id="parking">
			<label>parking</label>
			<select class="form-control" name="parking">
				<option value="1" {{old('parking')==1?'selected':''}}>Yes</option>
                <option value="2" {{old('parking')==2?'selected':''}}>No</option>
			</select>
		</div>
		<div class="col-sm-12">
			<label style="{{ $errors->has('image') ? 'color: red;' : '' }}">images</label>
			<br>
			<input type="file" name="images[]" class="custom-file-input" multiple accept="image/gif, image/jpeg, image/png" id="profile-img">
			<div id="images">
				
			</div>
			<script type="text/javascript">
			    function readURL(input) {
			    	$('#images').html('');
			        var files = event.target.files; //FileList object
			        for (var i = 0; i < files.length; i++) {
			            var file = files[i];
			            //Only pics
			            if (!file.type.match('image')) continue;

			            var picReader = new FileReader();
			            picReader.addEventListener("load", function (event) {
			                var picFile = event.target;
			                $('#images').append('<img src="'+picFile.result+'" class="showimg">');
			            });
			            //Read the image
			            picReader.readAsDataURL(file);
			        }
			    }
			    $("#profile-img").change(function(){
			        readURL(this);
			    });
			</script>
		</div>
		<div class="col-sm-12">
			<label>address</label>
			<textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address">{{old('address')}}</textarea>
		</div>
		<div class="col-sm-12" style="margin-top:20px;">
			<button type="submit" class="btn btn-white">Check data</button>
		</div>
	</div>
</div>
</form>
<!-- // End Page Content -->
@endif
<script type="text/javascript">
	@if(old('gentype')==2)
		$('#land').hide();
		$('#homes').hide();
	@endif
	@if(old('type')==3)
		$('#floor').hide();
		$('#rooms').hide();
		$('#pathroom').hide();
		$('#kitchens').hide();
		$('#finish').hide();
		$('#furniture').hide();
		$('#parking').hide();
	@endif
</script>
@stop