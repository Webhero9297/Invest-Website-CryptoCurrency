<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCurrencyDetails extends Model
{
    //
    protected $table='user_currency_details';
    public $primaryKey = 'detail_id';
    public $timestamps=false;

    public function getCoinsDataByUser($user_id) {
        $data = \DB::select("select currency_name, sum(quantity) quantity, sum(purchased_price*quantity) total_cost from `user_currency_details` where `user_id` = '{$user_id}' group by `currency_name`");
        return $data;
    }

    public function getInvestedCoinNamePerUserId( $user_id, $coin_name ) {
        $sql = "select sum(quantity) quantity from user_currency_details where currency_name='".$coin_name."' and user_id = '".$user_id."' group by currency_name";
        $data = \DB::select($sql);
        if ($data) return $data[0]->quantity;
        return 0;
    }
}
