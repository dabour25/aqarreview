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
                            <img src="{{asset('img/profiles/default.png')}}" class="img-responsive" alt="">
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
                        @if(auth()->user()&&!isset($followers))
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
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                                                                          data-toggle="tab">@lang('strings.update')</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <!--<form>
                                        <div class="form-group">
                                            <label for="inputName">Name</label>
                                            <input type="text" class="form-control" id="inputName" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputLastName">Last Name</label>
                                            <input type="text" class="form-control" id="inputLastName" placeholder="Last Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <input type="file" id="exampleInputFile">
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Check me out
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>-->
                                    <p>@lang('strings.name'): {{$user->name}}</p>
                                    <p>@lang('strings.email'): {{$user->email}}</p>
                                    <p>@lang('strings.phone'): {{$user->phone}}</p>
                                    <p>@lang('strings.age'): {{$user->age}}</p>
                                    <p>@lang('strings.joint_from'): {{$user->created_at}}</p>
                                    <p>@lang('strings.global_link'): <a
                                                href="/profiles/{{$user->slug}}">@lang('strings.here')</a></p>

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
                                    @if(isset($followers))
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
                        <div class="card my-5">
                            <div class="row">
                                <img src="{{asset('/img/profiles/default.png')}}" class="post-img">
                                <span class="post-name">{{$post->users->name}}<p class="post-name-tiny">({{$post->created_at}}) <span
                                                class="post-follow">Follow</span></p></span>
                            </div>
                            <hr>
                            <p class="post-body">{{$post->content}}</p>
                            <hr>
                            <div class="row">
                                @foreach($post->images as $image)
                                    <div class="col-md-4">
                                        <img src="{{asset('img/posts').'/'.$image->url}}" width="100%"
                                             height="200px" style="padding: 10px;">
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
                                <div class="col-sm-6" style="cursor: pointer" id="comment_btn"><i
                                            class="fa fa-comment"></i> @lang('strings.comment')(20)
                                </div>
                                <br><br>
                                <div class="col-sm-12" id="comment_tab" style="display: none;">
                                    <input type="text" name="comment" class="form-control">
                                    <button class="btn btn-primary"
                                            style="margin: 5px 0;">@lang('strings.comment')</button>
                                    <div class="row">
                                        <img src="{{asset('/img/profiles/default.png')}}" class="comment-img">
                                        <span class="comment-name">Ahmed Magdy<p> pla pla pla</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
                    <div id="load_more" style="margin: 10px 49%;">
                        <img src="{{asset('img/loader.gif')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // End Page Content -->
    <script>
        $('#follow').click(function () {
            location.href = '/follow/{{$user->slug}}';
        });
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