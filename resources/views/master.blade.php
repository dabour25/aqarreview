<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>@lang('strings.aqar_review') | {{isset($page)?$page:'ERROR!'}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <!-- External CSS libraries -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-submenu.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/leaflet.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/map.css')}}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/flaticon/flaticon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/linearicons/style.css')}}">
    <link rel="stylesheet" type="text/css"  href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" type="text/css"  href="{{asset('css/dropzone.css')}}">
    <link rel="stylesheet" type="text/css"  href="{{asset('css/slick.css')}}">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="{{asset('css/skins/gold.css')}}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{asset('img/shico.png')}}" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,300,700">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/ie10-viewport-bug-workaround.css')}}">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script  src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script  src="{{asset('js/ie-emulation-modes-warning.js')}}"></script>

	<link rel="stylesheet" type="text/css" href="{{asset('css/edit1.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script  src="js/html5shiv.min.js"></script>
    <script  src="js/respond.min.js"></script>
    <![endif]-->
    @if(app()->getLocale()=='en')
    <style type="text/css">
        @media (max-width:992px){
            ul {
                transform: rotate(180deg);
            }
            ul > li {
                transform: rotate(-180deg);
            }
        }
    </style>
    @endif
</head>
<body>
<div class="page_loader"></div>

<!-- Top header start -->
<header class="top-header" id="top-header-2">
    <div class="container">
        <div class="row">
			@if(isset($links))
            <div class="col-lg-8 col-md-9 col-sm-7">
                <div class="list-inline">
                    <a href="tel:{{$links[0]->value}}"><i class="fa fa-phone"></i>{{$links[0]->value}}</a>
                    @if(!empty($links[1]->value))
                    <a href="mailto:{{$links[1]->value}}"><i class="fa fa-envelope"></i>{{$links[1]->value}}</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-5">
                <ul class="top-social-media pull-right">
                    <li>
                        <a href="{{$links[2]->value}}" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="{{$links[3]->value}}" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                        <a href="{{$links[4]->value}}" class="google" target="_blank"><i class="fa fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
			@endif
        </div>
    </div>
</header>
<!-- Top header end -->

<!-- Main header start -->
<header class="main-header fixed-header-2">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            @if(app()->getLocale()=='ar')
                <a class="lang langbtn" href="lang/{{app()->getLocale()=="ar"?"en":"ar"}}">@lang('strings.langu')<i class="fa fa-language"></i></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
                    <ul class="navbar-nav header-ml">
                        <li class="nav-item dropdown active tinylang">
                            <a class="nav-link" href="lang{{app()->getLocale()=="ar"?"/en":"/ar"}}">
                                @lang('strings.langu')
                            </a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="/contact">
                                @lang('strings.contact')
                            </a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="/ads/create">
                                @lang('strings.add_advertise')
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::guard('admin')->user())
                                @lang('strings.welcome') {{substr(Auth::guard('admin')->user()->email,0,6)}} ..
                                @elseif(Auth::user())
                                    @lang('strings.welcome') {{substr(Auth::user()->name,0,6)}} ..
                                @else
                                @lang('strings.account')
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                @if(!Auth::user()&&!Auth::guard('admin')->user())
                                <li><a class="dropdown-item" href="/log">@lang('strings.login')</a></li>
                                <li><a class="dropdown-item" href="/reg">@lang('strings.register')</a></li>
                                @else
                                @if(Auth::guard('admin')->user())
                                <li><a class="dropdown-item" href="/admindb">@lang('strings.admin_db')</a></li>
                                @else
                                <li><a class="dropdown-item" href="/profile">@lang('strings.profile')</a></li>
                                <li><a class="dropdown-item" href="/userads">@lang('strings.previous_ads')</a></li>
                                <li><a class="dropdown-item" href="/favourites">@lang('strings.favourite')</a></li>
                                @endif
                                <hr>
                                <li><a class="dropdown-item" href="/out">@lang('strings.logout')</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('strings.categories')
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">@lang('strings.rent')</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/rent/1">@lang('strings.apartments')</a></li>
                                        <li><a class="dropdown-item" href="/rent/2">@lang('strings.villas')</a></li>
                                        <li><a class="dropdown-item" href="/rent/5">@lang('strings.shops')</a></li>
                                        <li><a class="dropdown-item" href="/rent/6">@lang('strings.chalets')</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">@lang('strings.sell')</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/sell/1">@lang('strings.apartments')</a></li>
                                        <li><a class="dropdown-item" href="/sell/2">@lang('strings.villas')</a></li>
                                        <li><a class="dropdown-item" href="/sell/3">@lang('strings.lands')</a></li>
                                        <li><a class="dropdown-item" href="/sell/4">@lang('strings.houses')</a></li>
                                        <li><a class="dropdown-item" href="/sell/5">@lang('strings.shops')</a></li>
                                        <li><a class="dropdown-item" href="/sell/6">@lang('strings.chalets')</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="#">
                                @lang('strings.about')
                            </a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="/">
                                @lang('strings.home')
                            </a>
                        </li>
                    </ul>
                </div>
                <a class="lang tinylang langbtn" href="/ads/create">@lang('strings.add_advertise')</a>
                <a class="navbar-brand company-logo" href="/">
                    <img src="{{asset('img/logos/black-logo.png')}}" alt="logo">
                </a>
            @else
                <a class="navbar-brand company-logo" href="/">
                    <img src="{{asset('img/logos/black-logo.png')}}" alt="logo">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav header-ml">
                        <li class="nav-item dropdown active tinylang">
                            <a class="nav-link" href="lang{{app()->getLocale()=="ar"?"/en":"/ar"}}">
                                @lang('strings.langu')
                            </a>
                        </li>

                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="/">
                                @lang('strings.home')
                            </a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="#">
                                @lang('strings.about')
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('strings.categories')
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">@lang('strings.rent')</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/rent/1">@lang('strings.apartments')</a></li>
                                        <li><a class="dropdown-item" href="/rent/2">@lang('strings.villas')</a></li>
                                        <li><a class="dropdown-item" href="/rent/5">@lang('strings.shops')</a></li>
                                        <li><a class="dropdown-item" href="/rent/6">@lang('strings.chalets')</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">@lang('strings.sell')</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/sell/1">@lang('strings.apartments')</a></li>
                                        <li><a class="dropdown-item" href="/sell/2">@lang('strings.villas')</a></li>
                                        <li><a class="dropdown-item" href="/sell/3">@lang('strings.lands')</a></li>
                                        <li><a class="dropdown-item" href="/sell/4">@lang('strings.houses')</a></li>
                                        <li><a class="dropdown-item" href="/sell/5">@lang('strings.shops')</a></li>
                                        <li><a class="dropdown-item" href="/sell/6">@lang('strings.chalets')</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::user())
                                    @lang('strings.welcome') {{substr(Auth::user()->name,0,6)}} ..
                                @else
                                    @lang('strings.account')
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                @if(!Auth::user())
                                    <li><a class="dropdown-item" href="/log">@lang('strings.login')</a></li>
                                    <li><a class="dropdown-item" href="/reg">@lang('strings.register')</a></li>
                                @else
                                    @if(Auth::user()->role=='admin')
                                        <li><a class="dropdown-item" href="/admindb">@lang('strings.admin_db')</a></li>
                                    @else
                                        <li><a class="dropdown-item" href="/profile">@lang('strings.profile')</a></li>
                                        <li><a class="dropdown-item" href="/userads">@lang('strings.previous_ads')</a></li>
                                        <li><a class="dropdown-item" href="/favourites">@lang('strings.favourite')</a></li>
                                    @endif
                                    <hr>
                                    <li><a class="dropdown-item" href="/out">@lang('strings.logout')</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="/ads/create">
                                @lang('strings.add_advertise')
                            </a>
                        </li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="/contact">
                                @lang('strings.contact')
                            </a>
                        </li>
                    </ul>

                </div>
                <a class="lang langbtn" href="lang{{app()->getLocale()=="ar"?"/en":"/ar"}}">@lang('strings.langu')<i class="fa fa-language"></i></a>
                <a class="lang tinylang langbtn" href="/ads/create">@lang('strings.add_advertise')</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @endif
        </nav>
    </div>
</header>
<!-- Main header end -->
@yield('content')

<!-- Intro section start -->
<div class="intro-section">
    <div class="container">
        <div class="row {{app()->getLocale()=='ar'?'ar':''}}">
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="intro-text">
                    <h3>@lang('strings.need_help')</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="/contact" class="btn btn-md">@lang('strings.contact')</a>
            </div>
        </div>
    </div>
</div>
<!-- Intro section end -->

<!-- Footer start -->
<footer class="footer" style="direction: {{app()->getLocale()=='ar'?'ltr':'rtl'}}">
    <div class="container footer-inner">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                <div class="footer-item clearfix">
                    <img src="{{asset('img/logos/logo.png')}}" alt="logo" class="f-logo">
                    <ul class="contact-info">
						@if(isset($links))
                        @if(!empty($links[1]->value))
                        <li>
                            <i class="flaticon-mail"></i><a href="mailto{{$links[1]->value}}">{{$links[1]->value}}</a>
                        </li>
                        @endif
                        <li>
                            <i class="flaticon-phone"></i><a href="tel:{{$links[0]->value}}">{{$links[0]->value}}</a>
                        </li>
						@endif
                    </ul>
                    <div class="clearfix"></div>
                    <div class="social-list-2">
					@if(isset($links))
                        <ul>
                            <li><a href="{{$links[2]->value}}" class="facebook-bg" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{$links[3]->value}}" class="twitter-bg" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{$links[4]->value}}" class="google-bg" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        </ul>
					@endif
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="footer-item {{app()->getLocale()=="ar"?'ar':''}}">
                    <h4 class="footerg">
                        @lang('strings.short_links')
                    </h4>
                    <ul class="links">
                        <li>
                            <a href="/">@lang('strings.home')</a>
                        </li>
                        <li>
                            <a href="#">@lang('strings.about')</a>
                        </li>
                        <li>
                            <a href="#">@lang('strings.terms_conditions')</a>
                        </li>
                        <li>
                            <a href="/contact">@lang('strings.contact')</a>
                        </li>
                        <li>
                            <a href="{{Auth::user()?'/profile':'/log'}}">@lang('strings.account')</a>
                        </li>
                    </ul>
                </div>
            </div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="footer-item {{app()->getLocale()=="ar"?'ar':''}}">
                    <h4 class="footerg">
                        @lang('strings.categories')
                    </h4>
                    <ul class="links">
                        <li>
                            <a href="/cat/5">@lang('strings.shops')</a>
                        </li>
                        <li>
                            <a href="/cat/2">@lang('strings.villas')</a>
                        </li>
                        <li>
                            <a href="/cat/3">@lang('strings.lands')</a>
                        </li>
                        <li>
                            <a href="/cat/1">@lang('strings.apartments')</a>
                        </li>
                        <li>
                            <a href="/cat/4">@lang('strings.houses')</a>
                        </li>
						<li>
                            <a href="/cat/6">@lang('strings.chalets')</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <p class="copy sub-footer" style="text-align: center;direction: {{app()->getLocale()=="ar"?'rtl':'ltr'}}">© {{Date('Y')}} @lang('strings.all_rights') - @lang('strings.aqar_review')</p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer end -->

<script src="{{asset('js/jquery-2.2.0.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script  src="{{asset('js/bootstrap-submenu.js')}}"></script>
<script  src="{{asset('js/rangeslider.js')}}"></script>
<script  src="{{asset('js/jquery.mb.YTPlayer.js')}}"></script>
<script  src="{{asset('js/bootstrap-select.min.js')}}"></script>
<script  src="{{asset('js/jquery.easing.1.3.js')}}"></script>
<script  src="{{asset('js/jquery.scrollUp.js')}}"></script>
<script  src="{{asset('js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script  src="{{asset('js/leaflet.js')}}"></script>
<script  src="{{asset('js/leaflet-providers.js')}}"></script>
<script  src="{{asset('js/leaflet.markercluster.js')}}"></script>
<script  src="{{asset('js/dropzone.js')}}"></script>
<script  src="{{asset('js/slick.min.js')}}"></script>
<script  src="{{asset('js/jquery.filterizr.js')}}"></script>
<script  src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
<script  src="{{asset('js/jquery.countdown.js')}}"></script>
<script  src="{{asset('js/maps.js')}}"></script>
<script  src="{{asset('js/app.js')}}"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script  src="{{asset('js/ie10-viewport-bug-workaround.js')}}"></script>
<!-- Custom javascript -->
<script  src="{{asset('js/ie10-viewport-bug-workaround.js')}}"></script>
</body>
</html>