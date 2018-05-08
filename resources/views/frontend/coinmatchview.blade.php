@extends('layouts.frontend')

@section('content')
<style>
    .control-label {
        font-family: Montserrat-light;
    }
    input[type="radio"] {
        display: none;;
    }
    @import url(https://fonts.googleapis.com/css?family=Open+Sans);

    /*Checkboxes styles*/
    input[type="checkbox"] { display: none; }

    input[type="checkbox"] + label {
        display: inline-block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 20px;
        font-family: Montserrat-light;
        color: #ddd;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    input[type="checkbox"] + label:last-child { margin-bottom: 0; }

    input[type="checkbox"] + label:before {
        content: '';
        display: block;
        width: 20px;
        height: 20px;
        border: 1px solid #6cc0e5;
        position: absolute;
        left: 0;
        top: 0;
        opacity: .6;
        -webkit-transition: all .12s, border-color .08s;
        transition: all .12s, border-color .08s;
    }

    input[type="checkbox"]:checked + label:before {
        width: 10px;
        top: -5px;
        left: 5px;
        border-radius: 0;
        opacity: 1;
        border-top-color: transparent;
        border-left-color: transparent;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .chk-container {
        display: inline-flex;
        position: relative;
        padding: 7px 10px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin-left: -5px;
    }

    /* Hide the browser's default radio button */
    .chk-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 35px;
        width: 44px;
        z-index:1;
        background-color: #333333;
        border: 1px solid #0277bf;
        border-radius: 0.25rem;
    }
    .checkmark.sell {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .checkmark.buy {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }
    .chk-label{
        position: relative;
        z-index: 2;
    }

    /* On mouse-over, add a grey background color */
    .chk-container:hover input:not(:disabled) ~ .checkmark, .chk-container input:checked:not(:disabled) ~ .chk-label {
        color: gold;
        background-color: #0297bf;
        border-color: #0277bf;
    }

    /* When the radio button is checked, add a blue background */
    .chk-container input:checked:not(:disabled) ~ .checkmark, .chk-container input:checked:not(:disabled) ~ .chk-label {
        color: gold;
        background-color: #2196F3;
    }
    .chk-container input:disabled ~ .chk-label {
        color: grey;
    }
    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    /* Show the indicator (dot/circle) when checked */
    .chk-container input:checked ~ .checkmark:after {
        display: block;
    }
    /* Style the indicator (dot/circle) */
    .chk-container .checkmark:after {
        top: 9px;
        left: 9px;
        background: white;
    }
    label.btn-primary {
        font-size: 20px;
        padding: 5px 15px;
    }
    .p-current-price {
        font-family: Montserrat-Light;
        font-style: italic;
        text-align: right;
        color: darkgray;
        height: 32px;
    }
</style>
<script>
    var coinData = <?php echo json_encode($cryptoData); ?>;
</script>
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;padding-bottom: 50px;">
        <div class="container">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    ADD Coin Match details
                </div>
                <div class="panel-body">
                    <form id="form_detail" method="POST" action="{{ route('store.coin.match') }}">
                        @csrf
                        <input type="hidden" name="match_id" value="{{ $match_id }}" />
                        <input type="hidden" name="order_side" value="{{ $order_side }}" />
                        <div class="row">
                            <div class="form-group col-sm-6" >
                                <label class="control-label grey-color" for="coin_name">Currency Name*</label>
                                @if ($coin_name !='')
                                    <input type="search" class="form-control input-form-control grey-border" id="coin_name" name="coin_name" placeholder="Enter Currency Name" tabindex="1" data-list="brands-list" value={{ $coin_name }} required />
                                @else
                                    <input type="search" class="form-control input-form-control grey-border" id="coin_name" name="coin_name" placeholder="Enter Currency Name" tabindex="1" data-list="brands-list" required />
                                @endif
                                <datalist id="brands-list">
                                    <select>
                                        @if ( $cryptoData )
                                            @foreach( $cryptoData as $crypto )
                                                <option class="option_crypto_currency" id="{{ $crypto->id }}" currency_symbol="{{ $crypto->symbol }}" value="{{ $crypto->name }}"></option>
                                            @endforeach
                                        @endif
                                    </select>
                                </datalist>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="quantity">Quantity*</label>
                                <div class="input-group spinner" style="width: calc(100% - 18px);">
                                    <input type="text" class="form-control input-form-control grey-border" id="quantity" name="quantity" value="{{ $quantity }}" min="0" tabindex="2" style="font-size:24px;" value="1" autocomplete="off">
                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default grey-border grey-color" type="button" onclick="doOnChangeInputValue('quantity', 'up')"><i class="fa fa-caret-up"></i></button>
                                        <button class="btn btn-default grey-border grey-color" type="button" onclick="doOnChangeInputValue('quantity', 'down')"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="purchased_price">Bid Price(in USD)</label>
                                <div class="input-group spinner" style="width: calc(100% - 18px);">
                                    <input type="text" class="form-control input-form-control grey-border" id="purchased_price" name="purchased_price" value="{{ $purchased_price }}" tabindex="3" style="font-size:24px;" value="1" min="0" autocomplete="off">
                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default grey-border grey-color" type="button"  onclick="doOnChangeInputValue('purchased_price', 'up')"><i class="fa fa-caret-up"></i></button>
                                        <button class="btn btn-default grey-border grey-color" type="button" onclick="doOnChangeInputValue('purchased_price', 'down')"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                                <p class="p-current-price" id="current_price" ></p>
                            </div>
                            <div class="form-group col-sm-6">
                                <div class="btn-group" data-toggle="buttons" style="margin-top:32px;">
                                    <label class="btn btn-primary {{ $order_side == 0 ? "active" : "" }}" id="label_buy" onclick="doOnChangeSideStatus('buy')" data-toggle="popover" data-content="Buy a coin">
                                        <input type="radio" name="options" id="input_below" autocomplete="off"> Buy
                                    </label>
                                    <label class="btn btn-primary {{ $order_side == 0 ? "" : "active" }}" id="label_sell" onclick="doOnChangeSideStatus('sell')" data-toggle="popover" data-content="Sell a coin">
                                        <input type="radio" name="options" id="input_above" autocomplete="off"> Sell
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label label-total" style="display: none;">Total cost(in USD)&nbsp;:&nbsp;&nbsp;&nbsp;</label>
                                <label class="control-label label-total" id="label_total_cost"  style="display: none;">0</label>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="purchased_date" style="display: none;">Purchased Date*</label>
                                <input type="text" class="form-control input-form-control grey-border" style="display: none;" id="purchased_date" name="purchased_date" value="{{ $purchased_date }}" tabindex="4" placeholder="Enter Purchased Date" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                            </div>
                            <div class="form-group col-sm-6 text-right">
                                <button type="button" class="button buttonBlue btn-save-details" onclick="doOnClickSaveDetails()">SAVE DETAILS
                                    <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                                </button>
                                <a href="{{ route('profile') }}" class="button buttonRed btn-save-details ui-corner-all">CANCEL</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default" style="margin-top:50px;">
                <div class="div-panel-heading">
                    Your Coin Match list
                </div>
                <div class="panel-body panel-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr id="thead_title">
                        </tr>
                        <tr>
                            <th class="td-cell">#</th>
                            <th class="td-cell">Coin</th>
                            <th class="td-cell">Side</th>
                            <th class="td-cell">Bid Price(USD)</th>
                            <th class="td-cell">Quantity</th>
                            <th class="td-cell">Action</th>
                        </tr>
                        </thead>
                        <tbody id="tbody_content">
                        @if($coin_match_data)
                            @foreach( $coin_match_data as $idx=>$coin_data )
                                <tr style="border-bottom: 1px solid #555555;">
                                    <td class="td-cell">{{ $idx+1 }}</td>
                                    <td class="td-cell">
                                        <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{ $coin_data['coin_id'] }}.png" width="32px" height="32px" />
                                        {{ $coin_data['coin_name'] }}
                                    </td>
                                    <td class="td-cell {{ ( $coin_data['order_side'] == 0 ) ? "color-green" : "color-red" }}">{{ ( $coin_data['order_side'] == 0 ) ? "Buy" : "Sell" }}</td>
                                    <td class="td-cell">{{ $coin_data['purchased_price'] }}</td>
                                    <td class="td-cell">{{ $coin_data['quantity'] }}</td>
                                    <td class="td-cell td-action">
                                        <a class="a-currency-edit" onclick="doOnUpdate('{{ json_encode($coin_data) }}')"  data-toggle="popover" data-content="Edit" />
                                        <a class="a-currency-delete" onclick="doOnDelete('{{ $coin_data['match_id'] }}')"  data-toggle="popover" data-content="Remove"></a>
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
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
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
                <p>Are you sure you would like to remove this data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" onclick="doOnRequestDelete()">Remove</button>
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/coinmatch.js') }}"></script>
@endsection
