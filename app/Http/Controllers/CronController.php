<?php

namespace App\Http\Controllers;

use App\Common;
use App\CronTickerV1;
use Illuminate\Http\Request;

class CronController extends Controller
{
    //
    public function dumpCMCData() {
        ini_set('max_execution_time', 3000);
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
        $real_data = json_decode($response);

        CronTickerV1::truncate();

        $table = new CronTickerV1();
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($table->getTable());
        foreach( $real_data as $data ) {
            $record = new CronTickerV1();
            $_data = Common::stdToArray($data);
            foreach( $columns as $column ) {
                if (isset($_data[$column])) {
                    $record->$column = $_data[$column];
                }
            }
            $record->save();
        }
        ini_set('max_execution_time', 30);
    }
}
