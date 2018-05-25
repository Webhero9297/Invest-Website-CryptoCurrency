<style>
    #mySellTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
        font-size: 18px;
    }
    #mySellTable th, #mySellTable td {
        text-align: left;
        /*padding: 5px;*/
    }
    #mySellTable tr {
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }
    #mySellTable thead tr.header {
        background-color: #0297bf;
    }
    #mySellTable tr:hover {
        background-color: #0297bf26;
    }
    thead .td-cell {
        height: 35px!important;
    }
    thead#buy_head tr th {
        white-space: nowrap;
    }
    #other_sell_table {
        border-left: none!important;
        border-top: none!important;
        margin-bottom: 0px!important;
        border-bottom: none!important;
        width: calc(100% - 15px)!important;
    }
    #other_sell_table_wrapper {
        margin-left: 10px;
        width: calc(100% - 10px);
    }
    #other_sell_table_wrapper .row:nth-child(2) {
        padding: 0;
    }
    #other_sell_table_wrapper .row:nth-child(2) div {
        padding: 0;
    }
    .sell_table_fix_header .div-td-cell {
        white-space: nowrap;
    }
</style>
<datalist id="sell-brands-list">
    <select>
        @if ( $cryptoData )
            @foreach( $cryptoData as $crypto )
                <option class="option_crypto_currency" id="{{ $crypto['id'] }}" currency_symbol="{{ $crypto['symbol'] }}" value="{{ $crypto['name'] }}"></option>
            @endforeach
        @endif
    </select>
</datalist>
<div class="row">
    <div class="col-xs-12 col-sm-5 col-md-4" style="padding: 0;">
        <p class="p-title">My sell list</p>
        <input type="text" id="mySellInput" class="search_input" onkeyup="mySellFunction()" placeholder="Find a specific coin" title="Find a specific coin" style="display: none;">
        <table id="mySellTable">
            <thead>
            <tr class="header">
                <th class="td-cell text-center">#</th>
                <th class="td-cell text-center">Coin</th>
                <th class="td-cell text-center">Price</th>
                <th class="td-cell text-center">Quantity</th>
            </tr>
            </thead>
            @if ( $sell_list )
                @foreach( $sell_list as $idx=>$list_item )
                    <tr onclick="doOnMySellListClick('{{ $list_item['match_id'] }}')" coin-symbol="{{ $list_item['coin_symbol'] }}">
                        <td class="td-cell text-center">{{ $idx+1 }}</td>
                        <td class="td-cell text-center">
                            <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{ $list_item['coin_id'] }}.png" width="32px" height="32px" />
                            <span>{{ $list_item['coin_symbol'] }}</span>
                        </td>
                        <td class="td-cell color-red text-center">${{ $list_item['purchased_price'] }}</td>
                        <td class="td-cell text-center">{{ $list_item['quantity'] }}</td>
                    </tr>
                @endforeach
            @else
                @if ( \Auth::user() )
                    <tr>
                        <td colspan="4" style="text-align:center;padding:10px;">
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" style="text-align:center;padding:10px;">
                            <a href="{{ route('login') }}" class="a-wrap-btn">Login</a>
                            <div>or</div>
                            <a href="{{ route('register') }}" class="a-wrap-btn">New Portfolio</a>
                        </td>
                    </tr>
                @endif
            @endif
        </table>
    </div>
    <div class="col-xs-12 col-sm-7 col-md-8" style="margin-top:-10px;">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <label class="lbl-search">Coin:</label>
                <input type="search" id="sell_filter_coin" class="search_input search-star-review" placeholder="Find a specific coin" />
            </div>
        </div>
        <div class="row" style="margin-top: -10px;padding-right:0;">
            {{--<div class="col-xs-12" style="padding: 0 10px;display:block; height:37px; overflow-y:scroll; overflow-x: hidden; margin-top:-4px;width:100%!important;">--}}
                {{--<div id="sell_table_fix_header" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="width:100%!important;margin-bottom:0!important;display: none;">--}}
                    {{--<div class="display:inline-block;">--}}
                        {{--<div id="fix-sell-td0" class="div-td-cell td-grey" >#</div>--}}
                        {{--<div id="fix-sell-td1" class="div-td-cell td-grey" >User</div>--}}
                        {{--<div id="fix-sell-td2" class="div-td-cell td-grey">Coin</div>--}}
                        {{--<div id="fix-sell-td2" class="div-td-cell td-grey">Quantity</div>--}}
                        {{--<div id="fix-sell-td3" class="div-td-cell td-grey" data-toggle="popover" data-content="This is the price that buyers are offering">Price</div>--}}
                        {{--<div id="fix-sell-td4" class="div-td-cell td-grey" >Current</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-xs-12" style="padding: 0;display:block; height:520px; overflow-y:scroll; overflow-x: hidden;
            margin-top:-4px;width:100%!important;border: 1px solid white;" onscroll="doOnSellScroll(this)">
                <table id="other_sell_table" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="width:100%;">
                    <thead id="sell_head">
                    <tr>
                        <th class="td-cell td-grey text-center padding0" width="50px">#</th>
                        <th class="td-cell td-grey padding0"  width="20%">User</th>
                        <th class="td-cell td-grey padding0"  width="20%">Coin</th>
                        <th class="td-cell td-grey padding0" >Quantity</th>
                        <th class="td-cell td-grey padding0" data-toggle="popover" data-content="This is the price that sellers are offering">Price</th>
                        <th class="td-cell td-grey padding0 last-td">Current</th>
                        {{--@if (\Auth::user())--}}
                        {{--<th class="td-cell td-grey text-center padding0" width="82px" style="width:82px!important;">Buy</th>--}}
                        {{--@endif--}}
                    </tr>
                    </thead>
                    <tbody id="tbody_sell_coin_live_data" class="text-center">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

