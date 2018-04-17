<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <script src="{{ asset('./assets/jsLib/jquery/jquery.3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('./assets/jsLib/jquery/jquery1.8.ui.min.js') }}"></script>
    <script src="{{ asset('./assets/jsLib/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('./assets/jsLib/decimal.js') }}"></script>
    <script src="{{ asset('./assets/jsLib/decimal.min.js') }}"></script>
    <link href="{{ asset('./assets/jsLib/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('./assets/jsLib/divsensor/ResizeSensor.js') }}" ></script>
    <script src="{{ asset('./assets/jsLib/divsensor/ElementQueries.js') }}" ></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.5/bootstrap-notify.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

    <style>
        .animate-in {
            -webkit-animation: fadeIn .5s ease-in;
            animation: fadeIn .5s ease-in;
        }
        .animate-out {
            -webkit-transition: opacity .5s;
            transition: opacity .5s;
            opacity: 0;
        }
        @-webkit-keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
<?php
    require_once('../vendor/autoload.php');
    use Iflylabs\iFlyChat;
?>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel navbar-fixed">
        <div class="container nav-div-container">
            <a class="navbar-brand logo" href="{{ url('/') }}">

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li><a class="nav-link" href="{{ url('/') }}">HOME</a></li>
                    <li><a class="nav-link" href="{{ route('portfolios') }}">PORTFOLIOS</a></li>
                    <li><a class="nav-link" href="{{ route('coins') }}">COINS</a></li>
                    <li><a class="nav-link" href="{{ route('news') }}">NEWS</a></li>
                    @guest
                    <li><a class="nav-link sign" href="{{ route('login') }}">LOGIN</a></li>
                    <script>
                        var userId = undefined;
                    </script>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link  sign dropdown-toggle" style="min-width:160px;text-align: center;" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->full_name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-new-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" style="color:white;"  href="{{ route('profile') }}" >{{ __('My Profile') }}</a>
                                <a class="dropdown-item" style="color:white;"  href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <script>
                            var userId = <?php echo \Auth::user()->id; ?>;
                        </script>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 padding0">
        @yield('content')
    </main>
    <div class="div-footer">
        <div class="container">
            <label class="footer-copyright-label">
                <i class="fa fa-copyright"></i>2018 Moonfolio. All rights reserved.
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="a-white" href="{{ route('termsofview') }}">Terms and Conditions</a>
            </label>
            <a  class="footer-backtotop" >
                Back to Top <img src="{{ asset('./assets/images/icon/icon-top.png') }}" />
            </a>
        </div>
    </div>
</div>
<style>
    .a-white:hover {
        color: gold;
        text-decoration: none;
    }

    a:hover {
        color: #0056b3;
        text-decoration: underline;
    }
    .alert-danger {
        background-color: #0297bf;
        color: white;
        font-family: Montserrat-Hairline;
        font-size: 16px;
        border:none;;
        width: 320px;
    }
    .message {
        font-family: Montserrat-Light;
        font-size: 16px;
        color: white;
    }
    .alert-title {
        font-family: Montserrat-Regular;
        font-size: 18px;
    }
    .close {
        color: #fff;
    }
</style>
</body>
</html>
<audio id="notification">
    <source src="{{ asset('./assets/mp3/notification.mp3') }}" type="audio/mp3" >
</audio>
<script>
$(document).ready(function(){
    if ( userId != undefined ) {
        alertNotify();
        window.setInterval(function(){
            alertNotify();
        }, 60000);

    }
    var wH = parseFloat($(window)[0].innerHeight);
    var yieldH = parseFloat($('.py-4').height());

    if ( wH >= (yieldH+100) || wH == yieldH ){
        $('.py-4').css('height', (wH-100)+'px');
        $('.container-fluid').css('height', '100%');
    }

    $('.footer-backtotop').click(function(){
        $('html, body').animate({
            scrollTop: $("#home").offset().top
        }, 2000);
    });
});

window.addEventListener("beforeunload", function () {
    document.body.classList.add("animate-out");
});

function alertNotify(){
    $.get('/pricealert', function(alert_coins){
        for( i in alert_coins ) {
            notification(alert_coins[i]);
        }
    });
}
var x = document.getElementById("notification");
function notification(coin_data) {
    message = '<br/><img src="https://files.coinmarketcap.com/static/widget/coins_legacy/32x32/'+coin_data.coin_id+'.png" width="32px" height="32px" />';
    message += '<label class="message">&nbsp;&nbsp;'+coin_data.coin_name+'('+coin_data.symbol+')'+'</label>&nbsp;&nbsp;&nbsp;';
    message += '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="message">Current Price: $'+coin_data.current_price+'</label>';
    $.notify({
        title: '<label class="message alert-title">PRICE ALERT!</label>',
        icon: '',
        message: message
    }, {
        type: 'danger',
        animate: {
            enter: 'animated fadeInUp',
            exit: 'animated fadeOutRight'
        },
        placement: {
            from: "bottom",
            align: "left"
        },
        offset: 20,
        spacing: 10,
//        showProgressbar: true,
        z_index: 1031,
        delay: 0,
        timer: 1000,
        onShow: function(){
            x.play();
        }
    });
}
</script>

@guest
@else
    <?php
        $APP_ID = '8844c3c4-e7d9-4533-adf8-7d3dc04b474b';
        $API_KEY = 'CRE_W2ZQuFUunU7fNqoMjWKPFmLh4JT71gypY3hO4SoW63429';
        $iflychat = new iFlyChat($APP_ID, $API_KEY);
        $user = array(
                'user_name' => \Auth::user()->full_name, // string(required)
                'user_id' => \Auth::user()->id, // string (required)
                'is_admin' => FALSE, // boolean (optional)
                'user_avatar_url' => \Auth::user()->user_avatar, // string (optional)
                'user_profile_url' => 'user-profile-link', // string (optional)
        );

        //$iflychat->setUser($user);
        $iflychat_code = $iflychat->getHtmlCode();
        print $iflychat_code;
    ?>
@endguest