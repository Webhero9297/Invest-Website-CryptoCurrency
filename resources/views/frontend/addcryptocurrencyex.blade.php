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
    /*.chk-container:not(:disabled):hover .chk-label {*/
        /*color: gold;*/
    /*}*/
    .chk-container:hover input:not(:disabled) ~ .checkmark, .chk-container input:checked:not(:disabled) ~ .chk-label {
        color: gold;
        background-color: #0297bf;
        border-color: #0277bf;
    }

    /* When the radio button is checked, add a blue background */
    /*.chk-container:hover .chk-label {*/
        /*color: gold;*/
    /*}*/
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
</style>

<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;">
        <div class="container">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    ADD CRYPTO CURRENCY DETAILS
                </div>
                <div class="panel-body">
                    <form id="form_detail" method="POST" action="{{ route('store.crypto.currency') }}">
                        @csrf
                        <input type="hidden" name="detail_id" value="{{ $detail_id }}" />
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="currency_name">Currency Name*</label>
                                @if ($currency_name !='')
                                    <input type="search" class="form-control input-form-control grey-border" id="currency_name" name="currency_name" placeholder="Enter Currency Name" tabindex="1" data-list="brands-list" value={{ $currency_name }} required />
                                @else
                                    <input type="search" class="form-control input-form-control grey-border" id="currency_name" name="currency_name" placeholder="Enter Currency Name" tabindex="1" data-list="brands-list" required />
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
                                <label class="control-label grey-color" for="purchased_price">Purchased Price*(in USD)</label>
                                <div class="input-group spinner" style="width: calc(100% - 18px);">
                                    <input type="text" class="form-control input-form-control grey-border" id="purchased_price" name="purchased_price" value="{{ $purchased_price }}" tabindex="3" style="font-size:24px;" value="1" min="0" autocomplete="off">
                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default grey-border grey-color" type="button"  onclick="doOnChangeInputValue('purchased_price', 'up')"><i class="fa fa-caret-up"></i></button>
                                        <button class="btn btn-default grey-border grey-color" type="button" onclick="doOnChangeInputValue('purchased_price', 'down')"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="purchased_date">Purchased Date*</label>
                                <input type="text" class="form-control input-form-control grey-border" id="purchased_date" name="purchased_date" value="{{ $purchased_date }}" tabindex="4" placeholder="Enter Purchased Date" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label label-total" >Total cost(in USD)&nbsp;:&nbsp;&nbsp;&nbsp;</label>
                                <label class="control-label label-total" id="label_total_cost" >0</label>
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
<script src="{{ asset('./js/frontend/addcurrency.js') }}"></script>
@endsection
