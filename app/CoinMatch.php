<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinMatch extends Model
{
    //
    protected $table = 'coin_match';
    protected $primaryKey = 'match_id';


    public function getSoldCoinAmountPerUserId( $user_id, $coin_name ) {
        $sql = "SELECT SUM(quantity) quantity FROM coin_match WHERE coin_name='".$coin_name."' AND user_id = '".$user_id."' AND order_side=1 GROUP BY coin_name";
        $data = \DB::select($sql);
        if ($data) return $data[0]->quantity;
        return 0;
    }
}
