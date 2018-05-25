<?php

namespace App\Http\Controllers;

use App\Common;
use App\User;
use App\UserVerifiedCurrencyDetails;
use Illuminate\Http\Request;

class WalletVerificationController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        $file = public_path('./js/frontend/erc20tokens.json');
        $token_info = json_decode(file_get_contents($file));
        $token_data = array();
        $coin_name_arr = array();

        foreach( $token_info->tokens as $token ) {
            $token_data[] = Common::stdToArray($token);
        }
//$datas = app(UserVerifiedCurrencyDetails::class)->where('user_id', \Auth::user()->id)->get()->toArray();
//dd($datas);
        $crypto_data = array('coin' => array('bitcoin'=>'Bitcoin', 'ethereum'=>'Ethereum'), 'erc20'=>$token_data);
        return view('frontend.verification')->with(['crypto_data'=>$crypto_data]);
    }
    public function addVerifiedCoin() {
        $currency_name = request()->get('currency_name');
        $quantity = request()->get('quantity');
        $price = request()->get('price');
        $wallet_address = request()->get('wallet_address');
        $wallet_value = request()->get('wallet_value');
        return view('frontend.addverifiedcoin')
            ->with(['currency_name'=>$currency_name, 'quantity'=>$quantity, 'price'=>$price, 'wallet_address'=>$wallet_address, 'purchased_date'=>date('Y-m-d'), 'detail_id'=>'NULL',
            'wallet_value'=>$wallet_value]);
    }
    public function saveVerifiedInfo() {
        $wallet_address = request()->get('wallet_address');
        $currency_name = request()->get('currency_name');
        $quantity = request()->get('quantity');
        $purchased_price = request()->get('purchased_price');
        $purchased_date = request()->get('purchased_date');
        $total_cost = request()->get('total_cost');
        $detail_id = request()->get('detail_id');

        $user_id = \Auth::user()->id;
        if ( $detail_id == 'NULL' ) {
            $tmp_record = app(UserVerifiedCurrencyDetails::class)->where('user_id', $user_id)->where('wallet_address', $wallet_address)->first();
            if ( $tmp_record ) $record = $tmp_record;
            else
                $record = new UserVerifiedCurrencyDetails();
        }
        else {
            $record = app(UserVerifiedCurrencyDetails::class)->where('detail_id', $detail_id)->first();
        }

        $record->currency_name = $currency_name;
        $record->user_id = $user_id;
        $record->wallet_address = $wallet_address;
        $record->quantity = $quantity;
        $record->purchased_price = $purchased_price;
        $record->purchased_date = $purchased_date;
        $record->total_cost = $total_cost;
        $record->save();
        return redirect()->route('wallet_verification');
    }
}
