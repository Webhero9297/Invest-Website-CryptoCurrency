@extends('layouts.frontend')

@section('content')
<style>
    input[type="radio"] {
        display: none;;
    }
    .edit-price-alert{
        position: absolute;
        right: 0;
        font-size: 20px;
        padding: 7px 25px;
    }
    .add-coin-match{
        position: absolute;
        right: 220px;
        font-size: 20px;
        padding: 7px 15px;
    }
    @media( min-width: 1024px ) {
        .xtd-cell {
            display: none;
        }
        .ov-cell {
            display: block;
        }
    }
    @media( max-width: 1024px ) {
        .xtd-cell {
            display: block;
        }
        .ov-cell {
            display: none;
        }
    }

    .img-bg-strech {
        background-size: cover;
    }
    .panel-default>.panel-heading a.collapse-a {
        display: block;
        background: #ffffff12;
        font-family: Montserrat-Light;
        color: white;
        text-decoration: none;
        height: 40px;
        width: 100%;
        padding: 8px 15px;
        font-size: 17px;
        border: 1px solid #333;
        text-align: left;
    }
    .panel-default>.panel-heading a.collapse-a[aria-expanded="true"] {
        background: #ffffff12;
        color: #feffff;
    }
    .panel-body-collapse {
        background: linear-gradient( to bottom, rgb(0, 0, 0), rgba(0,0,0,0.75));
        border-radius: 0;
        color: white;
        padding: 0;
    }
    /* width */
    ul ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ul ::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.1);
    }
    /* Handle */
    ul ::-webkit-scrollbar-thumb {
        border-radius: 0!important;
        background: #0297bf!important;;
    }

    /* Handle on hover */
    ul ::-webkit-scrollbar-thumb:hover {
        background: #0297bf!important;
    }
    .panel-default>.panel-heading a.collapse-a:after {
        top: 3px;
    }
    .input-wallet-address {
        text-transform: capitalize;
        width: 75%!important;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .btn-check-wallet {
        border:none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        width: 25%!important;
        font-size: 18px;
        font-weight: bold;
        font-family: Montserrat-Light;
        cursor: pointer;
        color: white;
        background: linear-gradient(#06b5e5, #0481a3);
        border-top: 1px solid #92e5fd;
        border-left: 1px solid #92e5fd05;
        border-right: 1px solid #92e5fd05;
        text-shadow: 1px 1px 1px rgba(4, 4, 4, 0.83);
    }
    .btn-check-wallet:hover {
        color: gold;
    }
    .frm-check {
        margin: 10px 0;
        padding: 15px;
        box-shadow: 1px 1px 1px rgba(84, 83, 83, 0.83);
        border-radius: 0px;
        border: 1px solid rgba(84, 84, 83, 0.21);
        display: none;
    }
    .form-control:focus {
        color: white;
    }
    .form-control-wdh-50 {
        width: 50%!important;
    }
    .control-label {
        width: 200px;
    }
    .form-group-mg-bottom {
        margin-bottom: 10px;
    }
    #h-title {
        font-family: Montserrat-Light;
        font-size: 20px;
        margin-bottom: 15px;
        font-weight: bold;
    }
</style>
<link href="{{ asset('css/verification.css') }}" rel="stylesheet">
<div id="coinchart_detail" class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="margin-top:0; padding-top:100px;">
        <div class="container" style="padding-bottom: 44px;">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    Wallet Verification
                </div>
                <div class="panel-body" style="height:390px;">
                    <div class="row">
                        <div class="col-sm-3 text-center">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapse-a" data-toggle="collapse" data-parent="#accordion" href="#coin_list">
                                                Coins
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="coin_list" class="panel-collapse collapse">
                                        <div class="panel-body-collapse">
                                            <input type="text" id="myInput_coin" class="myInput" onkeyup="myFunctionFilterCoin()" placeholder="Search for names.." title="Type in a name">
                                            <ul id="myCoinUL" class="myUL">
                                                @foreach( $crypto_data['coin'] as $coin_id=>$coin_name )
                                                    <li>
                                                        <a href="#" class="a-erc20-token" coin-id="{{ $coin_id }}" onclick="doOnSelectCoin(this)">{{ $coin_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group" style="display: flex;">
                                <input type="text" class="form-control input-form-control grey-border grey-color input-wallet-address" tabindex="1"
                                           id="wallet_address" name="wallet_address" value="" placeholder="Wallet Address" required>
                                <button type="button" id="btn-check-balance" class="form-control btn-check-wallet" style="height: 46px;">Check Balance</button>
                            </div>
                            <div class="form-group">
                                <form class="form-horizontal frm-check" id="frm_wallet_verification">
                                    <div class="form-group">
                                        <h4 id="h-title"></h4>
                                    </div>
                                    <div class="form-group form-group-mg-bottom">
                                        <label class="control-label" for="wallet_balance">Wallet Balance:</label>
                                        <input type="text" class="form-control form-control-wdh-50" balance="0" id="wallet_balance" >
                                    </div>
                                    <div class="form-group form-group-mg-bottom">
                                        <label class="control-label" for="current_price">Current Price:</label>
                                        <input type="text" class="form-control form-control-wdh-50" id="current_price" >
                                    </div>
                                    <div class="form-group form-group-mg-bottom">
                                        <label class="control-label" for="wallet_value">Wallet Value:</label>
                                        <input type="text" class="form-control form-control-wdh-50" id="wallet_value" >
                                    </div>
                                </form>
                            </div>
                            <div class="form-group text-right">
                                <form id="frm_post" method="post" action="{{ route('add_verified_coin') }}">
                                    @csrf
                                    <input type="hidden" name="currency_name">
                                    <input type="hidden" name="quantity">
                                    <input type="hidden" name="price">
                                    <input type="hidden" name="wallet_address">
                                    <input type="hidden" name="wallet_value">
                                    <button type="button" id="btn-add-crypto-curtrency" class="button buttonBlue btn-save-details" style="width: 300px;" >Add Crypto Currency
                                        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                                    </button>
                                    <a href="{{ route('profile') }}" class="button buttonRed btn-save-details ui-corner-all">CANCEL</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="div-panel-heading">
                    Your Verified Currencies
                </div>
                <div class="panel-body panel-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr id="thead_title">

                        </tr>
                        <tr>
                            <th class="td-cell">#</th>
                            <th class="td-cell">Coin</th>
                            <th class="td-cell">Current Price</th>
                            <th class="td-cell">Invested Capital</th>
                            <th class="td-cell">Profit/Loss</th>
                            <th class="td-cell">1H Change %</th>
                            <th class="td-cell">24H Change %</th>
                            <th class="td-cell">Action</th>
                        </tr>
                        </thead>
                        <tbody id="tbody_content">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="coin_alarm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Please select coin.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/verification.js') }}"></script>
@endsection
