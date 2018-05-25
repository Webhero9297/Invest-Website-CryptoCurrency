<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoinMatch;
use App\Common;
use App\MatchReview;

class IndexController extends Controller
{
    //
    public function index() {
        return redirect()->route('home');
//        return view('frontend.home');
    }

    public function viewCoinMatchBiz() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $coin_file_data = Common::getRealTimeCryptoCurrencyListForFile();
        $coinMatchData = array();

        $other_buy_data = app(CoinMatch::class)->where('order_side', 0)->where('order_status', 0)->get();
        if ( $other_buy_data ) $coinMatchData = $other_buy_data->toArray();
        $other_buy_data = Common::remakeCoinDataWithFilesEx($cryptoData, $coin_file_data, $coinMatchData);
        $other_sell_data = app(CoinMatch::class)->where('order_side', 1)->where('order_status', 0)->get();
        if ( $other_sell_data ) $coinMatchData = $other_sell_data->toArray();
        $other_sell_data = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);

        $star_review_data = app(MatchReview::class)->orderBy('id', 'desc')->get();
        if ( $star_review_data ) $star_review_data = $star_review_data->toArray();
        $star_review_data = Common::remakeReviewData($cryptoData, $coin_file_data, $star_review_data);

        $order_data = json_encode(['other_buy_data'=>$other_buy_data, 'other_sell_data'=>$other_sell_data, 'star_review_data'=>$star_review_data]);

        return view('frontend.coinmatchbiz')->with(['buy_list'=>[], 'sell_list'=>[], 'other_buy_data'=>$other_buy_data,
            'other_sell_data'=>$other_sell_data, 'star_review_data'=>$star_review_data, 'global_biz'=>'1', 'cryptoData'=>$cryptoData, 'order_data'=>$order_data]);
    }
    public function viewLiveBiz() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $coin_file_data = Common::getRealTimeCryptoCurrencyListForFile();
        $coinMatchData = array();

        $other_buy_data = app(CoinMatch::class)->where('order_side', 0)->where('order_status', 0)->get();
        if ( $other_buy_data ) $coinMatchData = $other_buy_data->toArray();
        $other_buy_data = Common::remakeCoinDataWithFilesEx($cryptoData, $coin_file_data, $coinMatchData);
        $other_sell_data = app(CoinMatch::class)->where('order_side', 1)->where('order_status', 0)->get();
        if ( $other_sell_data ) $coinMatchData = $other_sell_data->toArray();
        $other_sell_data = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);

        $star_review_data = app(MatchReview::class)->orderBy('id', 'desc')->get();
        if ( $star_review_data ) $star_review_data = $star_review_data->toArray();
        $star_review_data = Common::remakeReviewData($cryptoData, $coin_file_data, $star_review_data);


        return response()->json(['other_buy_data'=>$other_buy_data, 'other_sell_data'=>$other_sell_data, 'star_review_data'=>$star_review_data]);
    }

    public function getOrderLiveData($userId) {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $coin_file_data = Common::getRealTimeCryptoCurrencyListForFile();
        $coinMatchData = array();
        if ( $userId != 'undefined' ) {
            $other_buy_data = app(CoinMatch::class)->where('user_id','<>', $userId)->where('order_side', 0)->where('order_status', 0)->get();
            if ( $other_buy_data ) $coinMatchData = $other_buy_data->toArray();
            $other_buy_data = Common::remakeCoinDataWithFilesEx($cryptoData, $coin_file_data, $coinMatchData, $userId);

            $other_sell_data = app(CoinMatch::class)->where('user_id','<>', $userId)->where('order_side', 1)->where('order_status', 0)->get();
            if ( $other_sell_data ) $coinMatchData = $other_sell_data->toArray();
            $other_sell_data = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);
        }
        else{
            $other_buy_data = app(CoinMatch::class)->where('order_side', 0)->where('order_status', 0)->get();
            if ( $other_buy_data ) $coinMatchData = $other_buy_data->toArray();
            $other_buy_data = Common::remakeCoinDataWithFilesEx($cryptoData, $coin_file_data, $coinMatchData);
            $other_sell_data = app(CoinMatch::class)->where('order_side', 1)->where('order_status', 0)->get();
            if ( $other_sell_data ) $coinMatchData = $other_sell_data->toArray();
            $other_sell_data = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);
        }
        $star_review_data = app(MatchReview::class)->orderBy('id', 'desc')->get();
        if ( $star_review_data ) $star_review_data = $star_review_data->toArray();
        $star_review_data = Common::remakeReviewData($cryptoData, $coin_file_data, $star_review_data);
        return response()->json(['other_buy_data'=>$other_buy_data, 'other_sell_data'=>$other_sell_data, 'star_review_data'=>$star_review_data]);
    }
}
