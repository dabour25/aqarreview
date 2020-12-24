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
        <?php $a = []; $a = session()->pull('m'); ?>
        <div class="alert alert-{{$a[0]}} {{!session()->has('lang')?'ar':''}}">
            {{$a[1]}}
        </div>
    @endif
    <!-- Page Content-->
    <div class="col-md-12">
        <br>
        <div class="row {{app()->getLocale()=='ar'?'ar':''}}">
            <div class="col-md-4">
                <div class="portlet light profile-sidebar-portlet bordered">
                    <div class="profile-userpic">
                        <div style="margin: auto;width: 50%">
                            <img src="{{asset('img/profiles').'/'.($user->images?($user->images[0]->url??$links[6]->value):$links[6]->value)}}" class="img-responsive" alt="">
                            @if($user->id==auth()->user()->id)
                            <form action="/change-profile" method="post" enctype="multipart/form-data" id="change_image_form">
                               @csrf
                                <input type="file" name="profile" class="custom-file-input" title="Change profile image" id="profile-img">
                            </form>
                            @endif
                        </div>
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> {{$user->name}} </div>
                        <div class="profile-usertitle-job"> {{trans('strings.'.$user->role)}} </div>
                    </div>
                    <div class="profile-userbuttons">
                        <button type="button" id="follow"
                                class="btn follow-btn btn-sm">{{$isFollow?trans('strings.unfollow'):trans('strings.follow')}}
                            ({{$user->followers_count??count($followers)}})
                        </button>
                        <button type="button" class="btn btn-info btn-sm">@lang('strings.message')</button>
                    </div>
                    <div class="profile-usermenu">
                        @if(auth()->user()&&($user->id!=auth()->user()->id))
                            <ul class="nav">
                                <li>
                                    <a href="/report/{{$user->slug}}">
                                        @lang('strings.report')
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="portlet light profile-sidebar-portlet bordered">
                    <h5>@lang('strings.followers') ({{count($followers)}})</h5>
                    <div style="padding: 10px;">
                        <div class="row">
                            @foreach($followers as $follow)
                                <div class="col-1">
                                    <a href="/profiles/{{$follow->followerData->slug}}">
                                        <img src="{{asset('img/profiles').'/'.($follow->followerData->images?($follow->followerData->images[0]->url??$links[6]->value):$links[6]->value)}}"
                                             style="width:60px;border-radius: 50%;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="portlet light profile-sidebar-portlet bordered">
                    <h5>@lang('strings.following') ({{count($following)}})</h5>
                    <div style="padding: 10px;">
                        <div class="row">
                            @foreach($following as $follow)
                                <div class="col-1">
                                    <a href="/profiles/{{$follow->followingData->slug}}">
                                        <img src="{{asset('img/profiles').'/'.($follow->followingData->images?($follow->followingData->images[0]->url??$links[6]->value):$links[6]->value)}}"
                                             style="width:60px;border-radius: 50%;" title="{{$follow->followingData->name}}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md" style="{{app()->getLocale()=='ar'?'float: right;':''}}">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">@lang('strings.profile_info')</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div>
                            <!-- Nav tabs -->
                            @if(auth()->user()&&($user->id==auth()->user()->id))
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#" id="update_btn">@lang('strings.update')</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="update_data" style="display: none;">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <form action="/reg/{{$user->slug}}" method="post">
                                        @csrf
                                        {{method_field('put')}}
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>@lang('strings.name')</label>
                                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user->name}}">
                                            </div>
                                            <div class="col-sm-12">
                                                <label>@lang('strings.old_password')</label>
                                                <input type="password" class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>@lang('strings.password')</label>
                                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>@lang('strings.password_confirm')</label>
                                                <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation">
                                            </div>
                                            <div class="col-sm-12">
                                                <label>@lang('strings.age')</label>
                                                <input type="date" class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" name="age" value="{{$user->age}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>@lang('strings.phone')</label>
                                                <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="@lang('strings.optional')" name="phone" value="{{$user->phone}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>@lang('strings.account_type')</label>
                                                <select class="form-control" name="role">
                                                    <option value="user" {{$user->role=='user'?'selected':''}}>@lang('strings.user')</option>
                                                    <option value="developer" {{$user->role=='developer'?'selected':''}}>@lang('strings.developer')</option>
                                                    <option value="broker" {{$user->role=='broker'?'selected':''}}>@lang('strings.broker')</option>
                                                    <option value="owner" {{$user->role=='owner'?'selected':''}}>@lang('strings.owner')</option>
                                                    <option value="renter" {{$user->role=='renter'?'selected':''}}>@lang('strings.renter')</option>
                                                    <option value="engineer" {{$user->role=='engineer'?'selected':''}}>@lang('strings.engineer')</option>
                                                    <option value="contractor" {{$user->role=='contractor'?'selected':''}}>@lang('strings.contractor')</option>
                                                    <option value="corporation" {{$user->role=='corporation'?'selected':''}}>@lang('strings.corporation')</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12" style="margin-top:20px;">
                                                <button class="btn btn-white" type="submit">@lang('strings.save')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                                <script>
                                    $('#update_btn').click(function (){
                                        $('#update_data').toggle();
                                        $('#user_data').toggle();
                                    });
                                </script>
                            @endif
                            <div class="tab-content" id="user_data">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <p>@lang('strings.name'): {{$user->name}}</p>
                                    <p>@lang('strings.email'): {{$user->email}}</p>
                                    <p>@lang('strings.phone'): {{$user->phone}}</p>
                                    <p>@lang('strings.age'): {{$user->age}}</p>
                                    <p>@lang('strings.joint_from'): {{$user->created_at}}</p>
                                    <p>@lang('strings.global_link'): <a
                                                href="/profiles/{{$user->slug}}">{{request()->getHost()}}/profiles/{{$user->slug}}</a></p>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md " style="{{app()->getLocale()=='ar'?'float: right;':''}}">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">@lang('strings.posts')</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    @if($user->id==auth()->user()->id)
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($posts as $post)
                        <div class="card post">
                            <div class="row">
                                <img src="{{asset('img/profiles').'/'.($post->users->images?($post->users->images[0]->url??'default.png'):'default.png')}}" class="post-img">
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
                                                <img src="{{asset('img/profiles').'/'.($comment->user->images?($comment->user->images[0]->url??'default.png'):'default.png')}}" class="comment-img">
                                                <span class="comment-name">{{$comment->user->name}}
							<p> {{$comment->comment}}</p>
						</span>
                                            </div>
                                            <div class="col-sm-12 mx-1">
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
                                                                    <img src="{{asset('img/profiles').'/'.($reply->user->images?($reply->user->images[0]->url??'default.png'):'default.png')}}" class="comment-img">
                                                                    <span class="comment-name">{{$reply->user->name}}
												<p> {{$reply->reply}}</p>
											</span>
                                                                </div>
                                                                <div class="col-sm-8 mx-1">
                                                                    <div class="row">
                                                                        <a class="col-sm-6" href="/like-reply/{{$reply->id}}"><i class="fa fa-thumbs{{$isliked?'':'-o'}}-up"></i> @lang('strings.like') ({{$replieslikes[$post->id][$comment->id][$reply->id]}})</a>
                                                                        <a class="col-sm-6" href="/dislike-reply/{{$reply->id}}"><i class="fa fa-thumbs{{$isdislike?'':'-o'}}-down"></i> @lang('strings.dislike') ({{$repliesdislikes[$post->id][$comment->id][$reply->id]}})</a>
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
                </div>
            </div>
        </div>
    </div>
    <!-- // End Page Content -->
    <script>
        $('#follow').click(function () {
            location.href = '/follow/{{$user->slug}}';
        });
        $('#profile-img').change(function () {
            $('#change_image_form').submit();
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
                    $('#images').append('<img src="' + picFile.result + '" class="showimg">');
                });
                //Read the image
                picReader.readAsDataURL(file);
            }
        }

        $("#post-img").change(function () {
            readURL(this);
        });
    </script>
@stop
