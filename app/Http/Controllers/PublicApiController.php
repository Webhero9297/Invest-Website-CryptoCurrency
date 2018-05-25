<?php

namespace App\Http\Controllers;

use App\MatchReview;
use Illuminate\Http\Request;
use App\Common;
use App\User;
use App\UserCurrencyDetails;
use PHPUnit\Runner\Exception;
use App\CoinMatch;

class PublicApiController extends Controller
{
    //
    public function getLivePortfolioData() {
        $users = app(User::class)->all()->toArray();
        $default_avatar = './assets/images/avatars/default.png';
        try{
            $real_data = Common::getRealTimeCryptoCurrencyList();
            $file_json_data = Common::getRealTimeCryptoCurrencyListForFile();
            $model = new UserCurrencyDetails();
            $portfolios = array();
            if ( $users ) {
                foreach( $users as $user ) {
                    if ($user['isPrivate'] != 0 ) continue;
                    $arr = array();
                    $userCurrencyDatas = $model->getCoinsDataByUser($user['id']);
                    if ( count($userCurrencyDatas) == 0 ) continue;
                    $coin_datas = Common::getCoinDataFromRecordsEx($real_data, $userCurrencyDatas);
                    $investedCapital = 0;
                    $currentValue = 0;
                    $totalProfitLossValue = 0;
                    $coin_ids = array();
                    foreach( $coin_datas as $coin ) {
                        $investedCapital += $coin['total_cost']*1;
                        $currentValue += $coin['price_usd']*$coin['quantity'];
                        $totalProfitLossValue += $coin['profit_loss'];
                        $coin_ids[] = Common::getFileIdPerCoinId( $file_json_data, $coin['id'] );
                    }
                    $arr['full_name'] = $user['full_name'];
                    is_null($user['user_avatar']) ? $arr['avatar'] = $default_avatar : $arr['avatar'] = $user['user_avatar'];
                    $arr['invested_capital'] = number_format($investedCapital, 2, '.',',');
                    $arr['current_value'] = number_format($currentValue, 2, '.',',');
                    $temp = ($currentValue - $investedCapital);
                    $arr['total_profit_loss'] = number_format($temp, 2, '.',',');
                    $arr['coin_ids'] = $coin_ids;
                    $arr['user_id'] = $user['id'];
                    $portfolios[] = $arr;

                }
                return response()->json(['result'=>'success', 'data'=>Common::sortArray($portfolios, 'total_profit_loss')]);
            }
            else{
                return response()->json(['result'=>'fail', 'message'=>'user not found', 'data'=>[]]);
            }
        }
        catch(Exception $exp) {
            return response()->json(['result'=>'fail', 'message'=>'network_connection_fail', 'data'=>[]]);
        }
    }

    public function detailPortfolioAPI($userId) {
        $user = app(User::class)->where('id', $userId)->first();
        $default = '../assets/images/avatars/default.png';
        (is_null($user->user_avatar))? $img_avatar = $default : $img_avatar = '../'.$user->user_avatar;
        $full_name = $user->full_name;
        $email = $user->email;
        ($user->gender == 0) ? $gender = 'Male': $gender = 'Female';
        $age = $user->age*1;
        if ($age == 0) $age = 10;
        $country = $user->country;
        $isPrivate = $user->isPrivate;

        $data = app(UserCurrencyDetails::class)->where('user_id', $user->id)->get();
        $user_currency_data = array();
        $user_currency_data = $data->toArray();
        try{
            $dd = Common::getCoinCountFromRecordsEx($data);
            $userCurrencyData = Common::getCoinDataFromRecords($user_currency_data);

            $default_avatar = './assets/images/avatars/default.png';
            $arr = array();
            $investedCapital = 0;
            $currentValue = 0;
            $totalProfitLossValue = 0;
            $coin_ids = array();
            $profitlossPercentage = 0;
            $total_coins = 0;
            $currencyData = array();
            foreach( $userCurrencyData as $coin ) {
                $investedCapital += $coin['total_cost']*1;
                $currentValue += $coin['price_usd']*$coin['quantity'];
                $totalProfitLossValue += $coin['profit_loss'];
                $profitlossPercentage += $coin['profit_loss_percentage'];
                if ( $coin['price_usd']>100 ) {
                    $coin['price_usd'] = number_format($coin['price_usd'], 2, '.', ',');
                }
                else {
                    $coin['price_usd'] = number_format($coin['price_usd'],4, '.', ',');
                }
                if ( $coin['purchased_price']>100 ) {
                    $coin['purchased_price'] = number_format($coin['purchased_price'], 2, '.', ',');
                }
                else {
                    $coin['purchased_price'] = number_format($coin['purchased_price'], 4, '.', ',');
                }
                $currencyData[] = $coin;
                $coin_ids[] = $coin['id'];
                $total_coins += $coin['quantity'];
            }
            $arr['full_name'] = $user['full_name'];
            is_null($user['user_avatar']) ? $arr['avatar'] = $default_avatar : $arr['avatar'] = $user['user_avatar'];
            $arr['invested_capital'] = $investedCapital;
            $arr['current_value'] = $currentValue;
            $arr['total_profit_loss'] = $totalProfitLossValue;
            if ( $investedCapital == 0 ) $investedCapital = 1;
            $temp = ($currentValue / $investedCapital - 1)*100;
            $arr['total_profit_loss_percentage'] = $temp;//$profitlossPercentage;
            $arr['coins'] = count($dd);

            return response()->json(['result'=>'success', 'data'=>['user_avatar'=>$img_avatar, 'full_name'=>$full_name, 'email'=>$email,
                'gender'=>$gender, 'age'=>$age, 'country'=>$country, 'user_currency_data'=>$currencyData, 'isPrivate'=>$isPrivate, 'total_data'=>$arr, 'total_coins'=>$total_coins]]);
        }
        catch(Exception $exp) {
            return response()->json(['result'=>'fail', 'message'=>'network connection error']);
        }
    }
    public function getNews(){
        $url = "https://min-api.cryptocompare.com/data/news/?lang=EN";
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        try {
            $news_datas = json_decode($response);
            $news_data = array();
            foreach( $news_datas as $news ) {
                $tmp = Common::stdToArray($news);

                $cur_date = date_create(date('Y-m-d H:i:s'));
                $dd = date_create(date('Y-m-d H:i:s', $tmp['published_on']));

                $diff=date_diff($cur_date, $dd);

                $hours = $diff->format("%h");

                if ( $hours > 0 ){
                    $tmp['diff_time'] = $diff->format("%i Minutes %h Hours");
                }
                else{
                    $tmp['diff_time'] = $diff->format("%i Minutes");
                }
                $news_data[] = $tmp;
            }
            return response()->json(['result'=>'success', 'data'=>$news_data]);
        }
        catch( Exception $exp ) {
            return response()->json(['result'=>'fail', 'message'=>'network connection error', 'data'=>[]]);
        }

    }

    public function getTopLiveData() {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?start=0&limit=8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        try{
            $response = curl_exec($ch);
            $realTopCurrencies = json_decode($response);
        }
        catch(Exception $exp){
            return response()->json(['result'=>'fail', 'message'=>'network connection error']);
        }

        $realTopCryptos = array();
        foreach($realTopCurrencies as $realCrypto) {
            $tmp = Common::stdToArray($realCrypto);
            $tmp['mkt_cap_usd'] = number_format($tmp['market_cap_usd'], 2, '.', ',');
            $tmp['h24_volume_usd'] = number_format($tmp['24h_volume_usd'], 2, '.', ',');
            $realTopCryptos[] = $tmp;
        }

        try{
            $topUsers = Common::getTopPortfolios();
        }
        catch(Exception $exp) {
            return response()->json(['result'=>'fail', 'message'=>'top user list not found']);
        }
        $top_users = array();
        $default = '../assets/images/avatars/default.png';
        foreach( $topUsers as $top_user ){
            $topUser = Common::stdToArray($top_user);
            $user = app(User::class)->where('id', $topUser['id'])->first();
            (is_null($user->user_avatar))? $img_avatar = $default : $img_avatar = '../'.$user->user_avatar;

            $data = app(UserCurrencyDetails::class)->where('user_id', $user->id)->get();
            $user_currency_data = $data->toArray();
            $userCurrencyData = Common::getCoinDataFromRecords($user_currency_data);
            $default_avatar = './assets/images/avatars/default.png';
            $investedCapital = 0;
            $currentValue = 0;
            $profitlossPercentage = 0;
            foreach( $userCurrencyData as $coin ) {
                $investedCapital += $coin['total_cost']*1;
                $currentValue += $coin['price_usd']*$coin['quantity'];
                $profitlossPercentage += $coin['profit_loss_percentage'];
            }
            is_null($user['user_avatar']) ? $topUser['avatar'] = $default_avatar : $topUser['avatar'] = $user['user_avatar'];
            $topUser['invested_capital'] = number_format($investedCapital, 2, '.',',');
            $topUser['current_value'] = number_format($currentValue, 2, '.',',');
            $topUser['total_profit_loss_percentage'] = $topUser['total_profit_loss_percentage'] = number_format(($currentValue - $investedCapital)/$investedCapital*100, 2, '.',',');
            $top_users[] = $topUser;
        }
        return response()->json(['result'=>'success', 'data'=>['topCryptos'=>$realTopCryptos, 'top_users'=>Common::sortArray($top_users, 'total_profit_loss_percentage')]]);
    }

    public function getCoinDataByPagePos() {
        $currency = request()->get('currency');
        $real_data = Common::getRealTimeCryptoCurrencyListPerCurrencyAPI( $currency );
        if ( count($real_data) == 0 ) {
            return response()->json(['result'=>'fail', 'network connection error']);
        }
        else{
            $ret_data = array();
            $this->json_data = Common::getRealTimeCryptoCurrencyListForFile();
            foreach($real_data as $idx=>$data) {
                $tmp = Common::stdToArray($data);
                $tmp['market_cap_usd'] = number_format($tmp['market_cap_'.strtolower($currency)], 2, '.', ',');
                $tmp['max_supply'] = number_format($tmp['max_supply'], 2, '.', ',');
                $tmp['total_supply'] = number_format($tmp['total_supply'], 2, '.', ',');
                $tmp['last_updated'] = number_format($tmp['last_updated'], 2, '.', ',');
                $tmp['current_price'] = $tmp['price_'.strtolower($currency)];
                $tmp['img_id'] = $this->json_data[$idx]['id'];
                $ret_data[] = $tmp;
            }
            return response()->json(['result'=>'success', 'data'=>$ret_data]);
        }
    }
    public function getSearchDataForFilter($filter_name) {
        $currency = request()->get('currency');
        $coin_data = Common::getRealTimeCryptoCurrencyNameListAPI($currency);

        if ( count($coin_data) == 0 ) {
            return response()->json(['result'=>'fail', 'message'=>'network connection error']);
        }
        else{
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
            return response()->json(['result'=>'success', 'data'=>$ret_data]);
        }
    }
    public function coinLiveData($coinId) {
        $coinData = Common::getRealTimeCryptoCurrencyDataPerCoinIdAPI($coinId);

        if ( count($coinData) == 0 ) {
            return response()->json(['result'=>'fail', 'message'=>'network connection error']);
        }
        else {
            $coin_data = Common::stdToArray($coinData[0]);
            $coin_data['price_usd'] = number_format($coin_data['price_usd'], 2, '.',',');
            $coin_data['mkt_cap_usd'] = number_format($coin_data['market_cap_usd'], 2, '.',',');
            $coin_data['h24_vol_usd'] = number_format($coin_data['24h_volume_usd'], 2, '.',',');
            return response()->json(['result'=>'success', 'data'=>$coin_data]);
        }
    }
    public function viewLiveBiz() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        if ( count($cryptoData) == 0 ) {
            return response()->json(['result'=>'fail', 'message'=>'network connection error']);
        }
        else {
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

            return response()->json(['result'=>'success', 'data'=>['other_buy_data'=>$other_buy_data, 'other_sell_data'=>$other_sell_data, 'star_review_data'=>$star_review_data]]);
        }
    }
}
