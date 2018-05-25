<?php

namespace App;
use App\User;

class Common
{
    //
    public static function getRealTimeCryptoCurrencyListEx() {
//        $ch = curl_init();
//        $headers = array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//        );
//        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?limit=0');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//
//        $response = curl_exec($ch);
//        return json_decode($response);
        $ret_arr = array();
        $model = new CronTickerV1();
        $datas = $model->getCoinList();
        if ( $datas ) return $ret_arr = $datas->toArray();
        return $ret_arr;
    }
    public static function getRealTimeCryptoCurrencyList() {
//        $ch = curl_init();
//        $headers = array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//        );
//        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?limit=0');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//
//        $response = curl_exec($ch);
//        if(curl_errno($ch))
//        {
//            return [];
//        }
////        $response = curl_exec($ch);
//        return json_decode($response);
        $ret_arr = array();
        $model = new CronTickerV1();
        $datas = $model->getCoinList();
        if ( $datas ) return $ret_arr = $datas->toArray();
        return $ret_arr;
    }
    public static function getRealTimeCryptoCurrencyNameList($currency='USD') {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?convert='.$currency.'&limit=0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $responses = json_decode(curl_exec($ch));
        $ret = [];
        if ( $responses ) {
            foreach ($responses as $crypto) {
                $ret['id'][] = $crypto->id;
                $ret['name'][] = $crypto->name;
                $ret['lower_name'][] = strtolower($crypto->name);
                $ret['symbol'][] = $crypto->symbol;
            }
        }
        $ret['real_data'] = $responses;
        return $ret;
    }
    public static function getRealTimeCryptoCurrencyNameListAPI($currency='USD') {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?convert='.$currency.'&limit=0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $fb = curl_exec($ch);
        curl_close($ch);

        $ret = [];
        if($fb !== false) {
            $responses = json_decode($fb);
            if ( $responses ) {
                foreach ($responses as $crypto) {
                    $ret['id'][] = $crypto->id;
                    $ret['name'][] = $crypto->name;
                    $ret['lower_name'][] = strtolower($crypto->name);
                    $ret['symbol'][] = $crypto->symbol;
                }
            }
            $ret['real_data'] = $responses;
        }

        return $ret;

    }
    public static function getRealTimeCryptoCurrencyListPerPage($start, $limit=100) {
//        ini_set('max_execution_time', '500');
//        $ch = curl_init();
//        $headers = array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//        );
//        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?start='.$start.'&limit='.$limit);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//
//        $response = curl_exec($ch);
////        ini_set('max_execution_time', '30');
//        return json_decode($response);
        $model = new CronTickerV1();
        $datas = $model->getCoinList();

        if ( $datas ) return $datas->toArray();
        return [];
    }
    public static function getRealTimeCryptoCurrencyListPerCurrency( $currency='USD') {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?convert='.$currency.'&limit=0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        return json_decode($response);
//        $model = new CronTickerV1();
//        $datas = $model->getCoinList();
//
//        if ( $datas ) return $datas->toArray();
//        return [];
    }
    public static function getRealTimeCryptoCurrencyListPerCurrencyAPI( $currency='USD') {
//        $ch = curl_init();
//        $headers = array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//        );
//        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?convert='.$currency.'&limit=0');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//
//        $response = curl_exec($ch);
//        if($response !== false) {
//            return json_decode($response);
//        }
//        return [];
        $model = new CronTickerV1();
        $datas = $model->getCoinList();

        if ( $datas ) return $datas->toArray();
        return [];
    }
    public static function getRealTimeCryptoCurrencyListForFile() {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://s2.coinmarketcap.com/generated/search/quick_search.json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = json_decode(curl_exec($ch) );
        $ret = array();
        foreach( $response as $res ) {
            $ret[] = self::stdToArray($res);
        }
        return $ret;
    }
    public static function getFileIdPerCoinId( $json_data, $coin_id ) {

        foreach( $json_data as $dd ) {
            if ( $dd['slug'] != $coin_id ) continue;
            return $dd['id'];
        }
        return -1;
    }
    public static function getRealTimeCryptoCurrencyListPerPageEx($start, $currency='USD', $limit=0) {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?convert='.$currency.'&start='.$start.'&limit='.$limit);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        return json_decode($response);
    }
    public static function getRealTimeCryptoCurrencyDataPerCoinId($coinId) {
//        $ch = curl_init();
//        $headers = array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//        );
//        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/'.$coinId.'/');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//
//        $response = curl_exec($ch);
//        return json_decode($response);
        $model = new CronTickerV1();
        $datas = $model->where('id', $coinId)->first();

        if ( $datas ) return $datas->toArray();
        return [];
    }
    public static function getRealTimeCryptoCurrencyDataPerCoinIdAPI($coinId) {
//        $ch = curl_init();
//        $headers = array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//        );
//        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/'.$coinId.'/');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//
//        $response = curl_exec($ch);
//        if($response !== false) {
//            return json_decode($response);
//        }
//        return [];
        $model = new CronTickerV1();
        $datas = $model->where('id', $coinId)->first();

        if ( $datas ) return $datas->toArray();
        return [];
    }
    public static function stdToArray($stdObj){
        $ret = array();
        if ( $stdObj ) {
            foreach( $stdObj as $key=>$val ) {
                $ret[$key] = $val;
            }
        }
        return $ret;
    }
    public static function getCurrencyInfoByCurrencyName( $real_data, $_currencyName ) {
        $ret_data = array();
        if ( count($real_data) > 0 ) {
            foreach( $real_data as $coinInfo ) {
                if ( $coinInfo['name'] == $_currencyName ) {
                    foreach( $coinInfo as $key=>$value ) {
                        $ret_data[$key] = $value;
                    }
                }
            }
        }
        return $ret_data;
    }
    public static function getCurrencyInfoByCurrencyNameEx( $real_data, $_currencyName ) {
        $ret_data = array();
        if ( count($real_data) > 0 ) {
            foreach( $real_data as $coinInfo ) {
                if ( $coinInfo['name'] == $_currencyName ) {
                    foreach( $coinInfo as $key=>$value ) {
                        $ret_data[$key] = $value;
                    }
                }
            }
        }
        return $ret_data;
    }
    public static function getCurrencyInfoInCurrencyNameArray( $_currencyName_arr ) {
        $real_data = self::getRealTimeCryptoCurrencyList();
        $ret_data = array();
        foreach( $real_data as $coinInfo ) {
            if ( in_array($coinInfo->name, $_currencyName_arr) ) {
                $tmp = array();
                foreach( $coinInfo as $key=>$value ) {
                    $tmp[$key] = $value;
                }
                $ret_data[] = $tmp;
            }
        }
        return $ret_data;
    }
    public static function getCurrencyInfoInCurrencyNameArrayEx( $real_data, $_currencyName_arr ) {
        $ret_data = array();
        foreach( $real_data as $coinInfo ) {
            if ( in_array($coinInfo->name, $_currencyName_arr) ) {
                $tmp = array();
                foreach( $coinInfo as $key=>$value ) {
                    $tmp[$key] = $value;
                }
                $ret_data[] = $tmp;
            }
        }
        return $ret_data;
    }
    public static function getCoinArrayFromRecords( $records ) {
        $ret_data = array();
        foreach( $records as $record ) {
            $ret_data[] = $record['currency_name'];
        }
        return $ret_data;
    }
    public static function getCoinArrayFromRecordsEx( $records ) {
        $ret_data = array();
        foreach( $records as $record ) {
            $ret_data[] = $record->currency_name;
        }
        return $ret_data;
    }
    public static function getCoinCountFromRecordsEx( $records ) {
        $ret_data = array();
        foreach( $records as $record ) {
            $ret_data[$record->currency_name] = $record->currency_name;
        }
        return $ret_data;
    }
    public static function getCoinDataFromRecordsEx( $real_data, $records ) {
        $ret_data = array();
        foreach( $records as $record ) {
            $coin_data = self::getCurrencyInfoByCurrencyName($real_data, $record->currency_name);
            if ( count($coin_data)==0 ) continue;
            $coin_data['quantity'] = $record->quantity;
            $coin_data['total_cost'] = $record->total_cost;
            $coin_data['profit_loss'] = $coin_data['price_usd']*$record->quantity - $record->total_cost;
//            $coin_data['profit_loss'] = ($coin_data['price_usd'] / $record->purchased_price)*100-100;
            $ret_data[] = $coin_data;
        }
        return $ret_data;
    }
    public static function getCoinDataFromRecordsExt( $real_data, $records ) {
        $ret_data = array();
        foreach( $records as $record ) {
            $coin_data = self::getCurrencyInfoByCurrencyNameEx($real_data, $record['currency_name']);
            if ( count($coin_data)==0 ) continue;
            $coin_data['quantity'] = $record['quantity'];
            $coin_data['purchased_price'] = $record['purchased_price'];
            $coin_data['total_cost'] = $record['total_cost'];
            $coin_data['purchased_date'] = $record['purchased_date'];
            $coin_data['profit_loss'] = $coin_data['price_usd'] - $record['purchased_price'];
            $coin_data['profit_loss_percentage'] = ($coin_data['price_usd'] - $record['purchased_price'])/$coin_data['price_usd']*100;
            $coin_data['detail_id'] = $record['detail_id'];
            $ret_data[] = $coin_data;
        }
        return $ret_data;
    }
    public static function getCoinDataFromRecords( $records ) {
        $ret_data = array();
        $real_data = self::getRealTimeCryptoCurrencyList();
        foreach( $records as $record ) {
            $coin_data = self::getCurrencyInfoByCurrencyName($real_data, $record['currency_name']);
            if ( count($coin_data)==0 ) continue;
            $coin_data['quantity'] = $record['quantity'];
            $coin_data['purchased_price'] = $record['purchased_price'];
            $coin_data['total_cost'] = $record['purchased_price']*$record['quantity'];
            $coin_data['purchased_date'] = $record['purchased_date'];
            $coin_data['profit_loss'] = ( $coin_data['price_usd'] - $record['purchased_price'] ) * $record['quantity'];
            if ( $record['purchased_price'] == 0 ) $record['purchased_price'] = 1;
            $coin_data['profit_loss_percentage'] = ($coin_data['price_usd'] / $record['purchased_price'])*100-100;
            $coin_data['detail_id'] = $record['detail_id'];
            $ret_data[] = $coin_data;
        }
        return $ret_data;
    }

    public static function getTopPortfolios($limit=8) {
        $sql = "SELECT user_currency_details.currency_name, SUM(user_currency_details.quantity) quantity, SUM(user_currency_details.total_cost) total_cost, users.* FROM `user_currency_details`
                JOIN users
                ON user_currency_details.user_id = users.id
                WHERE users.isPrivate = 0
                GROUP BY user_currency_details.user_id
                ORDER BY total_cost DESC
                LIMIT 0, {$limit}";
        $data = \DB::select(\DB::raw($sql));
        if ( $data ) return $data;
        return [];
    }

    public static function getAlertCoinData( $user_id ) {
        $ret = array();
        $sql = "select * from coin_alert
                         where user_id = {$user_id} and (email_sent_state = 0 or audio_sent_state = 0)
                         order by created_at DESC";

//        $data = app(CoinAlert::class)->where('user_id', $user_id)->where('email_sent_state', 0)->orWhere('audio_sent_state', 0)->orderBy('created_at', 'desc')->get();
        $data = \DB::select(\DB::raw($sql));
//        var_dump(print_r($data, true));exit;
        if ($data) {
//            $data = $data->toArray();
            foreach( $data as $d ) {
                $d = self::stdToArray($d);
                $coin_live_data = self::getRealTimeCryptoCurrencyDataPerCoinId($d['coin_id']);
                $coin_data = self::stdToArray($coin_live_data[0]);
                $price = $coin_data['price_'.strtolower($d['fiat'])];
                $alertPrice = $d['limit_price'];
                if ( $d['limit_type'] == 0 && $alertPrice >= $price ) {
                    $d['current_price'] = $price;
                    $d['percent_1h'] = $coin_data['percent_change_1h'];
                    $d['symbol'] = $coin_data['symbol'];
                    $ret[] = $d;
                }
                if ( $d['limit_type'] == 1 && $alertPrice <= $price ) {
                    $d['current_price'] = $price;
                    $d['percent_1h'] = $coin_data['percent_change_1h'];
                    $d['symbol'] = $coin_data['symbol'];
                    $ret[] = $d;
                }
            }
        }
//        var_dump(print_r($ret, true));exit;

        return $ret;
    }

    public static function sortArray( $arr, $byKey, $sort_direct='desc' ) {
        $key_arr = array();
        foreach ($arr as $key => $row)
        {
            $key_arr[$key] = intval($row[$byKey]);
        }
        if ( $sort_direct == 'asc')
            array_multisort($key_arr, SORT_ASC, $arr);
        else
            array_multisort($key_arr, SORT_DESC, $arr);
        return $arr;
    }

    public static function getInvestedCoinAmountPerUserId( $user_id, $coin_name ) {
        $model = new UserCurrencyDetails();
        return $model->getInvestedCoinNamePerUserId( $user_id, $coin_name );
    }
    public static function getSoldCoinAmountPerUserId( $user_id, $coin_name ) {
        $model = new CoinMatch();
        return $model->getSoldCoinAmountPerUserId( $user_id, $coin_name );
    }
    public static function getUserInfoFromId( $user_id ) {
        $user_data = User::where('id', $user_id)->first();
        if ( $user_data ){
            $ret = $user_data->toArray();
            if ( is_null($ret['user_avatar']) ) $ret['user_avatar'] = './assets/images/avatars/default.png';
            return $ret;
        }
        return [];
    }
    public static function remakeCoinDataWithFiles( $realCoinDatas, $coin_file_arr, $coin_match_datas ) {
        $real_coin_name_arr = array();
        $real_coin_id_arr = array();
        $real_coin_price_arr = array();
        $ret = array();
        if ( $coin_match_datas ) {
            foreach( $realCoinDatas as $idx=>$real_coin ) {
                if ( isset($coin_file_arr[$idx]) ) {
                    $real_coin_id_arr[] = $coin_file_arr[$idx];
                    $real_coin_name_arr[] = $coin_file_arr[$idx]['name'];
                    $real_coin_price_arr[] = $real_coin['price_usd'];
                }
            }
            foreach( $coin_match_datas as $idx=>$coin_match ) {
                $index = array_search($coin_match['coin_name'], $real_coin_name_arr);
                if ( $index != -1 ) {
                    $coin_match['coin_id'] = $real_coin_id_arr[$index]['id'];
                    $coin_match['coin_symbol'] = $real_coin_id_arr[$index]['symbol'];
                    $user_info = self::getUserInfoFromId($coin_match['user_id']);
                    $coin_match['user_full_name'] = $user_info['full_name'];
                    $coin_match['user_avatar'] = $user_info['user_avatar'];
                    $coin_match['user_email'] = $user_info['email'];
                    $coin_match['user_id'] = $user_info['id'];
                    $coin_match['current_price'] = $real_coin_price_arr[$index];
                }
//                if( $coin_match['coin_name'] == 'Centra' ) {
//                    dd($index, $coin_file_arr);
//                    dd($index, $coin_match, $real_coin_id_arr[$index],$real_coin_name_arr[$index], $coin_file_arr);
//                }
                $ret[] = $coin_match;
            }
        }
        return $ret;
    }
    public static function remakeCoinDataWithFilesEx( $realCoinDatas, $coin_file_arr, $coin_match_datas, $user_id=null ) {
        $real_coin_name_arr = array();
        $real_coin_id_arr = array();
        $real_coin_price_arr = array();
        $ret = array();
        if ( $coin_match_datas ) {
            foreach( $realCoinDatas as $idx=>$real_coin ) {
                if ( isset($coin_file_arr[$idx]) ) {
                    $real_coin_id_arr[] = $coin_file_arr[$idx];
                    $real_coin_name_arr[] = $coin_file_arr[$idx]['name'];
                    $real_coin_price_arr[] = $real_coin->price_usd;
                }
            }
            $invested_coinname_arr = array();
            $enable_status = 0;
            if ( !is_null($user_id) ) {
                $userInvestedCoinData = app(UserCurrencyDetails::class)->where('user_id', $user_id)->get();
                if ( $userInvestedCoinData ) {
                    $userInvestedCoinData = $userInvestedCoinData->toArray();
                    foreach( $userInvestedCoinData as $coin ) {
                        $invested_coinname_arr[] = $coin['currency_name'];
                    }
                    $enable_status = 1;
                }
            }
            foreach( $coin_match_datas as $idx=>$coin_match ) {
                $index = array_search($coin_match['coin_name'], $real_coin_name_arr);

                if ( $index != -1 ) {
                    $coin_match['coin_id'] = $real_coin_id_arr[$index]['id'];
                    $coin_match['coin_symbol'] = $real_coin_id_arr[$index]['symbol'];
                    $user_info = self::getUserInfoFromId($coin_match['user_id']);
                    $coin_match['user_full_name'] = $user_info['full_name'];
                    $coin_match['user_avatar'] = $user_info['user_avatar'];
                    $coin_match['user_email'] = $user_info['email'];
                    $coin_match['user_id'] = $user_info['id'];
                    $coin_match['current_price'] = $real_coin_price_arr[$index];
                    if ( $enable_status == 1 ) {
                        $_index = in_array($coin_match['coin_name'], $invested_coinname_arr);
                        if ( $_index != false ) {
                            $coin_match['enable_status'] = 1;
                        }
                        else {
                            $coin_match['enable_status'] = 0;
                        }
                    }
                    else {
                        $coin_match['enable_status'] = 0;
                    }
                }
//                if( $coin_match['coin_name'] == 'Centra' ) {
//                    dd($index, $coin_file_arr);
//                    dd($index, $coin_match, $real_coin_id_arr[$index],$real_coin_name_arr[$index], $coin_file_arr);
//                }
                $ret[] = $coin_match;
            }
        }
        return $ret;
    }
    public static function remakeReviewData( $realCoinDatas, $coin_file_arr, $coin_review_datas ) {
        $real_coin_name_arr = array();
        $real_coin_id_arr = array();
        $ret = array();
        if ( $coin_review_datas ) {
            foreach( $realCoinDatas as $idx=>$real_coin ) {
                if ( isset($coin_file_arr[$idx]) ) {
                    $real_coin_id_arr[] = $coin_file_arr[$idx];
                    $real_coin_name_arr[] = $coin_file_arr[$idx]['name'];
                }
            }
            foreach( $coin_review_datas as $idx=>$coin_review ) {
                $t  =app(CoinMatch::class)->where('match_id', $coin_review['match_id'])->first();
                if ( !$t ) continue;
                $coin_match = $t->toArray();
                $index = array_search($coin_match['coin_name'], $real_coin_name_arr);
                if ( $index != -1 ) {
                    $coin_review['coin_name'] = $coin_match['coin_name'];
                    $coin_review['order_side'] = $coin_match['order_side'];
                    $coin_review['purchased_price'] = $coin_match['purchased_price'];
                    $coin_review['coin_id'] = $real_coin_id_arr[$index]['id'];
                    $coin_review['coin_symbol'] = $real_coin_id_arr[$index]['symbol'];
                    $coin_review['maker_id'] = $coin_match['user_id'];
                    $coin_review['taker_id'] = $coin_review['review_user_id'];
                    $maker_info = self::getUserInfoFromId($coin_match['user_id']);
                    $coin_review['maker_username'] = $maker_info['full_name'];
                    $coin_review['maker_avatar'] = $maker_info['user_avatar'];
                    $taker_info = self::getUserInfoFromId($coin_review['review_user_id']);
                    $coin_review['taker_username'] = $taker_info['full_name'];
                    $coin_review['taker_avatar'] = $taker_info['user_avatar'];
                }
                $ret[] = $coin_review;
            }
        }
        return $ret;
    }

    public static function createNewCCUser( $user ) {
        $curl = curl_init();
        $logo_link = "/assets/images/avatars/default.jpg";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chatcamp.io/api/1.0/users.create",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('x-app-id: 6395294894813868032', 'x-api-key: dU94VDAvZzhGdzluN3NKZEUwWkhCZz09'),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "id=".$user->id."&display_name=".$user->full_name."&avatar_url={$logo_link}&email={$user->email}",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return array('result'=>$response, 'err'=>$err);
    }
    public static function changeDataOfCCUser( $user ) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chatcamp.io/api/1.0/users.update",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('x-app-id: 6395294894813868032', 'x-api-key: dU94VDAvZzhGdzluN3NKZEUwWkhCZz09'),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "id={$user->id}&display_name={$user->full_name}&email={$user->email}",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return array('result'=>$response, 'err'=>$err);
    }
    public static function changeAvatarOfCCUser( $user ) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chatcamp.io/api/1.0/users.update",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('x-app-id: 6395294894813868032', 'x-api-key: dU94VDAvZzhGdzluN3NKZEUwWkhCZz09'),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "id=".$user->id."&avatar_url={$user->user_avatar}",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return array('result'=>$response, 'err'=>$err);
    }
    public static function deleteCCUser( $user ) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chatcamp.io/api/1.0/users.delete",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('x-app-id: 6395294894813868032', 'x-api-key: dU94VDAvZzhGdzluN3NKZEUwWkhCZz09'),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "id=".$user->id,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return array('result'=>$response, 'err'=>$err);
    }
    public static function listOfCCUser() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chatcamp.io/api/1.0/users.list",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('x-app-id: 6395294894813868032', 'x-api-key: dU94VDAvZzhGdzluN3NKZEUwWkhCZz09'),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST"
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return array('result'=>json_decode($response), 'err'=>$err);
    }
    public static function test() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chatcamp.io/api/1.0/group_channels.message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('x-app-id: 6395294894813868032', 'x-api-key: dU94VDAvZzhGdzluN3NKZEUwWkhCZz09'),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "id=5af9e9de48bdc63696fbd040&user_id=markhan0321@gmail.com&type=text&text=ABCDEFGHI"
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return array('result'=>json_decode($response), 'err'=>$err);
    }
    public static function testEx($user) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.chatcamp.io/api/1.0/group_channels.my_list",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('x-app-id: 6395294894813868032', 'x-api-key: dU94VDAvZzhGdzluN3NKZEUwWkhCZz09'),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "user_id={$user->id}"
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return array('result'=>json_decode($response), 'err'=>$err);
    }
}
