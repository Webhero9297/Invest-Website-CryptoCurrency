<?php

namespace App\Http\Controllers;

use App\CoinMatch;
use App\MatchReview;
use Illuminate\Http\Request;
use App\Common;

class CoinMatchController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $coin_file_data = Common::getRealTimeCryptoCurrencyListForFile();
        $coin_name='';
        $quantity=0;
        $purchased_price=0;
        $purchased_date=date('Y-m-d');
        $order_side = 0;
        $user_id = \Auth::user()->id;
        $coinMatchData = array();
        $data = app(CoinMatch::class)->where('user_id', $user_id)->get();
        if ( $data ) $coinMatchData = $data->toArray();
        $coinMatchData = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);
        return view('frontend.coinmatchview')->with(['match_id'=>'NULL', 'coin_name'=>$coin_name, 'quantity'=>$quantity,
            'purchased_price'=>$purchased_price, 'purchased_date'=>$purchased_date, 'cryptoData'=>$cryptoData, 'order_side'=>$order_side, 'coin_match_data'=>$coinMatchData]);
    }
    public function getInvestedCoinAmount($coin_name) {
        $user_id = \Auth::user()->id;
        $totalInvestedAmount = Common::getInvestedCoinAmountPerUserId($user_id, $coin_name);
        $totalSoldAmount = Common::getSoldCoinAmountPerUserId($user_id, $coin_name);
        return response()->json(['invested'=>$totalInvestedAmount, 'sold'=>$totalSoldAmount]);
    }

    public function storeCoinMatch() {
        $coin_name = request()->input('coin_name');
        $quantity = request()->input('quantity');
        $order_side = request()->input('order_side');
        $match_id = request()->input('match_id');
        $purchased_price = request()->input('purchased_price');
        $purchased_date = request()->input('purchased_date');
        $user = \Auth::user();

        if ( strtoupper($match_id) != 'NULL' ) {
            $model = app(CoinMatch::class)->where('match_id', $match_id)->first();
        }
        else {
            $model = new CoinMatch();
        }
        $model->user_id = $user->id;
        $model->coin_name = $coin_name;
        $model->quantity = $quantity;
        $model->purchased_price = $purchased_price;
        $model->purchased_date = $purchased_date;
        $model->order_side = $order_side;
        $model->save();

        return redirect()->route('coin.match.view');
    }
    public function deleteCoinMatch($match_id) {
        $model = new CoinMatch();
        $model->where('match_id', $match_id)->delete();
        echo 'ok';
    }
    public function viewCoinMatchBiz() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $coin_file_data = Common::getRealTimeCryptoCurrencyListForFile();
        $user_id = \Auth::user()->id;
        $coinMatchData = array();
        $buy_data = app(CoinMatch::class)->where('user_id', $user_id)->where('order_side', 0)->where('order_status', 0)->get();
        if ( $buy_data ) $coinMatchData = $buy_data->toArray();
        $buy_data = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);
        $sell_data = app(CoinMatch::class)->where('user_id', $user_id)->where('order_side', 1)->where('order_status', 0)->get();
        if ( $sell_data ) $coinMatchData = $sell_data->toArray();
        $sell_data = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);

        $other_buy_data = app(CoinMatch::class)->where('user_id','<>', $user_id)->where('order_side', 0)->where('order_status', 0)->get();
        if ( $other_buy_data ) $coinMatchData = $other_buy_data->toArray();
        $other_buy_data = Common::remakeCoinDataWithFilesEx($cryptoData, $coin_file_data, $coinMatchData, $user_id);

        $other_sell_data = app(CoinMatch::class)->where('user_id','<>', $user_id)->where('order_side', 1)->where('order_status', 0)->get();
        if ( $other_sell_data ) $coinMatchData = $other_sell_data->toArray();
        $other_sell_data = Common::remakeCoinDataWithFiles($cryptoData, $coin_file_data, $coinMatchData);

        $star_review_data = app(MatchReview::class)->get();
        if ( $star_review_data ) $star_review_data = $star_review_data->toArray();
        $star_review_data = Common::remakeReviewData($cryptoData, $coin_file_data, $star_review_data);
//dd($other_buy_data);
        return view('frontend.coinmatchbiz')->with(['buy_list'=>$buy_data, 'sell_list'=>$sell_data, 'other_buy_data'=>$other_buy_data, 'other_sell_data'=>$other_sell_data, 'star_review_data'=>$star_review_data]);
    }
    public function storeReviewInfo() {
        $user = \Auth::user();
        $model = new MatchReview();
        $match_id = request()->get('match_id');
        $review_amount = request()->get('review_amount');
        $review_score = request()->get('review_score');
        $review_content = request()->get('review_content');
        ( request()->get('order_side') == 'sell') ? $review_order_side = 1: $review_order_side = 0;

        $model->match_id = $match_id;
        $model->review_user_id = $user->id;
        $model->review_amount = $review_amount;
        $model->review_score = $review_score;
        $model->review_content = $review_content;
        $model->review_order_side = $review_order_side;
        $model->save();

        $match_record = app(CoinMatch::class)->where('match_id', $match_id)->first();
        if ( $match_record->order_status == 0 ) {
            $originQ = $match_record->quantity;
            $remain = $originQ - $review_amount;
            $order_status = 0;
            if ( $remain <= 0 ) $order_status = 1;
            $match_record->decrement('quantity', $review_amount);
            $match_record->increment('ordered_quantity', $review_amount);
            $match_record->order_status = $order_status;
            $match_record->save();
        }

        return redirect()->route('coinmatch.biz');
    }

}
