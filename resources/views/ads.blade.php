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
    <h3 class="title">{{app()->getLocale()=='ar'?$pagear:$page}}</h3>
    <!-- Search area 3 start -->
    <div class="{{app()->getLocale()=='ar'?'ar':''}}">
        <div class="container">
            <div class="inline-search-area">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                        <input type="text" class="form-control" placeholder="@lang('strings.search_string')" id="search" value="{{isset($search)&&$search!='all'?$search:''}}">
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6 form-group">
                        <select class="selectpicker search-fields" id="type">
                            <option value="all" {{isset($type)&&$type=="all"?'selected':''}}>@lang('strings.type')</option>
                            <option value="1" {{isset($type)&&$type=="1"?'selected':''}}>@lang('strings.buy')</option>
                            <option value="2" {{isset($type)&&$type=="2"?'selected':''}}>@lang('strings.rent')</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6 form-group">
                        <div class="range-slider">
                            <div data-min="0" data-max="10000000"  data-min-name="min" data-max-name="max" data-unit="@lang('strings.le')" class="range-slider-ui ui-slider" aria-disabled="false"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 form-group">
                        <button class="btn button-theme btn-search btn-block" id="searchbtn">
                            <i class="fa fa-search"></i><strong> @lang('strings.search') </strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#searchbtn').click(function(){
            if($('#search').val()==''){
                $('#search').val('all');
            }
            location.href='/search/'+$('#search').val()+'/'+$('#type').val()+'/'+$('[name=min]').val()+'/'+$('[name=max]').val();
        });
    </script>
    <!-- Search area 3 end -->
    <!-- Featured Properties start -->
    <div class="featured-properties content-area-14" style="padding-top:40px;">
        <div class="container ar">
            <div class="row">
                @foreach($ads as $n)
                    <div class="col-lg-4 col-md-6">
                        <div class="property-box">
                            <div class="property-thumbnail">
                                <div class="property-img">
                                    <div class="tag {{Auth::user()?'':'tagdis'}}">
                                        <?php
                                        $fa=false;
                                        foreach ($fav as $f) {
                                            if($f->ad==$n->id){
                                                $fa=true;
                                            }
                                        }
                                        ?>
                                        @if(!$fa)
                                            <i id="fav{{$n->id}}" class="fa fa-star-o star" title="@lang('strings.add_to_favourite')"></i>
                                        @else
                                            <i id="fav{{$n->id}}" class="fa fa-star star" title="@lang('strings.remove_from_favourite')"></i>
                                        @endif
                                    </div>
                                    <div class="price-box"><span>{{$n->price}}@lang('strings.le')</span> {{$n->general_type=='rent'?trans('strings.per_month'):''}}</div>
                                    @if($n->image=='')
                                        <img class="d-block w-100" src="{{asset('img/ads')}}/{{$links[5]->value}}" style="height: 330px;object-fit: contain">
                                    @else
                                        <img class="d-block w-100" src="{{asset('/img/ads')}}/{{$n->image}}" style="height: 330px;object-fit: contain">
                                    @endif
                                </div>
                            </div>
                            <div class="detail">
                                <h1 class="title">
                                    <a href="/ad/{{$n->id}}" target="blank">{{$n->title}}</a>
                                </h1>
                                <div class="location">
                                    <a href="/ad/{{$n->id}}" target="blank">
                                        <i class="flaticon-pin">{{$n->address}}</i>
                                    </a>
                                </div>
                                <ul class="facilities-list clearfix">
                                    @if($n->type==3)
                                        <li>
                                            <i class="flaticon-ui"></i>@lang('strings.meter') {{$n->size}}
                                        </li>
                                    @else
                                        <li>
                                            <i class="flaticon-bed"></i>@lang('strings.rooms'):  {{$n->rooms}}
                                        </li>
                                        <li>
                                            <i class="flaticon-bathroom"></i>@lang('strings.bathrooms'): {{$n->pathroom}}
                                        </li>
                                        <li>
                                            <i class="flaticon-ui"></i>@lang('strings.meter') {{$n->size}}
                                        </li>
                                        <li>
                                            <i class="flaticon-car"></i> {{$n->parking==1?trans('strings.park'):trans('strings.no_park')}}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $('#fav{{$n->id}}').click(function(){
                            $.ajax({
                                type:'GET',
                                url:'/fav/{{$n->id}}',
                                success:function(data) {
                                    if(data.type==1){
                                        $('#fav{{$n->id}}').removeClass("fa-star-o");
                                        $('#fav{{$n->id}}').addClass("fa-star");
                                        $('#fav{{$n->id}}').prop('title', 'Remove from favourites');
                                    }else if(data.type==2){
                                        $('#fav{{$n->id}}').removeClass("fa-star");
                                        $('#fav{{$n->id}}').addClass("fa-star-o");
                                        $('#fav{{$n->id}}').prop('title', 'Add to favourites');
                                    }
                                    alert(data.msg);
                                }
                            });
                        });
                    </script>
                @endforeach
            </div>
            {{ $ads->links() }}
        </div>
    </div>
    <!-- Featured Properties end -->
    <!-- // End Page Content -->
@stop