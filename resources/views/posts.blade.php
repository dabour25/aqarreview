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
	<div class="card post">
		<div class="row">
			<img src="{{asset('/img/profiles/default.png')}}" class="post-img">
			<span class="post-name">Ahmed Magdy<p class="post-name-tiny">(2020-01-30 20:13) <span class="post-follow">Follow</span></p></span>
		</div>
		<hr>
		<p class="post-body">pla pla pla</p>
		<hr>
		<!-- if there are Images -->
		<hr>
		<div class="row" style="width:80%;margin: auto;">
			<div class="col-sm-3" style="cursor: pointer"><i class="fa fa-thumbs-o-up"></i> @lang('strings.like') (50)</div>
			<div class="col-sm-3" style="cursor: pointer"><i class="fa fa-thumbs-o-down"></i> @lang('strings.dislike') (30)</div>
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