<?php

namespace App\Http\Controllers;

use App\Common;
use Illuminate\Http\Request;
use App\User;
use App\UserCurrencyDetails;
use Iflylabs\iFlyChat;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedInUser = \Auth::user();
        $alert_message = 'sent';
        if ( !is_null($loggedInUser) ) {
            if ( $loggedInUser->notification_status == 1 ) {
                $alert_message = 'Thank you, your Moonfolio account have been activated!';
                $loggedInUser->notification_status = 2;
                $loggedInUser->save();
            }
        }
        $realTopCurrencies = Common::getRealTimeCryptoCurrencyListPerPage(0);
        $realTopCryptos = array();
        if ( $realTopCurrencies ){
            foreach($realTopCurrencies as $realCrypto) $realTopCryptos[] = Common::stdToArray($realCrypto);
        }
        $topUsers = Common::getTopPortfolios();
        $top_users = array();
        $default = '../assets/images/avatars/default.png';
        $real_data = Common::getRealTimeCryptoCurrencyList();
        if ( $topUsers ) {
            foreach( $topUsers as $top_user ){
                $topUser = Common::stdToArray($top_user);
                $user = app(User::class)->where('id', $topUser['id'])->first();
                (is_null($user->user_avatar))? $img_avatar = $default : $img_avatar = '../'.$user->user_avatar;

                $data = app(UserCurrencyDetails::class)->where('user_id', $user->id)->get();
                $user_currency_data = $data->toArray();
                $userCurrencyData = Common::getCoinDataFromRecordsExt($real_data, $user_currency_data);
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
                $topUser['invested_capital'] = $investedCapital;
                $topUser['current_value'] = $currentValue;
                if ( $investedCapital == 0 ) $investedCapital = 1;
                $topUser['total_profit_loss_percentage'] = number_format(($currentValue - $investedCapital)/$investedCapital*100, 2, '.',',');
                $top_users[] = $topUser;
            }
        }
        return view('frontend.home')->with(['topCryptos'=>$realTopCryptos, 'top_users'=>Common::sortArray($top_users, 'total_profit_loss_percentage'),
            'alert_message'=>$alert_message]);
    }
    public function getTopLiveData() {
        $realTopCurrencies = Common::getRealTimeCryptoCurrencyListPerPage(0, 8);
        $realTopCryptos = array();
        foreach($realTopCurrencies as $realCrypto) {
            $tmp = Common::stdToArray($realCrypto);
            $tmp['mkt_cap_usd'] = number_format($tmp['market_cap_usd'], 2, '.', ',');
            $tmp['h24_volume_usd'] = number_format($tmp['24h_volume_usd'], 2, '.', ',');
            $realTopCryptos[] = $tmp;
        }
        $topUsers = Common::getTopPortfolios();
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
        return response()->json(['topCryptos'=>$realTopCryptos, 'top_users'=>Common::sortArray($top_users, 'total_profit_loss_percentage')]);
    }

    public function termsOfView() {
        return view('frontend.termsofview');
    }
}
