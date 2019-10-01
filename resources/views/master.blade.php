@if(!Session::has('lang'))
<!DOCTYPE html>
<html lang="ar">
<head>
    <title>AQAR REVIEW | {{isset($page)?$page:'ERROR!'}}</title>
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
            <a class="lang langbtn" href="/en">English <i class="fa fa-language"></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
                <ul class="navbar-nav header-ml">
                    <li class="nav-item dropdown active tinylang">
                        <a class="nav-link" href="/en">
                            English
                        </a>
                    </li>
					<li class="nav-item dropdown active">
                        <a class="nav-link" href="/contact">
                            تواصل معنا
                        </a>
                    </li>
					<li class="nav-item dropdown active">
                        <a class="nav-link" href="/addnew">
                            أضف إعلان
                        </a>
                    </li>
					<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(Auth::user())
                            مرحباً {{substr(Auth::user()->name,0,6)}} ..
                            @else
                            الحساب
                            @endif
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if(!Auth::user())
                            <li><a class="dropdown-item" href="/log">تسجيل دخول</a></li>
                            <li><a class="dropdown-item" href="/reg">تسجيل مستخدم جديد</a></li>
                            @else
                            @if(Auth::user()->role=='admin')
                            <li><a class="dropdown-item" href="/admindb">الإدارة</a></li>
                            @else
                            <li><a class="dropdown-item" href="/profile">الملف الشخصى</a></li>
                            <li><a class="dropdown-item" href="/userads">إعلاناتك السابقة</a></li>
                            <li><a class="dropdown-item" href="/favourites">المفضلة</a></li>
                            @endif
                            <hr>
                            <li><a class="dropdown-item" href="/out">تسجيل خروج</a></li>
                            @endif
                        </ul>
                    </li>
					<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            الأقسام
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">إيجار</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/rent/1">شقق</a></li>
                                    <li><a class="dropdown-item" href="/rent/2">فيلات</a></li>
                                    <li><a class="dropdown-item" href="/rent/5">محلات تجارية</a></li>
                                    <li><a class="dropdown-item" href="/rent/6">شاليهات</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">شراء</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/sell/1">شقق</a></li>
                                    <li><a class="dropdown-item" href="/sell/2">فيلات</a></li>
                                    <li><a class="dropdown-item" href="/sell/3">اراضى</a></li>
                                    <li><a class="dropdown-item" href="/sell/4">بيوت</a></li>
                                    <li><a class="dropdown-item" href="/sell/5">محلات تجارية</a></li>
                                    <li><a class="dropdown-item" href="/sell/6">شاليهات</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
					<li class="nav-item dropdown active">
                        <a class="nav-link" href="#">
                            عنا
                        </a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link" href="/">
                            الصفحة الرئيسية
                        </a>
                    </li>
                </ul>
            </div>
            <a class="lang tinylang langbtn" href="/addnew">أضف إعلان</a>
			<a class="navbar-brand company-logo" href="/">
                <img src="{{asset('img/logos/black-logo.png')}}" alt="logo">
            </a>
        </nav>
    </div>
</header>
<!-- Main header end -->
@yield('content')

<!-- Intro section start -->
<div class="intro-section">
    <div class="container">
        <div class="row ar">
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="intro-text">
                    <h3>تحتاج لمساعدة ؟</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="/contact" class="btn btn-md">تواصل</a>
            </div>
        </div>
    </div>
</div>
<!-- Intro section end -->

<!-- Footer start -->
<footer class="footer">
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
                <div class="footer-item ar">
                    <h4 class="footerg">
                        روابط مختصرة
                    </h4>
                    <ul class="links">
                        <li>
                            <a href="/">الصفحة الرئيسية</a>
                        </li>
                        <li>
                            <a href="#">عنا</a>
                        </li>
                        <li>
                            <a href="#">الشروط والأحكام</a>
                        </li>
                        <li>
                            <a href="/contact">تواصل معنا</a>
                        </li>
                        <li>
                            <a href="{{Auth::user()?'/profile':'/log'}}">الحساب</a>
                        </li>
                    </ul>
                </div>
            </div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="footer-item ar">
                    <h4 class="footerg">
                        تصنيفات
                    </h4>
                    <ul class="links">
                        <li>
                            <a href="/cat/5">محلات</a>
                        </li>
                        <li>
                            <a href="/cat/2">فيلات</a>
                        </li>
                        <li>
                            <a href="/cat/3">أراضى</a>
                        </li>
                        <li>
                            <a href="/cat/1">شقق</a>
                        </li>
                        <li>
                            <a href="/cat/4">بيوت</a>
                        </li>
						<li>
                            <a href="/cat/6">شاليهات</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <p class="copy sub-footer ar" style="text-align: center;">© {{Date('Y')}} كل الحقوق محفوظة - عقار ريفيو</p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer end -->

<!-- Full Page Search -->
<div id="full-page-search">
    <button type="button" class="close">×</button>
    <form action="index.html#">
        <input type="search" value="" placeholder="type keyword(s) here" />
        <button type="submit" class="btn btn-sm button-theme">Search</button>
    </form>
</div>

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


@else
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>AQAR REVIEW | {{isset($page)?$page:'ERROR!'}}</title>
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
                    <!--<a href="tel:info@themevessel.com"><i class="flaticon-pin"></i>Mon - Sun: 8:00am - 6:00pm</a>-->
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
            <a class="navbar-brand company-logo" href="/">
                <img src="{{asset('img/logos/black-logo.png')}}" alt="logo">
            </a>
            <a class="lang tinylang langbtn" href="/addnew">Add Advertise</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse menuen" id="navbarSupportedContent">
                <ul class="navbar-nav header-ml">
                    <li class="nav-item dropdown active">
                        <a class="nav-link" href="/">
                            Home
                        </a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link" href="#">
                            About
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Rent</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/rent/1">Apartments</a></li>
                                    <li><a class="dropdown-item" href="/rent/2">Villas</a></li>
                                    <li><a class="dropdown-item" href="/rent/5">Shops</a></li>
                                    <li><a class="dropdown-item" href="/rent/6">Chalets</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Buy</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/sell/1">Apartments</a></li>
                                    <li><a class="dropdown-item" href="/sell/2">Villas</a></li>
                                    <li><a class="dropdown-item" href="/sell/3">Lands</a></li>
                                    <li><a class="dropdown-item" href="/sell/4">Homes</a></li>
                                    <li><a class="dropdown-item" href="/sell/5">Shops</a></li>
                                    <li><a class="dropdown-item" href="/sell/6">Chalets</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(Auth::user())
                            Welcome {{substr(Auth::user()->name,0,6)}} ..
                            @else
                            Account
                            @endif
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if(!Auth::user())
                            <li><a class="dropdown-item" href="/log">Login</a></li>
                            <li><a class="dropdown-item" href="/reg">Register</a></li>
                            @else
                            @if(Auth::user()->role=='admin')
                            <li><a class="dropdown-item" href="/admindb">Admin DB</a></li>
                            @else
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a class="dropdown-item" href="/userads">Your Ads</a></li>
                            <li><a class="dropdown-item" href="/favourites">Favourites</a></li>
                            @endif
                            <hr>
                            <li><a class="dropdown-item" href="/out">Logout</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/addnew">
                            Add Advertise
                        </a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link" href="/contact">
                            Contact
                        </a>
                    </li>
                    <li class="nav-item dropdown active tinylang">
                        <a class="nav-link" href="/ar">
                            عربى
                        </a>
                    </li>
                </ul>
            </div>
            <a class="lang langbtn" href="/ar"><i class="fa fa-language" style="padding-right: 3px;"></i>عربى</a>
        </nav>
    </div>
</header>
<!-- Main header end -->
@yield('content')
<!-- Intro section start -->
<div class="intro-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="intro-text">
                    <h3>Need Help ?</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <a href="/contact" class="btn btn-md">Contact..</a>
            </div>
        </div>
    </div>
</div>
<!-- Intro section end -->

<!-- Footer start -->
<footer class="footer">
    <div class="container footer-inner">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="footer-item clearfix">
                    <img src="{{asset('img/logos/logo.png')}}" alt="logo" class="f-logo">
                    <ul class="contact-info">
					@if(isset($links))
                        @if(!empty($links[1]->value))
                        <li>
                            <i class="flaticon-mail"></i><a href="mailto:{{$links[1]->value}}">{{$links[1]->value}}</a>
                        </li>
                        @endif
                        <li>
                            <i class="flaticon-phone"></i><a href="tel:{{$links[0]->value}}">{{$links[0]->value}}</a>
                        </li>
					@endif
                    </ul>
                    <div class="clearfix"></div>
                    <div class="social-list-2">
                        <ul>
							@if(isset($links))
                            <li><a href="{{$links[2]->value}}" class="facebook-bg" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{$links[3]->value}}" class="twitter-bg" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{$links[4]->value}}" class="google-bg" target="_blank"><i class="fa fa-instagram"></i></a></li>
							@endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="footer-item">
                    <h4 class="footerg">
                        Short Links
                    </h4>
                    <ul class="links">
                        <li>
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="#">About Us</a>
                        </li>
                        <li>
                            <a href="#">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="/contact">Contact Us</a>
                        </li>
                        <li>
                            <a href="{{Auth::user()?'/profile':'/log'}}">Account</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="footer-item">
                    <h4 class="footerg">
                        Categories
                    </h4>
                    <ul class="links">
                        <li>
                            <a href="/cat/5">Shops</a>
                        </li>
                        <li>
                            <a href="/cat/2">Villas</a>
                        </li>
                        <li>
                            <a href="/cat/3">Lands</a>
                        </li>
                        <li>
                            <a href="/cat/1">Apartments</a>
                        </li>
                        <li>
                            <a href="/cat/4">Houses</a>
                        </li>
                        <li>
                            <a href="/cat/6">Chalets</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <p class="copy sub-footer">© {{Date('Y')}} All Right Reserved- Aqar Review</p>
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
@endif