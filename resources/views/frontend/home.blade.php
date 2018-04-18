@extends('layouts.frontend')

@section('content')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.2/particles.min.js"></script>
    <script src="{{ asset('./assets/jsLib/modernizer-1.6.min.js') }}"></script>
    <script>
        var top_users_count = {{ count($top_users) }};
    </script>
    <div class="container-fluid padding0">
        <div class="div-home" id="home">
            <div class="container">
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
                                <h4 class="media-heading icon-main white-text">FIAT</h4>
                                <p class="white-text" style="font-size: 16px;padding-right:100px;">Different major fiat currencies such as USD, CAD, AUD, GBP, EUR etc.</p>
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
                                        <a data-toggle="collapse" data-parent="#accordion" href="#faq1">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Which currencies do you offer?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq1" class="div-faq-content panel-collapse collapse">
                                    We offer all coins listed on <a href="https://coinmarketcap.com" target="_blank" style="color:gold;">coinmarketcap.com</a>
                                </div>
                            </div>
                            <div class="panel panel-default" style="margin-left:20%;width:100%;">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#faq2">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Is there a mobile version?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq2" class="div-faq-content panel-collapse collapse">
                                    At the moment there is no mobile version, but there will be in future.
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#faq3">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Could we communicate inside Moonfolio?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq3" class="div-faq-content panel-collapse collapse">
                                    Yes, we have an chat room where we can talk and share our opinions about crypto’s.
                                </div>
                            </div>
                            <div class="panel panel-default" style="margin-left:20%;width:100%;">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#faq4">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Are there price alerts?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq4" class="div-faq-content panel-collapse collapse">
                                    Yes, you can set an price alert and you will receive an email or audio alert once your price strike has been hit.
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#faq5">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Could I trade from Moonfolio?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq5" class="div-faq-content panel-collapse collapse">
                                    Not yet, but we will add this in future.
                                </div>
                            </div>
                            <div class="panel panel-default" style="margin-left:20%;width:100%;">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#faq6">
                                            <img src="{{ asset('./assets/images/background/faq-icon.png') }}" class="img-faq-icon">
                                            Is the pricing real time?
                                        </a>
                                    </h4>
                                </div>
                                <div id="faq6" class="div-faq-content panel-collapse collapse">
                                    Yes, it will be update every seconds.
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
                    <div class="col-sm-12 text-right">
                        <div class="div-pad1-panel">
                            <div class="div-pad1"></div>
                            <label class="div-pad1-label-title">How It Works</label>
                            <label class="div-pad1-label">
                                CryptoCelebrities runs on the same blockchain technology as Ethereum. Just like each individual coin, each personality is linked to one, and only one, Smart Contract Token on the game’s blockchain.
                                To purchase a Smart Contract: Send Ether to the contract using Metamask. If someone wants to buy one of your current contracts, the buyer has to pay you more than the amount of your original purchase.
                                To get started, simply download the MetaMask Smart Wallet Google extension. Learn more here.
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="div-pad2-panel">
                            <div class="div-pad2"></div>
                            <label class="div-pad2-label-title">How It Works</label>
                            <label class="div-pad2-label">
                                CryptoCelebrities runs on the same blockchain technology as Ethereum. Just like each individual coin, each personality is linked to one, and only one, Smart Contract Token on the game’s blockchain.
                                To purchase a Smart Contract: Send Ether to the contract using Metamask. If someone wants to buy one of your current contracts, the buyer has to pay you more than the amount of your original purchase.
                                To get started, simply download the MetaMask Smart Wallet Google extension. Learn more here.
                            </label>
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
@endsection