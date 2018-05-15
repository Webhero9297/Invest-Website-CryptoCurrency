<style>
    #myBuyTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
        font-size: 18px;
    }
    #myBuyTable th, #myBuyTable td {
        text-align: left;
        /*padding: 5px;*/
    }
    #myBuyTable tr {
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }
    #myBuyTable thead tr.header {
        background-color: #0297bf;
    }
    #myBuyTable tr:hover {
        background-color: #0297bf26;
    }
    thead .td-cell {
        height: 35px!important;
    }
</style>
<datalist id="buy-brands-list">
    <select>
        @if ( $cryptoData )
            @foreach( $cryptoData as $crypto )
                <option class="option_crypto_currency" id="{{ $crypto->id }}" currency_symbol="{{ $crypto->symbol }}" value="{{ $crypto->name }}"></option>
            @endforeach
        @endif
    </select>
</datalist>
<div class="row">
    <div class="col-xs-12 col-sm-5 col-md-4" style="padding: 0;">
        <p class="p-title">My buy list</p>
        <input type="text" class="search_input" id="myBuyInput" onkeyup="myBuyFunction()" placeholder="Find a specific coin" title="Type in a name" style="display: none;">
        <table id="myBuyTable">
            <thead>
            <tr class="header">
                <th class="td-cell text-center">#</th>
                <th class="td-cell text-center">Coin</th>
                <th class="td-cell text-center">Price</th>
                <th class="td-cell text-center" width="0px">Quantity</th>
            </tr>
            </thead>
            @if ( $buy_list )
                @foreach( $buy_list as $idx=>$list_item )
                    <tr onclick="doOnMyBuyListClick('{{ $list_item['match_id'] }}')" coin-symbol="{{ $list_item['coin_symbol'] }}">
                        <td class="td-cell text-center">{{ $idx+1 }}</td>
                        <td class="td-cell text-center">
                            <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{ $list_item['coin_id'] }}.png" width="32px" height="32px" />
                            <span>{{ $list_item['coin_symbol'] }}</span>
                        </td>
                        <td class="td-cell color-green text-center">${{ $list_item['purchased_price'] }}</td>
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
    <div class="col-xs-12 col-sm-7 col-md-8" style="padding: 0;margin-top:-10px;">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 col-md-offset-2">
                <label class="lbl-search">Coin:</label>
                <input type="search" id="buy_filter_coin" class="search_input search-star-review" placeholder="Find a specific coin" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="other_buy_table" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="width:100%;">
                    <thead>
                    <tr>
                        <th class="td-cell td-grey text-center padding0" width="50px">#</th>
                        <th class="td-cell td-grey padding0" >User</th>
                        <th class="td-cell td-grey padding0" >Coin</th>
                        <th class="td-cell td-grey padding0" >Quantity</th>
                        <th class="td-cell td-grey padding0" data-toggle="popover" data-content="This is the price that buyers are offering">Price</th>
                        <th class="td-cell td-grey padding0 last-td" width="182px">Current Price</th>
                        {{--@if (\Auth::user())--}}
                        {{--<th class="td-cell td-grey text-center padding0" width="82px" style="width:82px!important;">Sell</th>--}}
                        {{--@endif--}}
                    </tr>
                    </thead>
                    <tbody id="tbody_buy_coin_live_data" class="text-center">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
