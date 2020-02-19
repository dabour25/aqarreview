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
<section>
	<div class="row" style="width: 45%;margin: auto;">
		<div class="col-md-5 card my-card card-selected">
			@lang('strings.posts')
		</div>
		<div class="col-md-5 card my-card">
			@lang('strings.blogs')
		</div>
	</div>
</section>
<hr>
<section class="{{app()->getLocale()=='ar'?'ar':''}}">
	<div class="main-title" style="margin-bottom: 10px;margin-top: 20px;">
		<h4>@lang('strings.new_posts')</h4>
	</div>
	<!--Post-->
	@foreach($posts as $post)
	<div class="card post">
		<div class="row">
			<img src="{{asset('/img/profiles/default.png')}}" class="post-img">
			<span class="post-name">{{$post->users->name}}<p class="post-name-tiny">({{$post->created_at}}) <span class="post-follow">Follow</span></p></span>
		</div>
		<hr>
		<p class="post-body">{{$post->content}}</p>
		<hr>
		<div class="row">
		@foreach($post->images as $image)
			<div class="col-md-4">
				<img src="{{asset('img/posts').'/'.$image->url}}" width="100%" height="200px" style="padding: 10px;">
			</div>
		@endforeach
		</div>
		<hr>
		<div class="row" style="width:80%;margin: auto;">
			<?php $isliked=$isdislike=false;$likescount=$dislikescount=0 ?>
				@if(auth()->user())
					@foreach($post->likes as $like)
						@if($like->type==1)
						<?php $likescount++; ?>
						@else
						<?php $dislikescount++; ?>
						@endif
						@if($like->user_id==auth()->user()->id&&$like->type==1)
							<?php $isliked=true; ?>
							@break;
						@elseif($like->user_id==auth()->user()->id&&$like->type==0)
							<?php $isdislike=true; ?>
							@break;
						@endif
					@endforeach
				@endif
			<a class="col-sm-3" href="/like-post/{{$post->slug}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$likescount}})</a>
			<a class="col-sm-3" href="/dislike-post/{{$post->slug}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$dislikescount}})</a>
			<div class="col-sm-6" style="cursor: pointer" id="comment_btn"><i class="fa fa-comment"></i> @lang('strings.comment')(20)</div>
			<br><br>
			<div class="col-sm-12" id="comment_tab" style="display: none;">
				<input type="text" name="comment" class="form-control">
				<button class="btn btn-primary" style="margin: 5px 0;">@lang('strings.comment')</button>
				<div class="row">
					<img src="{{asset('/img/profiles/default.png')}}" class="comment-img">
					<span class="comment-name">Ahmed Magdy
						<p> pla pla pla</p>
					</span>
				</div>
			</div>
		</div>
	</div>
		<br>
	@endforeach
	<div id="load_more" style="margin: 10px 49%;">
		<img src="{{asset('img/loader.gif')}}">
	</div>
</section>
<!-- // End Page Content -->
	<script>
		$('#comment_btn').click(function () {
			$('#comment_tab').toggle();
		});
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
		$("#post-img").change(function(){
			readURL(this);
		});
	</script>
@stop