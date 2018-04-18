@extends('layouts.frontend')

@section('content')
<style>
    .control-label {
        font-family: Montserrat-light;
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
</style>
<script>
    var coin_arr = <?php echo $coin_arr;?>;
</script>
<div id="coinchart_detail" class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;">
        <div class="container" style="padding-bottom: 278px;">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    Add Price Alert
                </div>
                <div class="panel-body">
                    <form id="frm_price_alert" method="POST" action="{{ route('save.price.alert') }}">
                        @csrf
                        <input type="hidden" name="detail_id" value="{{ $detail_id }}" />
                        <input type="hidden" name="coin_id" value="" />
                        <input type="hidden" name="fiat" value="USD" />
                        <input type="hidden" name="audio_alert" value="1" />
                        <input type="hidden" name="email_alert" value="1" />
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label grey-color" for="currency_name">Currency Name*</label>
                                @if ($currency_name !='')
                                    <input type="search" class="form-control input-form-control grey-border" id="currency_name" name="coin_name" placeholder="Enter Currency Name" tabindex="1" data-list="brands-list" value={{ $currency_name }} autocomplete="off" required />
                                @else
                                    <input type="search" class="form-control input-form-control grey-border" id="currency_name" name="coin_name" placeholder="Enter Currency Name" tabindex="1" data-list="brands-list" autocomplete="off" required />
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
                                <label class="control-label grey-color" for="quantity">Limit Price USD*</label>
                                <div class="input-group spinner" style="width: calc(100% - 18px);">
                                    <input type="number" class="form-control input-form-control grey-border" id="limit_price" name="limit_price" value="{{ $limit_price }}" min="0" tabindex="2" style="font-size:24px;" value="1">
                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default grey-border grey-color" type="button" onclick="doOnChangeInputValue('limit_price', 'up')"><i class="fa fa-caret-up"></i></button>
                                        <button class="btn btn-default grey-border grey-color" type="button" onclick="doOnChangeInputValue('limit_price', 'down')"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6">
                                <input type="checkbox" id="box-1" field="audio_alert" checked>
                                <label for="box-1" class="alert-method">Audio alert</label>
                                &nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="box-2" field="email_alert" checked>
                                <label for="box-2" class="alert-method">Email alert</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 text-right">
                                <button type="button" class="button buttonBlue btn-save-details" onclick="doOnClickSave()">SAVE
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
                    Your Alert Coins
                </div>
                <div class="panel-body panel-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr id="thead_title">

                        </tr>
                        <tr>
                            <th class="td-cell">#</th>
                            <th class="td-cell">Coin</th>
                            <th class="td-cell">Limit Price USD</th>
                            <th class="td-cell">Audio Alert</th>
                            <th class="td-cell">Email Alert</th>
                            <th class="td-cell">Action</th>
                        </tr>
                        </thead>
                        <tbody id="tbody_content">
                            @if ( $price_alert_datas )
                                @foreach( $price_alert_datas as $idx=>$data )
                                    <tr style="border-bottom: 1px solid #555555;">
                                        <td class="td-cell">{{ $idx+1 }}</td>
                                        <td class="td-cell">
                                            <img src="https://files.coinmarketcap.com/static/widget/coins_legacy/32x32/{{ $data['coin_id'] }}.png" width="32px" height="32px" />
                                            {{ $data['coin_name'] }}
                                        </td>
                                        <td class="td-cell">{{ $data['limit_price'] }}</td>
                                        <td class="td-cell">{{ ( $data['audio_alert'] == 1 ) ? "Yes" : "No" }}</td>
                                        <td class="td-cell">{{ ( $data['email_alert'] == 1 ) ? "Yes" : "No" }}</td>
                                        <td class="td-cell td-action">
                                            <a href="#" class="a-currency-edit" onclick="doOnClickEdit({{ json_encode($data) }})"></a>
                                            <a href="" onclick="doOnDelete('{{ $data['id'] }}')" data-toggle="modal" data-target="#myModal" class="a-currency-delete" ></a>
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
                <h4>Are you sure you would like to remove this price?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" onclick="doOnRequestDelete()">Remove</button>
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/editpricealert.js') }}"></script>
@endsection
