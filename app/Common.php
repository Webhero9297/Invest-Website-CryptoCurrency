<?php

namespace App;


class Common
{
    //
    public static function getRealTimeCryptoCurrencyListEx() {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?limit=0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        return json_decode($response);
    }
    public static function getRealTimeCryptoCurrencyList() {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?limit=0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        return json_decode($response);
    }
    public static function getRealTimeCryptoCurrencyListPerPage($start, $limit=100) {
        ini_set('max_execution_time', '500');
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/?start='.$start.'&limit='.$limit);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        ini_set('max_execution_time', '30');
        return json_decode($response);
    }
    public static function getRealTimeCryptoCurrencyListPerPageEx($start, $currency='USD', $limit=100) {
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
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/'.$coinId.'/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        return json_decode($response);
    }
    public static function stdToArray($stdObj){
        $ret = array();
        foreach( $stdObj as $key=>$val ) {
            $ret[$key] = $val;
        }
        return $ret;
    }
    public static function getCurrencyInfoByCurrencyName( $real_data, $_currencyName ) {
        $ret_data = array();
        foreach( $real_data as $coinInfo ) {
            if ( $coinInfo->name == $_currencyName ) {
                foreach( $coinInfo as $key=>$value ) {
                    $ret_data[$key] = $value;
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
            $ret_data[] = $coin_data;
        }
        return $ret_data;
    }
    public static function getCoinDataFromRecordsExt( $real_data, $records ) {
        $ret_data = array();
        foreach( $records as $record ) {
            $coin_data = self::getCurrencyInfoByCurrencyName($real_data, $record['currency_name']);
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
            $coin_data['total_cost'] = $record['total_cost'];
            $coin_data['purchased_date'] = $record['purchased_date'];
            $coin_data['profit_loss'] = $coin_data['price_usd'] - $record['purchased_price'];
            $coin_data['profit_loss_percentage'] = ($coin_data['price_usd'] - $record['purchased_price'])/$coin_data['price_usd']*100;
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
                if ( $alertPrice >= $price ) {
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
}
