@extends('layouts.frontend')

@section('content')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.2/particles.min.js"></script>
    <script src="{{ asset('./assets/jsLib/modernizer-1.6.min.js') }}"></script>
    <script>
        var top_users_count = {{ count($top_users) }};
    </script>
<style>
.panel-body{
    margin-top:0;
    width: 80%;
    border-radius: 0;
    margin-bottom: 8px;
    padding:20px 15px;
}
a[href="#collapse2"], #collapse2 .panel-body,a[href="#collapse4"], #collapse4 .panel-body,a[href="#collapse6"], #collapse6 .panel-body {
    left: 20%;
    position: relative;
}
/**********************************************    Carousel Start   ************************************************/
.wrapper{
    width:100%;
    position:relative;
    margin:5% auto 0;
}
.carousel{
    width: 100%;
    position: relative;
    padding-top: 380px;
    overflow: hidden;
}
.inner{
    width: 100%;
    height: 100%;
    position: absolute;
    top:0;
    left: 0;
}
.slide{
    width: 100%;
    height: 100%;
    position: absolute;
    top:0;
    right:0;
    left:0;
    z-index: 1;
    opacity: 0;
}
.slide.active,
.slide.left,
.slide.right{
    z-index: 2;
    opacity: 1;
}
.js-reset-left{left:auto}
.slide.left{
    left:-100%;
    right:0;
}
.slide.right{
    right:-100%;
    left: auto;
}
.transition .slide.left{left:0%}
.transition .slide.right{right:0%}
.transition .slide.shift-right{right: 100%;left:auto}
.transition .slide.shift-left{left: 100%;right:auto}
.transition .slide{
    transition-property: right, left, margin;
}
.indicators{
    width:100%;
    position: absolute;
    bottom: 0;
    z-index: 4;
    padding:0;
    text-align: center;
}
.indicators li{
    width: 13px;
    height: 13px;
    display: inline-block;
    margin: 5px;
    background: #fff;
    list-style-type: none;
    border-radius: 50%;
    cursor:pointer;
    transition:background 0.3s ease-out;
}
.indicators li.active{background:#0297df}
.indicators li:hover{background-color:#2b2b2b}
.arrow{
    width: 20px;
    height: 20px;
    position:absolute;
    top:49%;
    z-index:5;
    border-top:3px solid #fff;
    border-right:3px solid #fff;
    cursor:pointer;
    transition:border-color 0.3s ease-out;
}
.arrow:hover{border-color:#0297df}
.arrow-left{
    left:20px;
    transform:rotate(225deg);
}
.arrow-right{
    right:20px;
    transform:rotate(45deg);
}
.slide{
    text-align:center;
    /*padding-top:25%;*/
    background-size:cover;
}
h1{
    width:100px;
    height:100px;
    background-color:rgba(2, 151, 223,0.7);
    margin:auto;
    line-height:100px;
    color:#fff;
    font-size:2.4em;
    border-radius:50%;
}
.slide:nth-child(1){
    /*background-image:url(http://mamiskincare.net/wp-content/uploads/2015/11/inspire-fashion-ideas-for-styleator-concept-with-fashion-style-for-fall-2015-with-street-style-at-stockholm-fashion-week-fall-winter-2015-2016-15.jpg);*/
}
/*.slide:nth-child(2){*/
    /*background-image:url(http://conversationsabouther.net/wp-content/uploads/2015/03/1-seoul-fashion-week-fall-2015-street-style-45.jpg);*/
/*}*/
/*.slide:nth-child(3){*/
    /*background-image:url(https://dosenyc.files.wordpress.com/2015/08/eleonora-sebastiani-and-roberto-mararo.jpg);*/
/*}*/
/*.slide:nth-child(4){*/
    /*background-image:url(https://dosenyc.files.wordpress.com/2015/08/eleonora-sebastiani-and-roberto-mararo.jpg);*/
/*}*/
/*.slide:nth-child(5){*/
    /*background-image:url(https://dosenyc.files.wordpress.com/2015/08/eleonora-sebastiani-and-roberto-mararo.jpg);*/
/*}*/
/**********************************************    Carousel  End    ************************************************/
    .div-pd-lr{
        padding-left:50px;padding-right:50px;
    }
    .a-review-user{
        color: white;
        font-family: Montserrat-Light;
        font-size: 20px;
        font-weight: bold;
    }
    .a-review-user:hover {
        text-decoration: none;
        color: gold;
    }
</style>
<script>
    var logo_img = "{{ asset('./assets/images/background/black_logo.png') }}";
</script>
@if ( $alert_message != 'sent' )
    <script> var alert_message = '<?php echo $alert_message; ?>';</script>
@else
    <script> var alert_message = undefined; </script>
@endif
    <div class="container-fluid padding0">
        <div class="div-home" id="home">
            <div class="container">
                {{--<canvas id="canvas"></canvas>--}}
                <div class="row">
                    @guest
                        <div class="col-xs-12 col-sm-5 div-title">
                            <label class="home-label jointhe">JOIN THE</label>
                            <label class="home-label community">COMMUNITY</label>
                            <label class="home-label lets">AND LETS GO TO THE</label>
                            <label class="home-label moon">MOON!</label>
                            <div class="div-button-wrap">
                                <a href="{{ route('register') }}" class="nav-link a-link sign text-center">NEW PORTFOLIO</a>
                            </div>
                        </div>
                    @else
                        <div class="col-xs-12 col-sm-5 div-title" style="padding-top: 120px;">
                            <label class="home-label jointhe">JOIN THE</label>
                            <label class="home-label community">COMMUNITY</label>
                            <label class="home-label lets">AND LETS GO TO THE</label>
                            <label class="home-label moon">MOON!</label>
                        </div>
                    @endguest
                    <div class="col-xs-12 col-sm-7 text-right">
                        {{--<canvas id="canvasOne" width="500" height="500">--}}
                        {{--Your browser does not support HTML5 Canvas.--}}
                        {{--</canvas>--}}
                        <canvas id="particles-js" width="800" height="800"></canvas>
                        <canvas id="myCanvas" width="800" height="800"></canvas>
                        <div class="smartObject"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="div-topportios">
            <div class="container">
                <div class="div-top-title">
                    <label class="home-label top">TOP</label>
                    <label class="home-label community port" style="margin-bottom:10px;margin-top: -42px;">PORTFOLIOS</label>
                </div>
                <div class="row">
                    <div class="col-md-12" id="div_top_users_wrap">
                        @if ( $top_users )
                            <div class="row" id="top_users_prev">
                            @for($i=0;$i<4;$i++)
                                @if (isset($top_users[$i]))
                                    <div class="col-sm-3 div-avatar-panel" onclick="doOnGoUserPortfolio({{ $top_users[$i]['id'] }})">
                                        <div class="div-avatar-bg text-center">
                                            <div class="div-numeric">
                                                {{ $i+1 }}
                                            </div>
                                            <div class="div-avatar-icon" style="width:90px;height:90px;margin-bottom:5px;">
                                                <img src="{{ $top_users[$i]['avatar'] }}" style="border-radius: 50%;">
                                            </div>
                                            <div class="div-user-name">{{ $top_users[$i]['full_name'] }}</div>
                                        </div>
                                        <div class="div-white-wrap text-center">
                                            <div class="div-panel-icon-wrap">
                                                <div class="div-panel-icon-wrap">
                                                    <img src="{{ asset('./assets/images/icon/top_portfolio_invested_capital.png') }}" />
                                                </div>
                                            </div>
                                            <div class="div-panel-title">INVESTED CAPITAL</div>
                                            <div class="div-panel-money">${{ number_format($top_users[$i]['total_cost'], 2, '.',',') }}</div>
                                        </div>
                                        <div class="div-white-wrap text-center">
                                            <div class="div-panel-icon-wrap">
                                                <div class="div-panel-icon-wrap">
                                                    <img src="{{ asset('./assets/images/icon/top_portfolio_current_value.png') }}" />
                                                </div>
                                            </div>
                                            <div class="div-panel-title">CURRENT VALUE</div>
                                            <div class="div-panel-money">${{ number_format($top_users[$i]['current_value'], 2, '.', ',') }}</div>
                                        </div>
                                        <div class="div-white-wrap text-center">
                                            <div class="div-panel-icon-wrap">
                                                <div class="div-panel-icon-wrap">
                                                    <img src="{{ asset('./assets/images/icon/top_portfolio_profit_loss.png') }}" />
                                                </div>
                                            </div>
                                            <div class="div-panel-title">PROFIT/ LOSS</div>
                                            <div class="div-panel-money">{{ $top_users[$i]['total_profit_loss_percentage'] }}%</div>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                            </div>
                            @if ( count($top_users) > 4 )
                                <div class="row" id="top_users_next">
                                @for($i=4;$i<8;$i++)
                                    @if (isset($top_users[$i]))
                                        <div class="col-sm-3 div-avatar-panel" onclick="doOnGoUserPortfolio({{ $top_users[$i]['id'] }})">
                                            <div class="div-avatar-bg text-center">
                                                <div class="div-numeric">
                                                    {{ $i+1 }}
                                                </div>
                                                <div class="div-avatar-icon" style="width:90px;height:90px;margin-bottom:5px;">
                                                    <img src="{{ $top_users[$i]['avatar'] }}" style="border-radius: 50%;">
                                                </div>
                                                <div class="div-user-name">{{ $top_users[$i]['full_name'] }}</div>
                                            </div>
                                            <div class="div-white-wrap text-center">
                                                <div class="div-panel-icon-wrap">
                                                    <div class="div-panel-icon-wrap">
                                                        <img src="{{ asset('./assets/images/icon/top_portfolio_invested_capital.png') }}" />
                                                    </div>
                                                </div>
                                                <div class="div-panel-title">INVESTED CAPITAL</div>
                                                <div class="div-panel-money">${{ number_format($top_users[$i]['total_cost'], 2, '.',',') }}</div>
                                            </div>
                                            <div class="div-white-wrap text-center">
                                                <div class="div-panel-icon-wrap">
                                                    <div class="div-panel-icon-wrap">
                                                        <img src="{{ asset('./assets/images/icon/top_portfolio_current_value.png') }}" />
                                                    </div>
                                                </div>
                                                <div class="div-panel-title">CURRENT VALUE</div>
                                                <div class="div-panel-money">${{ number_format($top_users[$i]['current_value'], 2, '.', ',') }}</div>
                                            </div>
                                            <div class="div-white-wrap text-center">
                                                <div class="div-panel-icon-wrap">
                                                    <div class="div-panel-icon-wrap">
                                                        <img src="{{ asset('./assets/images/icon/top_portfolio_profit_loss.png') }}" />
                                                    </div>
                                                </div>
                                                <div class="div-panel-title">PROFIT/ LOSS</div>
                                                <div class="div-panel-money">{{ $top_users[$i]['total_profit_loss_percentage'] }}%</div>
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row div-sep">
                    @if ( count($top_users)>4 )
                    <div class="col-sm-12 text-right">
                        <button type="button" id="btn_prev" class="btn-action" onclick="doOnTopUsersclick('prev')"></button>
                        <button type="button" id="btn_next" class="btn-action" onclick="doOnTopUsersclick('next')"></button>
                    </div>
                    @endif
                </div>
            </div>

        </div>
        <div class="div-features">
            <div class="container">
                <div class="div-top-title">
                    <label class="home-label top">COMPREHENSIVE</label>
                    <label class="home-label community port label-features">FEATURES</label>
                    <label class="home-label label-take">TAKE YOUR PORTFOLIO TO THE MOON!</label>
                </div>
                <div class="row div-features-wrap">
                    <div class="col-sm-6">
                        <img src="{{ asset('./assets/images/background/i-mac1.png') }}" class="features-img" width="600px">
                    </div>
                    <div class="col-sm-6 features-right-buttun-wrap" style="padding-left: 100px;">
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ asset('./assets/images/icon/icon-chart.png') }}" class="media-object" >
                            </div>
                            <div class="media-body" style="padding-left:15px;margin-top: -5px;">
                                <h4 class="media-heading icon-main white-text">CHART</h4>
                                <p class="white-text" style="font-size: 16px;">Candlestick charts and more.</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ asset('./assets/images/icon/icon-news.png') }}" class="media-object" >
                            </div>
                            <div class="media-body" style="padding-left:15px;margin-top: -5px;">
                                <h4 class="media-heading icon-main white-text">NEWS</h4>
                                <p class="white-text" style="font-size: 16px;">Get the latest news updates about cryptocurrencies.</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ asset('./assets/images/icon/icon-coins.png') }}" class="media-object" >
                            </div>
                            <div class="media-body" style="padding-left:15px;margin-top: -5px;">
                                <h4 class="media-heading icon-main white-text">COINS</h4>
                                <p class="white-text" style="font-size: 16px;">All your cryptocurrencies investments at one place.</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ asset('./assets/images/icon/icon-fiat.png') }}" class="media-object" >
                            </div>
                            <div class="media-body" style="padding-left:15px;margin-top: -5px;">
                                <h4 class="media-heading icon-main white-text">CHAT</h4>
                                <p class="white-text" style="font-size: 16px;padding-right:20px;">Communicate with each other about crypto currencies.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="div-topcryptos">
            <div class="container">
                <div class="div-top-title">
                    <label class="home-label top">TOP</label>
                    <label class="home-label community port" style="font-size:108px;margin-bottom:10px;margin-top: -42px;">CRYPTOS</label>
                </div>
                <div class="row">
                    <div class="col-md-12" id="div_coins_wrap">
                        <div class="row" id="top_cryptos_prev">
                            @for($i=0;$i<4;$i++)
                                <div class="col-sm-3 div-avatar-panel" onclick="doOnGoCoinDetailInfo('{{ $topCryptos[$i]['id'] }}')">
                                    <div class="div-avatar-bg text-center">
                                        <div class="div-numeric">
                                            {{ $i+1 }}
                                        </div>
                                        <div class="div-avatar-icon">
                                            <img src="{{ "https://files.coinmarketcap.com/static/widget/coins_legacy/64x64/{$topCryptos[$i]['id']}.png" }}" width="60px" height="60px" style="border-radius:50%;">
                                        </div>
                                        <div class="div-user-name">{{ $topCryptos[$i]['name']."({$topCryptos[$i]['symbol']})" }}</div>
                                        <div class="div-user-name div-subtitle">{{ $topCryptos[$i]['price_usd']."USD({$topCryptos[$i]['percent_change_1h']}%)" }}</div>
                                    </div>
                                    <div class="div-white-wrap text-center">
                                        <div class="div-panel-icon-wrap">
                                            <img src="{{ asset('./assets/images/icon/top_crypto_rank.png') }}" />
                                        </div>
                                        <div class="div-panel-title">RANK</div>
                                        <div class="div-panel-money">{{ $i+1 }}</div>
                                    </div>
                                    <div class="div-white-wrap text-center">
                                        <div class="div-panel-icon-wrap">
                                            <img src="{{ asset('./assets/images/icon/top_crypto_market_cap.png') }}" />
                                        </div>
                                        <div class="div-panel-title">MARKET CAP</div>
                                        <div class="div-panel-money">${{ number_format($topCryptos[$i]['market_cap_usd'], 2, '.',',') }}</div>
                                    </div>
                                    <div class="div-white-wrap text-center">
                                        <div class="div-panel-icon-wrap">
                                            <img src="{{ asset('./assets/images/icon/top_crypto_24h.png') }}" />
                                        </div>
                                        <div class="div-panel-title">VOLUME 24H</div>
                                        <div class="div-panel-money">${{ number_format($topCryptos[$i]['24h_volume_usd'], 2, '.',',') }}</div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="row" id="top_cryptos_next">
                            @for($i=4;$i<8;$i++)
                                <div class="col-sm-3 div-avatar-panel" onclick="doOnGoCoinDetailInfo('{{ $topCryptos[$i]['id'] }}')">
                                    <div class="div-avatar-bg text-center">
                                        <div class="div-numeric">
                                            {{ $i+1 }}
                                        </div>
                                        <div class="div-avatar-icon">
                                            <img src="{{ "https://files.coinmarketcap.com/static/widget/coins_legacy/64x64/{$topCryptos[$i]['id']}.png" }}" width="60px" height="60px" style="border-radius:50%;">
                                        </div>
                                        <div class="div-user-name">{{ $topCryptos[$i]['name']."({$topCryptos[$i]['symbol']})" }}</div>
                                        <div class="div-user-name div-subtitle">{{ $topCryptos[$i]['price_usd']."USD({$topCryptos[$i]['percent_change_1h']}%)" }}</div>
                                    </div>
                                    <div class="div-white-wrap text-center">
                                        <div class="div-panel-icon-wrap">
                                            <img src="{{ asset('./assets/images/icon/top_crypto_rank.png') }}" />
                                        </div>
                                        <div class="div-panel-title">RANK</div>
                                        <div class="div-panel-money">{{ $i+1 }}</div>
                                    </div>
                                    <div class="div-white-wrap text-center">
                                        <div class="div-panel-icon-wrap">
                                            <img src="{{ asset('./assets/images/icon/top_crypto_market_cap.png') }}" />
                                        </div>
                                        <div class="div-panel-title">MARKET CAP</div>
                                        <div class="div-panel-money">${{ number_format($topCryptos[$i]['market_cap_usd'], 2, '.',',') }}</div>
                                    </div>
                                    <div class="div-white-wrap text-center">
                                        <div class="div-panel-icon-wrap">
                                            <img src="{{ asset('./assets/images/icon/top_crypto_24h.png') }}" />
                                        </div>
                                        <div class="div-panel-title">VOLUME 24H</div>
                                        <div class="div-panel-money">${{ number_format($topCryptos[$i]['24h_volume_usd'], 2, '.',',') }}</div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="row div-sep">
                    <div class="col-sm-12 text-right">
                        <button type="button" id="btn_prev" class="btn-action" onclick="doOnclick('prev')"></button>
                        <button type="button" id="btn_next" class="btn-action" onclick="doOnclick('next')"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="div-faq">
            <div class="container">
                <div class="div-top-title">
                    <label class="home-label community faq text-center">FAQ</label>
                    <label class="home-label faq-subtitle text-center" >HERE IS OUR MOST FREQUENTLY QUESTIONS ASKED AND ANSWERS.</label>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Which currencies do you offer?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        We offer all coins listed on <a href="https://coinmarketcap.com" target="_blank" style="color:gold;">coinmarketcap.com</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Is there a mobile version?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        At the moment there is no mobile version, but there will be in future.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Could we communicate inside Moonfolio?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Yes, we have an chat room where we can talk and share our opinions about crypto’s.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Are there price alerts?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Yes, you can set an price alert and you will receive an email or audio alert once your price strike has been hit.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Could I trade from Moonfolio?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Not yet, but we will add this in future.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Is the pricing real time?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse6" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Yes, it will be update every seconds.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="div-clienttest">
            <div class="container">
                <div class="div-top-title">
                    <label class="home-label top">CLIENT</label>
                    <label class="home-label community port" style="margin-top: -42px;">TESTIMONIALS</label>
                </div>
                <div class="row" style="padding-top: 0;">
                    <div class="wrapper">
                        <div class="carousel">
                            <div class="inner">
                                {{--<div class="slide active">--}}
                                    {{--<div class="div-pad1-panel">--}}
                                        {{--<label class="div-pad1-label-title">How It Works</label>--}}
                                        {{--<div class="row div-pd-lr">--}}
                                            {{--<div class="col-xs-12 col-sm-5 col-md-4">--}}
                                                {{--<div class="div-pad1"></div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-xs-12 col-sm-7 col-md-8">--}}
                                                {{--<label class="div-pad1-label">--}}
                                                    {{--CryptoCelebrities runs on the same blockchain technology as Ethereum. Just like each individual coin, each personality is linked to one, and only one, Smart Contract Token on the game’s blockchain.--}}
                                                    {{--To purchase a Smart Contract: Send Ether to the contract using Metamask. If someone wants to buy one of your current contracts, the buyer has to pay you more than the amount of your original purchase.--}}
                                                    {{--To get started, simply download the MetaMask Smart Wallet Google extension. Learn more here.--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="slide">--}}
                                    {{--<div class="div-pad1-panel">--}}
                                        {{--<label class="div-pad1-label-title">How It Works</label>--}}
                                        {{--<div class="row div-pd-lr">--}}
                                            {{--<div class="col-xs-12 col-sm-7 col-md-8">--}}
                                                {{--<label class="div-pad1-label">--}}
                                                    {{--CryptoCelebrities runs on the same blockchain technology as Ethereum. Just like each individual coin, each personality is linked to one, and only one, Smart Contract Token on the game’s blockchain.--}}
                                                    {{--To purchase a Smart Contract: Send Ether to the contract using Metamask. If someone wants to buy one of your current contracts, the buyer has to pay you more than the amount of your original purchase.--}}
                                                    {{--To get started, simply download the MetaMask Smart Wallet Google extension. Learn more here.--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-xs-12 col-sm-5 col-md-4">--}}
                                                {{--<div class="div-pad2"></div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="slide active">
                                    <div class="div-pad1-panel">
                                        <label class="div-pad1-label-title"></label>
                                        <div class="row div-pd-lr">
                                            <div class="col-xs-12 col-sm-5 col-md-4">
                                                <div class="div-pad1"></div>
                                            </div>
                                            <div class="col-xs-12 col-sm-7 col-md-8">
                                                <label class="div-pad1-label">
                                                    What makes this portfolio platform better than the rest is the chat functionality,
                                                    where you can talk to other people and ask their experiences and even get useful tips.
                                                    For now the best product on the internet.
                                                </label>
                                                <label class=" text-center">
                                                    <a href="/detailportfolio/14" class="a-review-user">MareenN</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide">
                                    <div class="div-pad1-panel">
                                        <label class="div-pad1-label-title"></label>
                                        <div class="row div-pd-lr">
                                            <div class="col-xs-12 col-sm-7 col-md-8">
                                                <label class="div-pad1-label">
                                                    Moonfolio price alerts are a MUST-HAVE for any serious crypto currency investor.
                                                    They saved me from taking profits at the right time and I was able to cash in just before the sell off in January 2018.
                                                </label>
                                                <label class=" text-center">
                                                    <a href="/detailportfolio/24" class="a-review-user">Josh</a>
                                                </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-5 col-md-4">
                                                <div class="div-pad2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide">
                                    <div class="div-pad1-panel">
                                        <label class="div-pad1-label-title"></label>
                                        <div class="row div-pd-lr">
                                            <div class="col-xs-12 col-sm-5 col-md-4">
                                                <div class="div-pad1"></div>
                                            </div>
                                            <div class="col-xs-12 col-sm-7 col-md-8">
                                                <label class="div-pad1-label">
                                                    I have tried many portfolio websites, including ones that I needed to pay.
                                                    Moonfolio is simple, looks nice and most importantly it's free.
                                                    Moonfolio has all cryptos offered in the market and can be added easily in your portfolio.
                                                </label>
                                                <label class=" text-center">
                                                    <a href="/detailportfolio/34" class="a-review-user">Kim</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="arrow arrow-left"></div>
                            <div class="arrow arrow-right"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="div-aboutus">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="">
                            <label class="home-label community port testimonials label-top-aboutus">ABOUT US</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="label-aboutus">
                            We are a group of financial engineers, traders and blockchain enthusiasts with a mission to create the best portfolio tracker on the web.
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <div class="div-top-title">
                            <label class="home-label community port testimonials">CONTACT US</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <form class="form-horizontal form-contact" action="">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="name">NAME:</label>
                                    <input type="text" class="form-control" id="name" placeholder="" name="name">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">EMAIL:</label>
                                    <input type="email" class="form-control" id="email" placeholder="" name="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="we_help">SUBJECT</label>
                                    <input type="text" class="form-control" id="we_help" placeholder="" name="subject" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="for_you">WHAT CAN WE DO FOR YOU?</label>
                                    <textarea class="form-control" id="for_you" style="height:60px;" name="for_you" cols="2"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8" style="padding-top: 17px;">
                                    {{--RECEIVE MONTHLY TIPS ON ACHIEVING RESULTS--}}
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button class="btn btn-primary btn-sendmessage">SEND MESSAGE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('./js/frontend/home.js') }}"></script>
    <script src="{{ asset('./js/frontend/home-carousel.js') }}"></script>
@endsection

{{--<script>--}}
    {{--window.setInterval(function() {--}}
        {{--window.location.reload();--}}
    {{--}, 10000);--}}
{{--</script>--}}
