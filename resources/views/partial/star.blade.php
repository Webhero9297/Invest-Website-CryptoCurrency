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
    .img-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    .search-star-review {
        height: 32px;
        border-radius: 5px;
    }
    .span-comment{
        cursor: pointer;
    }
    .span-comment:hover {
        color: gold;
    }
</style>
<datalist id="filter-coin-list">
    <select>
        {{--<option class="option_crypto_currency"></option>--}}
        @if ( $cryptoData )
            @foreach( $cryptoData as $crypto )
                <option class="option_crypto_currency" id="{{ $crypto->id }}" currency_symbol="{{ $crypto->symbol }}" value="{{ $crypto->name }}"></option>
            @endforeach
        @endif
    </select>
</datalist>
<datalist id="filter-seller-list">
    <select>
        {{--<option class="option_crypto_currency"></option>--}}
        @if ( $star_review_data )
            <?php
            $temp = array();
            foreach( $star_review_data as $idx=>$review_item ){
                if ( in_array( $review_item['maker_username'], $temp ) ) continue;
                echo "<option class='option_crypto_currency' value='{$review_item['maker_username']}'></option>";
                $temp[] = $review_item['maker_username'];
            }
            ?>
        @endif
    </select>
</datalist>
<datalist id="filter-buyer-list">
    <select>
        {{--<option class="option_crypto_currency"></option>--}}
        @if ( $star_review_data )
            <?php
            $temp = array();
            foreach( $star_review_data as $idx=>$review_item ){
                if ( in_array( $review_item['taker_username'], $temp ) ) continue;
                echo "<option class='option_crypto_currency' value='{$review_item['taker_username']}'></option>";
                $temp[] = $review_item['taker_username'];
            }
            ?>
        @endif
    </select>
</datalist>
<div class="row">
    <div class="col-md-4">
        <label class="lbl-search">Coin:</label>
        <input type="search" id="filter_coin" class="search_input search-star-review" placeholder="Find a specific coin" />
    </div>
    <div class="col-md-4">
        <label class="lbl-search">Seller:</label>
        <input type="search" id="filter_seller" class="search_input search-star-review" placeholder="Find a specific seller" />
    </div>
    <div class="col-md-4">
        <label class="lbl-search">Buyer:</label>
        <input type="search" id="filter_buyer" class="search_input search-star-review" placeholder="Find a specific buyer" />
    </div>
</div>
<div class="row">
    <div class="col-xs-12" style="padding: 0;">
        <table id="star_table" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="width:100%;">
            <thead>
            <tr>
                <th class="td-cell td-grey" width="30px">#</th>
                <th class="td-cell td-grey" width="22%">Coin</th>
                <th class="td-cell td-grey" width="22%">Price</th>
                <th class="td-cell td-grey" width="22%">Quantity</th>
                <th class="td-cell td-grey">Seller</th>
                <th class="td-cell td-grey">Buyer</th>
                <th class="td-cell td-grey">Buy/Sell</th>
                <th class="td-cell td-grey">Score</th>
                <th class="td-cell td-grey" width="200px">Comment</th>
            </tr>
            </thead>
            <tbody id="tbody_star_review_live_data" class="text-center">
            @if ( $star_review_data )
                @foreach( $star_review_data as $idx=>$review_item )
                    <tr>
                        <td class="td-cell text-center">{{ $idx+1 }}</td>
                        <td class="td-cell text-center">
                            <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{ $review_item['coin_id'] }}.png" width="32px" height="32px" />
                            &nbsp;<span>{{ $review_item['coin_name'] }}</span>
                        </td>
                        <td class="td-cell color-green text-center">${{ $review_item['purchased_price'] }}</td>
                        <td class="td-cell text-center">{{ $review_item['review_amount'] }}&nbsp;{{ $review_item['coin_symbol'] }}</td>
                        <td class="td-cell text-center">
                            <img src="{{ $review_item['maker_avatar'] }}" class="img-icon" />
                            &nbsp;<span>{{ $review_item['maker_username'] }}</span>
                        </td>
                        <td class="td-cell text-center">
                            <img src="{{ $review_item['taker_avatar'] }}" class="img-icon" />
                            &nbsp;<span>{{ $review_item['taker_username'] }}</span>
                        </td>
                        <td class="td-cell text-center">
                            <span class="{{ ( $review_item['order_side'] == 0 ) ? "color-green" : "color-red" }}" >
                                {{ ( $review_item['order_side'] == 0 ) ? "Buy" : "Sell" }}
                            </span>
                        </td>
                        <td class="td-cell text-center">{{ $review_item['review_score'] }}</td>
                        <td class="td-cell text-center">
                            <span class="span-comment" onclick="doOnClickContentView(this)">{{ $review_item['review_content'] }}</span>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
