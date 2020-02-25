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
			<a href="/blogs" style="all: unset;">@lang('strings.blogs')</a>
		</div>
	</div>
</section>
<hr>
<section class="{{app()->getLocale()=='ar'?'ar':''}}">
	@if(auth()->user())
		<div class="card post p-1">
			<form action="/posts" method="POST" enctype="multipart/form-data">
				@csrf
				<textarea class="form-control" name="post"
						  placeholder="@lang('strings.type_post')"></textarea>
				<br>
				<input type="file" name="images[]" class="custom-file-input" multiple
					   accept="image/gif, image/jpeg, image/png" id="post-img">
				<br><br>
				<button type="submit"
						class="btn follow-btn btn-sm">@lang('strings.send')</button>
				<div id="images">

				</div>
			</form>
		</div>
	@endif
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

					@foreach($post->likes as $like)
							@if(auth()->user())
								@if($like->user_id==auth()->user()->id&&$like->type==1)
									<?php $isliked=true; ?>
									@break;
								@elseif($like->user_id==auth()->user()->id&&$like->type==0)
									<?php $isdislike=true; ?>
									@break;
								@endif
							@endif
					@endforeach
			<a class="col-sm-3" href="/like-post/{{$post->slug}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$likes[$post->id]}})</a>
			<a class="col-sm-3" href="/dislike-post/{{$post->slug}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$dislikes[$post->id]}})</a>
			<div class="col-sm-6" style="cursor: pointer" id="comment_btn{{$post->slug}}"><i class="fa fa-comment"></i> @lang('strings.comment')({{count($post->comments)}})</div>
			<br><br>
			<div class="col-sm-12" id="comment_tab{{$post->slug}}" style="display: none;">
				@if(auth()->user())
					<form action="/posts/comment/{{$post->slug}}" method="post">
						@csrf
						<input type="text" name="comment" class="form-control">
						<button class="btn btn-primary" style="margin: 5px 0;" type="submit">@lang('strings.comment')</button>
					</form>
				@endif
				@foreach($post->comments as $comment)
						<?php $isliked=$isdislike=false; ?>
						@foreach($comment->likes as $like)
							@if(auth()->user())
								@if($like->user_id==auth()->user()->id&&$like->type==1)
									<?php $isliked=true; ?>
									@break;
								@elseif($like->user_id==auth()->user()->id&&$like->type==0)
									<?php $isdislike=true; ?>
									@break;
								@endif
							@endif
						@endforeach
				<div class="row">
					<div class="col-sm-12">
						<img src="{{asset('/img/profiles/default.png')}}" class="comment-img">
						<span class="comment-name">{{$comment->user->name}}
							<p> {{$comment->comment}}</p>
						</span>
					</div>
					<div class="col-sm-8 mx-1">
						<div class="row">
							<a class="col-sm-3" href="/like-comment/{{$comment->id}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$commentlikes[$post->id][$comment->id]}})</a>
							<a class="col-sm-3" href="/dislike-comment/{{$comment->id}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$commentdislikes[$post->id][$comment->id]}})</a>
							<div class="col-sm-6" style="cursor: pointer" id="reply_btn{{$comment->id}}"><i class="fa fa-comment"></i> @lang('strings.reply')({{count($comment->replies)}})</div>
							<div class="col-sm-12" id="reply_tab{{$comment->id}}" style="display: none;">
								@if(auth()->user())
									<form action="/comments/reply/{{$comment->id}}" method="post">
										@csrf
										<input type="text" name="reply" class="form-control">
										<button class="btn btn-primary" style="margin: 5px 0;" type="submit">@lang('strings.reply')</button>
									</form>
								@endif
								@foreach($comment->replies as $reply)
										<?php $isliked=$isdislike=false; ?>
										@foreach($reply->likes as $like)
											@if(auth()->user())
												@if($like->user_id==auth()->user()->id&&$like->type==1)
													<?php $isliked=true; ?>
													@break;
												@elseif($like->user_id==auth()->user()->id&&$like->type==0)
													<?php $isdislike=true; ?>
													@break;
												@endif
											@endif
										@endforeach
									<div class="row">
										<div class="col-sm-12">
											<img src="{{asset('/img/profiles/default.png')}}" class="comment-img">
											<span class="comment-name">{{$reply->user->name}}
												<p> {{$reply->reply}}</p>
											</span>
										</div>
										<div class="col-sm-8 mx-1">
											<div class="row">
												<a class="col-sm-4" href="/like-reply/{{$reply->id}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$replieslikes[$post->id][$comment->id][$reply->id]}})</a>
												<a class="col-sm-4" href="/dislike-reply/{{$reply->id}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$repliesdislikes[$post->id][$comment->id][$reply->id]}})</a>
											</div>
										</div>
										<hr>
									</div>
								@endforeach
							</div>
						</div>
					</div>
					<hr>
				</div>
				<script>
					$('#reply_btn{{$comment->id}}').click(function () {
						$('#reply_tab{{$comment->id}}').toggle();
					});
				</script>
				@endforeach
			</div>
		</div>
	</div>
		<br>
		<script>
			$('#comment_btn{{$post->slug}}').click(function () {
				$('#comment_tab{{$post->slug}}').toggle();
			});
		</script>
	@endforeach
	{{--<div id="load_more" style="margin: 10px 49%;">--}}
		{{--<img src="{{asset('img/loader.gif')}}">--}}
	{{--</div>--}}
</section>
<!-- // End Page Content -->
	<script>
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