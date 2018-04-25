@extends('layouts.frontend')

@section('content')
<style>
    input[type="radio"] {
        display: none;;
    }
    .social-share-group{
        position: absolute;
        right: 320px;
        top: 80px;
    }
    .fa {
        font-family: Montserrat-light;
        border-radius: 3px;
        font-weight: 600;
        padding: 5px 8px;
        display: inline-block;
        position: static;
        margin: 5px 2px;
    }

    .fa:hover {
        color: white;
        background: #3b79a9;
    }

    .fa-twitter {
        background: #55ACEE;
        border-radius: 3px;
        font-weight: 600;
        padding: 10px;
        display: block!important;
        position: static;
        color: white;
        text-decoration: none;
    }
    .fa-twitter:hover {
        background: #3b79a9;
        text-decoration: none;
    }
    #fb-share-button {
        background: #3b5998;
        border-radius: 3px;
        font-weight: 600;
        padding: 5px 8px;
        display: inline-block;
        position: static;
        cursor: pointer;
    }

    #fb-share-button:hover {
        cursor: pointer;
        background: #213A6F;
    }

    #fb-share-button svg {
        width: 18px;
        fill: white;
        vertical-align: middle;
        border-radius: 2px
    }

    #fb-share-button span, .fa-twitter span {
        font-family: Montserrat-light;
        vertical-align: middle;
        color: white;
        font-size: 15px;
        padding: 0 3px;
        font-weight: bold;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="margin-top:0; padding-top:100px;">
        <div class="container" style="padding-bottom: 44px;">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="div-avatar-img" src="{{ $user_avatar }}"  style="width:250px;height:250px;"/>
                    <label class="label-title-portfolio" style="display: block;">{{ $full_name }}</label>
                    <div class="social-share-group">
                        <div id="fb-share-button" >
                            <svg viewBox="0 0 12 12" preserveAspectRatio="xMidYMid meet">
                                <path class="svg-icon-path" d="M9.1,0.1V2H8C7.6,2,7.3,2.1,7.1,2.3C7,2.4,6.9,2.7,6.9,3v1.4H9L8.8,6.5H6.9V12H4.7V6.5H2.9V4.4h1.8V2.8 c0-0.9,0.3-1.6,0.7-2.1C6,0.2,6.6,0,7.5,0C8.2,0,8.7,0,9.1,0.1z"></path>
                            </svg>
                            <span>Share</span>
                        </div>

                        <a class="twitter-share-button fa fa-twitter" target="_blank"
                           href="https://twitter.com/share"
                           data-size="large"
                           data-text="custom share text"
                           data-url="https://dev.twitter.com/web/tweet-button"
                           data-hashtags="example,demo"
                           data-via="twitterdev"
                           data-related="twitterapi,twitter">
                            <span>Share</span>
                        </a>

                    </div>
                </div>
            </div>

            <div class="panel panel-default" style="margin-top: -60px;">
                <label class="label-title-portfolio">PORTFOLIO</label>
                <div class="div-panel-heading" style="padding-top:18px;">
                    <div class="row padding0">
                        <div class="col-md-2 padding0 wrap-div-col" style="padding-left: 20px!important;">Total Coins: {{ $total_coins }}</div>
                        <div class="col-md-3 padding0 wrap-div-col">
                            Invested Capital: ${{ number_format($total_data['invested_capital'], 2, '.',',') }}</div>
                        <div class="col-md-3 padding0 wrap-div-col">
                            Total Profit/Loss:
                            <span class="{{ ($total_data['total_profit_loss']<0)?"color-red":"color-green" }} strok-white">${{ number_format($total_data['total_profit_loss'], 2, '.',',') }}</span>
                        </div>
                        <div class="col-md-4 padding0 wrap-div-col">
                            Total Profit/Loss Percentage:
                            <span class=" {{ ($total_data['total_profit_loss_percentage']>0)?"color-green":"color-red" }} strok-white">
                                {{ number_format($total_data['total_profit_loss_percentage'], 2, '.',',') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="margin-top:-10px;">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="td-cell">#</th>
                            <th class="td-cell">Coin</th>
                            <th class="td-cell">Current Price</th>
                            <th class="td-cell">Invested Capital</th>
                            <th class="td-cell">Profit/Loss (Each)</th>
                            <th class="td-cell">Profit/Loss %</th>
                            <th class="td-cell">1H Change %</th>
                            <th class="td-cell">24H Change %</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ( $user_currency_data )
                            @foreach( $user_currency_data as $currency )
                                <tr style="border-bottom: 1px solid #555555;">
                                    <td class="td-cell td-coin-icon">
                                        <img src="https://files.coinmarketcap.com/static/widget/coins_legacy/32x32/{{ $currency['id'] }}.png" width="32px" height="32px" />
                                    </td>
                                    <td class="td-cell">
                                        {{ $currency['name']."(".$currency['symbol'].")" }}
                                    </td>
                                    <td class="td-cell">
                                        ${{ number_format($currency['price_usd'], 2, '.',',') }}
                                    </td>
                                    <td class="td-cell">
                                        {{ number_format($currency['total_cost'], 2, '.',',') }} <br/> {{ $currency['quantity']." ".$currency['symbol']." @ ".number_format($currency['purchased_price'], 2, '.',',') }}
                                    </td>
                                    <td class="td-cell {{ ($currency['profit_loss']>0)?"color-green":"color-red" }}">
                                        ${{ number_format($currency['profit_loss'], 2, '.',',') }}
                                    </td>
                                    <td class="td-cell {{ ($currency['profit_loss_percentage']>0)?"color-green":"color-red" }}">
                                        {{ number_format($currency['profit_loss_percentage'], 2, '.', ',') }}%
                                    </td>
                                    <td class="td-cell {{ ($currency['percent_change_1h']>0)?"color-green":"color-red" }}">
                                        {{ $currency['percent_change_1h'] }}%
                                    </td>
                                    <td class="td-cell {{ ($currency['percent_change_24h']>0)?"color-green":"color-red" }}">
                                        {{ $currency['percent_change_24h'] }}%
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure to remove this currency data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" onclick="doOnRequestDelete()">Remove</button>
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="myConfirm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Just removed detail data.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="selectAvatarModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <a class="button buttonBlue btn-save-details ui-corner-all" href="{{ route('select.default.avatar') }}">Default avatar</a>
                <a class="button buttonBlue btn-save-details ui-corner-all" href="{{ route('select.custom.avatar') }}">Custom avatar</a>
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{--<script src="{{ asset('./js/frontend/editprofile.js') }}"></script>--}}
<div id="fb-root"></div>
<script>
    var fbButton = document.getElementById('fb-share-button');
    var url = window.location.href;

    fbButton.addEventListener('click', function() {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + url,
                'facebook-share-dialog',
                'width=800,height=600'
        );
        return false;
    });


    (function(){
        var shareButtons = document.querySelectorAll(".twitter-share-button");
        if (shareButtons) {
            [].forEach.call(shareButtons, function(button) {
                button.addEventListener("click", function(event) {
                    var width = 650, height = 450;
                    event.preventDefault();
                    window.open(this.href, 'Share Dialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width='+width+',height='+height+',top='+(screen.height/2-height/2)+',left='+(screen.width/2-width/2));
                });
            });
        }
    })();

</script>
@endsection
