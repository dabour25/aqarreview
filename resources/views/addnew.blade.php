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
<!-- Page Content-->
<h3 class="title">@lang('strings.add_advertise')</h3>
<form action="/addnew" method="post" enctype="multipart/form-data">
@csrf
<div class="form-group loginform">
	<div class="row {{app()->getLocale()=='ar'?'ar':''}}">
		<div class="col-sm-6">
			<label>@lang('strings.advertise_name')</label>
			<input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{old('title')}}">
		</div>
		<div class="col-sm-6">
			<label>@lang('strings.price')</label>
			<input type="number" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="@lang('strings.price_str')" name="price"  value="{{old('price')}}">
		</div>
		<div class="col-sm-12">
			<label>@lang('strings.description')</label>
			<textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{old('description')}}</textarea>
		</div>
		<div class="col-sm-6">
			<label> @lang('strings.area')(@lang('strings.meter_square'))</label>
			<input type="number" class="form-control {{ $errors->has('size') ? ' is-invalid' : '' }}" placeholder="@lang('strings.area_str')" name="size" value="{{old('size')}}">
		</div>
		<div class="col-sm-6">
			<label>@lang('strings.gen_type')</label>
			<select class="form-control" id="general_type" name="general_type">
				<option value="sell" {{old('general_type')=='sell'?'selected':''}}>@lang('strings.sell')</option>
				<option value="rent" {{old('general_type')=='rent'?'selected':''}}>@lang('strings.rent')</option>
			</select>
		</div>
		<div class="col-sm-6">
			<label>@lang('strings.type')</label>
			<select class="form-control" name="type" id="type">
				<option value="apartment" {{old('type')=='apartment'?'selected':''}}>@lang('strings.apartment')</option>
                <option value="villa" {{old('type')=='villa'?'selected':''}}>@lang('strings.villa')</option>
				<option id="land" value="land" {{old('type')=='land'?'selected':''}}>@lang('strings.land')</option>
				<option id="homes" value="houses" {{old('type')=='houses'?'selected':''}}>@lang('strings.houses')</option>
                <option value="shop" {{old('type')=='shop'?'selected':''}}>@lang('strings.shop')</option>
				<option value="chalet" {{old('type')=='chalet'?'selected':''}}>@lang('strings.chalet')</option>
			</select>
		</div>
		<script type="text/javascript">
			$('#general_type').change(function(){
				if($('#general_type').val()=='rent'){
					$('#land').hide();
					$('#homes').hide();
				}else{
					$('#land').show();
					$('#homes').show();
				}
			});
			$('#type').change(function(){
				if($('#type').val()=='land'){
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
			@if(old('type')=='land')
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
			<label>@lang('strings.floor')</label>
			<input type="number" class="form-control {{ $errors->has('floor') ? ' is-invalid' : '' }}" placeholder="@lang('strings.floor_str')" name="floor" value="{{old('floor')}}">
		</div>
		<div class="col-sm-6" id="rooms">
			<label>@lang('strings.rooms')</label>
			<input type="number" class="form-control {{ $errors->has('rooms') ? ' is-invalid' : '' }}" placeholder="@lang('strings.rooms_str')" name="rooms" value="{{old('rooms')}}">
		</div>
		<div class="col-sm-6" id="pathroom">
			<label>@lang('strings.bathrooms_count')</label>
			<input type="number" class="form-control {{ $errors->has('pathroom') ? ' is-invalid' : '' }}" placeholder="@lang('strings.bathrooms_str')" name="pathroom" value="{{old('pathroom')}}">
		</div>
		<div class="col-sm-6" id="kitchens">
			<label>@lang('strings.kitchens')</label>
			<input type="number" class="form-control {{ $errors->has('kitchens') ? ' is-invalid' : '' }}" placeholder="@lang('strings.kitchens_str')" name="kitchens" value="{{old('kitchens')}}">
		</div>
		<div class="col-sm-6" id="finish">
			<label>@lang('strings.finishing')</label>
			<select class="form-control" name="finish">
				<option value="full" {{old('finish')==1?'selected':'full'}}>@lang('strings.full')</option>
                <option value="not_full" {{old('finish')==2?'selected':'not_full'}}>@lang('strings.not_full')</option>
                <option value="red_bricks" {{old('finish')==3?'selected':'red_bricks'}}>@lang('strings.red_brick')</option>
			</select>
		</div>
		<div class="col-sm-6" id="furniture">
			<label>@lang('strings.furniture')</label>
			<select class="form-control" name="furniture">
				<option value="yes" {{old('furniture')=='yes'?'selected':''}}>@lang('strings.yes')</option>
                <option value="no" {{old('furniture')=='no'?'selected':''}}>@lang('strings.no')</option>
			</select>
		</div>
		<div class="col-sm-6" id="parking">
			<label>@lang('strings.park')</label>
			<select class="form-control" name="parking">
				<option value="yes" {{old('parking')=='yes'?'selected':''}}>@lang('strings.yes')</option>
                <option value="no" {{old('parking')=='no'?'selected':''}}>@lang('strings.no')</option>
			</select>
		</div>
		<div class="col-sm-12">
			<label style="{{ $errors->has('image') ? 'color:red;' : '' }}">@lang('strings.images')</label>
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
			<label>@lang('strings.address')</label>
			<textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address">{{old('address')}}</textarea>
		</div>
		<div class="col-sm-12" style="margin-top:20px;">
			<button type="submit" class="btn btn-white">@lang('strings.confirm_data')</button>
		</div>
	</div>
</div>
</form>
<!-- // End Page Content -->
<script type="text/javascript">
	@if(old('general_type')=='rent')
		$('#land').hide();
		$('#homes').hide();
	@endif
	@if(old('type')=='land')
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