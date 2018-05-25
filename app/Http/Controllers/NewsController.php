<?php

namespace App\Http\Controllers;

use App\Common;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    public function index(){
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
        return view('frontend.news')->with(['news_data'=>$news_data]);
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
        return response()->json(['news_data'=>$news_data]);
    }
}
