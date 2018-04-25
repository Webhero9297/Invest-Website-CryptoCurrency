<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;

class CoinsController extends Controller
{
    //
    public function index() {

//        $totalCount = ceil(count(Common::getRealTimeCryptoCurrencyList())/100);


//        if ( ($totalCount-intval($totalCount)) > 0 )
//            $totalCount++;
//        $totalCount = intval($totalCount);
//        $real_data = Common::getRealTimeCryptoCurrencyList();
//        $real_data = Common::getRealTimeCryptoCurrencyListPerPage(0);
        return view('frontend.coins');
    }
    public function getCoinDataByPagePos() {
        $currency = request()->get('currency');
        $real_data = Common::getRealTimeCryptoCurrencyListPerCurrency( $currency );
        $ret_data = array();
        foreach($real_data as $data) {
            $tmp = Common::stdToArray($data);
            $tmp['market_cap_usd'] = number_format($tmp['market_cap_'.strtolower($currency)], 2, '.', ',');
            $tmp['max_supply'] = number_format($tmp['max_supply'], 2, '.', ',');
            $tmp['total_supply'] = number_format($tmp['total_supply'], 2, '.', ',');
            $tmp['last_updated'] = number_format($tmp['last_updated'], 2, '.', ',');
            $tmp['current_price'] = $tmp['price_'.strtolower($currency)];

            $ret_data[] = $tmp;
        }
        return response()->json($ret_data);
    }
    public function getSearchDataForFilter($filter_name) {
        $currency = request()->get('currency');
        $coin_data = Common::getRealTimeCryptoCurrencyNameList($currency);
        $input = preg_quote(strtolower($filter_name), '~'); // don't forget to quote input string!
        $data = $coin_data['lower_name'];

        $search_result = preg_grep('~' . $input . '~', $data);

        $id_arr = [];
        $ret_data = array();
        foreach( $search_result as $idx=>$v ) {
            $temp = Common::stdToArray($coin_data['real_data'][$idx]);
            $temp['current_price'] = $temp['price_'.strtolower($currency)];
            $ret_data[] = $temp;
        }
//dd($data);
        return response()->json($ret_data);
    }
    public function coinChart( $coinId ) {
        $coinData = Common::getRealTimeCryptoCurrencyDataPerCoinId($coinId);
        $coin_data = Common::stdToArray($coinData[0]);
        return view('frontend.coinchart')->with(['coinData'=>$coin_data, 'coin_id'=>$coinId]);
    }
    public function coinLiveData($coinId) {
        $coinData = Common::getRealTimeCryptoCurrencyDataPerCoinId($coinId);
        $coin_data = Common::stdToArray($coinData[0]);
        $coin_data['price_usd'] = number_format($coin_data['price_usd'], 2, '.',',');
        $coin_data['mkt_cap_usd'] = number_format($coin_data['market_cap_usd'], 2, '.',',');
        $coin_data['h24_vol_usd'] = number_format($coin_data['24h_volume_usd'], 2, '.',',');
        return response()->json($coin_data);
    }
}
