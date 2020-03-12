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
		<div class="col-md-5 card my-card">
			<a href="/posts" style="all: unset;">@lang('strings.posts')</a>
		</div>
		<div class="col-md-5 card my-card card-selected">
			@lang('strings.blogs')
		</div>
	</div>
</section>
<hr>
<section class="{{app()->getLocale()=='ar'?'ar':''}}">
	<div class="main-title" style="margin-bottom: 10px;margin-top: 20px;">
		<h4>@lang('strings.blog') : {{$blog->title}}</h4>
	</div>
	<!--Blog-->
		<div class="card post">
			<div class="row">
				<img src="{{asset('img/profiles').'/'.($blog->users->images?($blog->users->images[0]->url??'default.png'):'default.png')}}" class="post-img">
				<span class="post-name">{{$blog->users->name}}<p class="post-name-tiny">({{$blog->created_at}}) <span class="post-follow">Follow</span></p></span>
			</div>
			<hr>
			<a href="/blogs/{{$blog->slug}}">
				<p class="post-body">{{$blog->title}}</p>
			</a>
			<hr>
			<?php echo $blog->content; ?>
			<hr>
			<div class="row" style="width:80%;margin: auto;">
				<?php $isliked=$isdislike=false;$likescount=$dislikescount=0 ?>

				@foreach($blog->likes as $like)
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
				<a class="col-sm-3" href="/like-blog/{{$blog->slug}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$likes}})</a>
				<a class="col-sm-3" href="/dislike-blog/{{$blog->slug}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$dislikes}})</a>
				<div class="col-sm-6" style="cursor: pointer" id="comment_btn{{$blog->slug}}"><i class="fa fa-comment"></i> @lang('strings.comment')({{count($blog->comments)}})</div>
				<br><br>
				<div class="col-sm-12" id="comment_tab{{$blog->slug}}" style="display: none;">
					@if(auth()->user())
						<form action="/blogs/comment/{{$blog->slug}}" method="post">
							@csrf
							<input type="text" name="comment" class="form-control">
							<button class="btn btn-primary" style="margin: 5px 0;" type="submit">@lang('strings.comment')</button>
						</form>
					@endif
					@foreach($blog->comments as $comment)
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
								<img src="{{asset('img/profiles').'/'.($comment->user->images?($comment->user->images[0]->url??'default.png'):'default.png')}}" class="comment-img">
								<span class="comment-name">{{$comment->user->name}}
						<p> {{$comment->comment}}</p>
					</span>
							</div>
							<div class="col-sm-12 mx-1">
								<div class="row">
									<a class="col-sm-3" href="/like-comment/{{$comment->id}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$commentlikes[$comment->id]}})</a>
									<a class="col-sm-3" href="/dislike-comment/{{$comment->id}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$commentdislikes[$comment->id]}})</a>
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
													<img src="{{asset('img/profiles').'/'.($reply->user->images?($reply->user->images[0]->url??'default.png'):'default.png')}}" class="comment-img">
													<span class="comment-name">{{$reply->user->name}}<p> {{$reply->reply}}</p></span>
												</div>
												<div class="col-sm-8 mx-1">
													<div class="row">
														<a class="col-sm-6" href="/like-reply/{{$reply->id}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$replieslikes[$comment->id][$reply->id]}})</a>
														<a class="col-sm-6" href="/dislike-reply/{{$reply->id}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$repliesdislikes[$comment->id][$reply->id]}})</a>
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
			$('#comment_btn{{$blog->slug}}').click(function () {
				$('#comment_tab{{$blog->slug}}').toggle();
			});
		</script>
</section>
<!-- // End Page Content -->
@stop