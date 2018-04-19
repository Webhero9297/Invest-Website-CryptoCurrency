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
                $coin_ids[] = $coin['id'];
            }
            $arr['full_name'] = $user['full_name'];
            is_null($user['user_avatar']) ? $arr['avatar'] = $default_avatar : $arr['avatar'] = $user['user_avatar'];
            $arr['invested_capital'] = number_format($investedCapital, 2, '.',',');
            $arr['current_value'] = number_format($currentValue, 2, '.',',');
            $arr['total_profit_loss'] = number_format($totalProfitLossValue, 2, '.',',');
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
        foreach( $userCurrencyData as $coin ) {
            $investedCapital += $coin['total_cost']*1;
            $currentValue += $coin['price_usd']*$coin['quantity'];
            $totalProfitLossValue += $coin['profit_loss'];
            $profitlossPercentage += $coin['profit_loss_percentage'];
            $coin_ids[] = $coin['id'];
        }
        $arr['full_name'] = $user['full_name'];
        is_null($user['user_avatar']) ? $arr['avatar'] = $default_avatar : $arr['avatar'] = $user['user_avatar'];
        $arr['invested_capital'] = $investedCapital;
        $arr['current_value'] = $currentValue;
        $arr['total_profit_loss'] = $totalProfitLossValue;
        $arr['total_profit_loss_percentage'] = $profitlossPercentage;
        $arr['coins'] = count($dd);

        return view('frontend.detailportfolio')->with(['user_avatar'=>$img_avatar, 'full_name'=>$full_name, 'email'=>$email,
            'gender'=>$gender, 'age'=>$age, 'country'=>$country, 'user_currency_data'=>$userCurrencyData, 'isPrivate'=>$isPrivate, 'total_data'=>$arr]);
    }
}
