<?php

namespace App\Http\Controllers;

use App\CoinMatch;
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
        return view('frontend.coinmatchbiz');
    }
}
