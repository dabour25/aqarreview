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
  <div class="alert alert-{{$a[0]}}" style="width: 40%">
    {{$a[1]}}
  </div>
@endif
<!-- Page Content-->
<h3 class="title">{{$ad['ad']->title}}</h3>
<div class="row {{app()->getLocale()=='ar'?'ar':''}}" style="padding:10px;">
	<div id="carouselExampleIndicators" class="carousel slide col-md-6" data-ride="carousel">
	  <div class="carousel-inner">
		<div class="carousel-item active">
			@if(count($ad['ad']->images)==0)
			<img class="d-block w-100" src="{{asset('img/ads')}}/{{$links[5]->value}}" alt="Primary slide" style="height: 600px;object-fit: contain">
			@else
		  <img class="d-block w-100 zoomimg" src="{{asset('img/ads')}}/{{$ad['ad']->images[0]->url}}" alt="Primary slide" style="height: 600px;object-fit: contain" id="fim">
		  @endif
		</div>
		<div id="fmodal" class="modal">
			  <span class="close" id="fclose">&times;</span>
			  <img class="modal-content" id="fimg" style="object-fit: contain">
			</div>
		  <script>
			var fmodal = document.getElementById("fmodal");
			var fimg = document.getElementById("fim");
			var fmodalImg = document.getElementById("fimg");
			fimg.onclick = function(){
			  fmodal.style.display = "block";
			  fmodalImg.src = this.src;
			}

			var fspan = document.getElementById("fclose");

			fspan.onclick = function() {
			  fmodal.style.display = "none";
			}
		  </script>
		<?php $imgs=$ad['ad']->images ?>
		@foreach($imgs as $k=>$im)
		@if($k>0)
		<div class="carousel-item">
		  <img class="d-block w-100 zoomimg" id="im{{$k}}" src="{{asset('img/ads')}}/{{$im->url}}" alt="{{$ad['ad']->title}}">
		</div>
		@endif
		@endforeach
	  </div>
	  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	  </a>
	</div>
	@foreach($imgs as $k=>$im)
		@if($k>0)
	<!-- The Modal -->
			<div id="modal{{$k}}" class="modal">
			  <span class="close" id="close{{$k}}">&times;</span>
			  <img class="modal-content" id="img{{$k}}" style="object-fit: contain">
			</div>
		<script>
		var modal{{$k}} = document.getElementById("modal{{$k}}");
		var img{{$k}} = document.getElementById("im{{$k}}");
		var modalImg{{$k}} = document.getElementById("img{{$k}}");
		img{{$k}}.onclick = function(){
		  modal{{$k}}.style.display = "block";
		  modalImg{{$k}}.src = this.src;
		}

		var span{{$k}} = document.getElementById("close{{$k}}");

		span{{$k}}.onclick = function() {
		  modal{{$k}}.style.display = "none";
		}
		</script>
		@endif
		@endforeach
	<div class="col-md-6" style="padding:50px;">
		<h6>
			<b style="color:#ddbd25;">@lang('strings.price'):</b>
			<p class="details-ar">{{$ad['ad']->price}}@lang('strings.le')</p>
		</h6>
		<h6>
			<b style="color:#ddbd25;">@lang('strings.description'):</b>
			<p class="details-ar">{{$ad['ad']->description}}</p>
		</h6>
		<h6>
			<b style="color:#ddbd25;">@lang('strings.other_details'):</b>
			<div class="property-box">
				<div class="detail" style="margin:0;box-shadow:0 0 0;">
					<ul class="facilities-list clearfix">
						@if($ad['ad']->type=="land")
						<li>
							<i class="flaticon-ui"></i>@lang('strings.area') : {{$ad['ad']->size}} @lang('strings.meter')
						</li>
						@else
						<li>
							<i class="flaticon-bed"></i>@lang('strings.rooms') : {{$ad['ad']->rooms}}
						</li>
						<li>
							<i class="flaticon-bathroom"></i>@lang('strings.bathrooms') : {{$ad['ad']->bathrooms}}/@lang('strings.kitchens') : {{$ad['ad']->kitchens}}
						</li>
						<li>
							<i class="flaticon-ui"></i>@lang('strings.area') : {{$ad['ad']->size}} @lang('strings.meter')
						</li>
						<li>
							<i class="flaticon-car"></i>{{$ad['ad']->parking=="yes"?trans('strings.park'):trans('strings.no_park')}}
						</li>
						<li>
							<i class="fa fa-building"></i>@lang('strings.floor') : {{$ad['ad']->floor}}
						</li>
						<li>
							<i class="fa fa-leaf"></i>@lang('strings.finishing') :
							@if($ad['ad']->finish=="full")
								@lang('strings.full')
							@elseif($ad['ad']->finish=="not_full")
								@lang('strings.not_full')
							@else
								@lang('strings.red_brick')
							@endif
						</li>
						<li>
							<i class="fa fa-gamepad"></i>@lang('strings.furniture') : {{$ad['ad']->furniture==1?trans('strings.yes'):trans('strings.no')}}
						</li>
						@endif
						<li>
							<i class="fa fa-map-marker"></i>{{$ad['ad']->address}}
						</li>
					</ul>
				</div>
			</div>
		</h6>
		<div class="row">
			@if(Auth::user()&&Auth::user()->id==$ad['ad']->user)
			<a href="/removead/{{$ad['ad']->id}}" class="btn button-theme btn-search btn-block col-sm-5" >
				<i class="fa fa-trash"></i><strong>@lang('strings.remove_ad')</strong>
			</a>
			@elseif(Auth::user())
			<button class="btn button-theme btn-search btn-block col-sm-5" id="favo{{$ad['ad']->id}}"
				{{$page=="REVIEW ADVERTISE"?'disabled':''}}>
				@if(empty($fav))
                <i class="fa fa-star" id="fav{{$ad['ad']->id}}"><strong> @lang('strings.add_to_favourites') </strong></i>
                @else
                <i class="fa fa-star" id="fav{{$ad['ad']->id}}"><strong>@lang('strings.remove_from_favourites')</strong></i>
                @endif
			</button>
			@else
			<button class="btn button-theme btn-search btn-block col-sm-5" disabled>
				<i class="fa fa-star"></i><strong> @lang('strings.add_to_favourites') </strong>
			</button>
			@endif
			<div class="col-sm-1"></div>
			<button class="btn button-theme btn-search btn-block col-sm-5" data-toggle="collapse" data-target="#sellerdata" aria-expanded="false" aria-controls="sellerdata">
				<i class="fa fa-address-book"></i><strong>@lang('strings.show_advertiser_data')</strong>
			</button>
		</div>
		<br>
		<div class="collapse" id="sellerdata">
		  	<div class="card card-body">
		    	<p><strong>@lang('strings.name'): </strong>{{$ad['name']}}</p>
		    	<p><strong>@lang('strings.phone'): </strong>{{$ad['phone']}}</p>
		    	@if(isset($ad['email'])&&$ad['email']!='')
		    	<p><strong> @lang('strings.email'): </strong>{{$ad['email']}}</p>
		    	@endif
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $('#favo{{$ad['ad']->id}}').click(function(){
        $.ajax({
           type:'GET',
           url:'/fav/{{$ad['ad']->id}}',
           success:function(data) {
                if(data.type==1){
                    $('#fav{{$ad['ad']->id}}').html('<strong>@lang('strings.remove_from_favourites')</strong>');
                }else if(data.type==2){
                    $('#fav{{$ad['ad']->id}}').html('<strong>@lang('strings.add_to_favourites')</strong>');
                }
                alert(data.msg);
           }
        });
    });
</script>
<!-- // End Page Content -->
@stop
