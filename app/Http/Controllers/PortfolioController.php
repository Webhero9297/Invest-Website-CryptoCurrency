<?php

namespace App\Http\Controllers;

use App\Common;
use App\User;
use App\UserCurrencyDetails;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    //
    public function index() {
        return view('frontend.portfolio');
    }
    public function getLivePortfolioData() {
        $users = app(User::class)->all()->toArray();
        $default_avatar = './assets/images/avatars/default.png';
        $real_data = Common::getRealTimeCryptoCurrencyList();
        $file_json_data = Common::getRealTimeCryptoCurrencyListForFile();
        $model = new UserCurrencyDetails();
        $portfolios = array();
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

        return response()->json(Common::sortArray($portfolios, 'total_profit_loss'));
    }
    public function detailPortfolio($userId) {
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

        return view('frontend.detailportfolio')->with(['user_avatar'=>$img_avatar, 'full_name'=>$full_name, 'email'=>$email,
            'gender'=>$gender, 'age'=>$age, 'country'=>$country, 'user_currency_data'=>$currencyData, 'isPrivate'=>$isPrivate, 'total_data'=>$arr, 'total_coins'=>$total_coins]);
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

        return response()->json(['user_avatar'=>$img_avatar, 'full_name'=>$full_name, 'email'=>$email,
            'gender'=>$gender, 'age'=>$age, 'country'=>$country, 'user_currency_data'=>$currencyData, 'isPrivate'=>$isPrivate, 'total_data'=>$arr, 'total_coins'=>$total_coins]);
    }
}
