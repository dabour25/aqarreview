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
@if(!Session::has('lang'))
<!-- Page Content-->
<h3 class="title">{{$ad->title}}</h3>
<div class="row ar" style="padding:10px;">
	<div id="carouselExampleIndicators" class="carousel slide col-md-6" data-ride="carousel">
	  <div class="carousel-inner">
		<div class="carousel-item active">
			@if($ad->image=='')
			<img class="d-block w-100" src="{{asset('img/ads')}}/{{$links[5]->value}}" alt="Primary slide" style="height: 600px;object-fit: contain">
			@else
		  <img class="d-block w-100 zoomimg" src="{{asset('img/ads')}}/{{$ad->image}}" alt="Primary slide" style="height: 600px;object-fit: contain" id="fim">
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
		<?php $imgs=explode('|', $ad->images); ?>
		@foreach($imgs as $k=>$im)
		@if($im!='')
		<div class="carousel-item">
		  <img class="d-block w-100 zoomimg" id="im{{$k}}" src="{{asset('img/ads')}}/{{$im}}" alt="{{$ad->title}}">
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
		@if($im!='')
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
			<b style="color:#ddbd25;">السعر:</b>
			<p class="details-ar">{{$ad->price}} ج.م</p>
		</h6>
		<h6>
			<b style="color:#ddbd25;">الوصف:</b>
			<p class="details-ar">{{$ad->description}}</p>
		</h6>
		<h6>
			<b style="color:#ddbd25;">تفاصيل اخرى:</b>
			<div class="property-box">
				<div class="detail" style="margin:0;box-shadow:0 0 0;">
					<ul class="facilities-list clearfix">
						@if($ad->type==3)
						<li>
							<i class="flaticon-ui"></i>المساحة : {{$ad->size}} م
						</li>
						@else
						<li>
							<i class="flaticon-bed"></i>الغرف : {{$ad->rooms}}
						</li>
						<li>
							<i class="flaticon-bathroom"></i>حمامات : {{$ad->pathroom}}/مطابخ : {{$ad->kitchen}}
						</li>
						<li>
							<i class="flaticon-ui"></i>المساحة : {{$ad->size}} م
						</li>
						<li>
							<i class="flaticon-car"></i>{{$ad->parking==1?'جراج':'لا يوجد جراج'}}					
						</li>
						<li>
							<i class="fa fa-building"></i>الطابق : {{$ad->floor}}
						</li>
						<li>
							<i class="fa fa-leaf"></i>التشطيب :
							@if($ad->finish==1)
							كامل
							@elseif($ad->finish==2)
							غير كامل
							@else
							طوب احمر
							@endif
						</li>
						<li>
							<i class="fa fa-gamepad"></i>الفرش : {{$ad->furniture==1?'نعم':'لا'}}
						</li>
						@endif
						<li>
							<i class="fa fa-map-marker"></i>{{$ad->address}}
						</li>
					</ul>
				</div>
			</div>
		</h6>
		<div class="row">
			@if(Auth::user()&&Auth::user()->id==$ad->user)
			<a href="/removead/{{$ad->id}}" class="btn button-theme btn-search btn-block col-sm-5" >
				<i class="fa fa-trash"></i><strong>حذف الإعلان</strong>
			</a>
			@elseif(Auth::user())
			<button class="btn button-theme btn-search btn-block col-sm-5" id="favo{{$ad->id}}" 
				{{$page=="REVIEW ADVERTISE"?'disabled':''}}>
				@if(empty($fav))
                <i class="fa fa-star" id="fav{{$ad->id}}"><strong> مفضلة </strong></i>
                @else
                <i class="fa fa-star" id="fav{{$ad->id}}"><strong>حذف من المفضلة</strong></i>
                @endif
			</button>
			@else
			<button class="btn button-theme btn-search btn-block col-sm-5" disabled>
				<i class="fa fa-star"></i><strong> مفضلة </strong>
			</button>
			@endif
			<div class="col-sm-1"></div>
			<button class="btn button-theme btn-search btn-block col-sm-5" data-toggle="collapse" data-target="#sellerdata" aria-expanded="false" aria-controls="sellerdata">
				<i class="fa fa-address-book"></i><strong> عرض بيانات المعلن </strong>
			</button>
		</div>
		<br>
		<div class="collapse" id="sellerdata">
		  	<div class="card card-body">
		    	<p><strong>الإسم: </strong>{{$name}}</p>
		    	<p><strong>الهاتف: </strong>{{$phone}}</p>
		    	@if(isset($email)&&$email!='')
		    	<p><strong>البريد  الإلكترونى: </strong>{{$email}}</p>
		    	@endif
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $('#favo{{$ad->id}}').click(function(){
        $.ajax({
           type:'GET',
           url:'/fav/{{$ad->id}}',
           success:function(data) {
                if(data.type==1){
                    $('#fav{{$ad->id}}').html('<strong>حذف من المفضلة</strong>');
                }else if(data.type==2){
                    $('#fav{{$ad->id}}').html('<strong>مفضلة</strong>');
                }
                alert(data.msg);
           }
        });
    });
</script>
<!-- // End Page Content -->
@else
<!-- Page Content-->
<h3 class="title"> {{$ad->title}}</h3>
<div class="row" style="padding:10px;">
	<div id="carouselExampleIndicators" class="carousel slide col-md-6" data-ride="carousel">
	  <div class="carousel-inner">
		<div class="carousel-item active">
			@if($ad->image=='')
			<img class="d-block w-100" src="{{asset('img/ads')}}/{{$links[5]->value}}" alt="Primary slide" style="height: 600px;object-fit: contain">
			@else
		  <img class="d-block w-100 zoomimg" src="{{asset('img/ads')}}/{{$ad->image}}" alt="Primary slide" style="height: 600px;object-fit: contain" id="fim">
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
		<?php $imgs=explode('|', $ad->images); ?>
		@foreach($imgs as $k=>$im)
		@if($im!='')
		<div class="carousel-item">
		  <img class="d-block w-100 zoomimg" id="im{{$k}}" src="{{asset('img/ads')}}/{{$im}}" alt="{{$ad->title}}">
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
		@if($im!='')
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
			<b style="color:#ddbd25;">Price:</b>
			<p class="details">{{$ad->price}} EGP</p>
		</h6>
		<h6>
			<b style="color:#ddbd25;">Discription:</b>
			<p class="details">{{$ad->description}}</p>
		</h6>
		<h6>
			<b style="color:#ddbd25;">Other Details:</b>
			<div class="property-box">
				<div class="detail" style="margin:0;box-shadow:0 0 0;">
					<ul class="facilities-list clearfix">
						@if($ad->type==3)
						<li>
							<i class="flaticon-ui"></i> {{$ad->size}} m
						</li>
						@else
						<li>
							<i class="flaticon-bed"></i> {{$ad->rooms}} Rooms
						</li>
						<li>
							<i class="flaticon-bathroom"></i> {{$ad->pathroom}} Pathroom/ {{$ad->kitchens}} Kitchens
						</li>
						<li>
							<i class="flaticon-ui"></i> {{$ad->size}} m
						</li>
						<li>
							<i class="flaticon-car"></i> {{$ad->parking==1?'Parking':'No Parking'}}
						</li>
						<li>
							<i class="fa fa-building"></i> floor : {{$ad->floor}}
						</li>
						<li>
							<i class="fa fa-leaf"></i> Finishing :
							@if($ad->finish==1)
							Full
							@elseif($ad->finish==2)
							Semi
							@else
							Red Bricks
							@endif
						</li>
						<li>
							<i class="fa fa-gamepad"></i> Furniture : {{$ad->firniture==1?'Yes':'No'}}
						</li>
						@endif
						<li>
							<i class="fa fa-map-marker"></i>{{$ad->address}}
						</li>
					</ul>
				</div>
			</div>
		</h6>
		<div class="row">
			@if(Auth::user()&&Auth::user()->id==$ad->user)
			<a href="/removead/{{$ad->id}}" class="btn button-theme btn-search btn-block col-sm-5" >
				<i class="fa fa-trash"></i><strong>Remove Advertise</strong>
			</a>
			@elseif(Auth::user())
			<button class="btn button-theme btn-search btn-block col-sm-5" id="favo{{$ad->id}}" 
				{{$page=="REVIEW ADVERTISE"?'disabled':''}}>
				@if(empty($fav))
                <i class="fa fa-star" id="fav{{$ad->id}}"><strong>Favourite</strong></i>
                @else
                <i class="fa fa-star" id="fav{{$ad->id}}"><strong>Remove from favourites</strong></i>
                @endif
			</button>
			@else
			<button class="btn button-theme btn-search btn-block col-sm-5" disabled>
				<i class="fa fa-star"></i><strong>Favourite</strong>
			</button>
			@endif
			<div class="col-sm-1"></div>
			<button class="btn button-theme btn-search btn-block col-sm-5" data-toggle="collapse" data-target="#sellerdata" aria-expanded="false" aria-controls="sellerdata">
				<i class="fa fa-address-book"></i><strong> View advertiser data </strong>
			</button>
		</div>
		<br>
		<div class="collapse" id="sellerdata">
		  	<div class="card card-body">
		    	<p><strong>Name: </strong>{{$name}}</p>
		    	<p><strong>Phone: </strong>{{$phone}}</p>
		    	@if(isset($email)&&$email!='')
		    	<p><strong>Email: </strong>{{$email}}</p>
		    	@endif
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $('#favo{{$ad->id}}').click(function(){
        $.ajax({
           type:'GET',
           url:'/fav/{{$ad->id}}',
           success:function(data) {
                if(data.type==1){
                    $('#fav{{$ad->id}}').html('<strong>Remove From Favourites</strong>');
                }else if(data.type==2){
                    $('#fav{{$ad->id}}').html('<strong>Favourite</strong>');
                }
                alert(data.msg);
           }
        });
    });
</script>
<!-- // End Page Content -->
@endif
@stop