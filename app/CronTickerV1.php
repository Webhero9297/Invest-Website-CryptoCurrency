<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronTickerV1 extends Model
{
    //
    protected $table = 'cron_ticker_v1';
    public $timestamps = false;
    protected $casts = ['id' => 'string'];

    public function getCoinList() {
        return $this->orderBy('rank')->get();
    }
}
