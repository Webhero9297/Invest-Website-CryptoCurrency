<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;

class CoinsController extends Controller
{
    //
    public function index() {

        $totalCount = ceil(count(Common::getRealTimeCryptoCurrencyList())/100);
//        if ( ($totalCount-intval($totalCount)) > 0 )
//            $totalCount++;
//        $totalCount = intval($totalCount);
//        $real_data = Common::getRealTimeCryptoCurrencyList();
//        $real_data = Common::getRealTimeCryptoCurrencyListPerPage(0);
        return view('frontend.coins')->with(['totalCount'=>$totalCount]);
    }
    public function getCoinDataByPagePos( $pagePos ) {
        $currency = request()->get('currency');
        $pagePos *= 100;
        $real_data = Common::getRealTimeCryptoCurrencyListPerPageEx($pagePos, $currency);
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
    public function coinChart( $coinId ) {
        $coinData = Common::getRealTimeCryptoCurrencyDataPerCoinId($coinId);
        $coin_data = Common::stdToArray($coinData[0]);
        return view('frontend.coinchart')->with(['coinData'=>$coin_data]);
    }
}
