@extends('layouts.frontend')

@section('content')
<style>
    .control-label {
        font-family: Montserrat-light;
    }
</style>

<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;">
        <div class="container">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    Add Cryptocurrency details
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('save_verified_coin') }}">
                        @csrf
                        <input type="hidden" name="wallet_address" value="{{ $wallet_address }}" />
                        <input type="hidden" name="detail_id" value="{{ $detail_id }}" />
                        <input type="hidden" name="total_cost" value="{{ $wallet_value }}" />
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="currency_name">Currency Name*</label>
                                <input type="search" class="form-control input-form-control grey-border" id="currency_name" name="currency_name"
                                       placeholder="Enter Currency Name" tabindex="1" data-list="brands-list" value="{{ $currency_name }}"  readonly />
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="quantity">Quantity*</label>
                                <div class="input-group spinner" style="width: calc(100% - 18px);">
                                    <input type="text" class="form-control input-form-control grey-border" id="quantity" name="quantity"
                                           value="{{ $quantity }}" min="0" tabindex="2" style="font-size:24px;"  autocomplete="off" readonly>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="purchased_price">Purchased Price*(in USD)</label>
                                <div class="input-group spinner" style="width: calc(100% - 18px);">
                                    <input type="text" class="form-control input-form-control grey-border" id="purchased_price" name="purchased_price"
                                           value="{{ $price }}" tabindex="3" style="font-size:24px;" min="0" autocomplete="off">
                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default grey-border grey-color" type="button"  onclick="doOnChangeInputValue('purchased_price', 'up')">
                                            <i class="fa fa-caret-up"></i>
                                        </button>
                                        <button class="btn btn-default grey-border grey-color" type="button" onclick="doOnChangeInputValue('purchased_price', 'down')">
                                            <i class="fa fa-caret-down"></i>
                                        </button>
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
                                <label class="control-label label-total" id="label_total_cost" >{{ $wallet_value }}</label>
                            </div>
                            <div class="form-group col-sm-6 text-right">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                            </div>
                            <div class="form-group col-sm-6 text-right">
                                <button type="submit" class="button buttonBlue btn-save-details">SAVE DETAILS
                                    <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                                </button>
                                <a href="{{ route('wallet_verification') }}" class="button buttonRed btn-save-details ui-corner-all">CANCEL</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/addverifiedcoin.js') }}"></script>
@endsection
