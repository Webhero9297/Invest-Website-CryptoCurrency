<?php

namespace App\Http\Controllers;

use App\CoinAlert;
use App\Common;
use App\UserCurrencyDetails;
use Illuminate\Http\Request;
use App\User;

class MyProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        $default = '/public/assets/images/avatars/default.png';
        (is_null($user->user_avatar))? $img_avatar = $default : $img_avatar = $user->user_avatar;
        $full_name = $user->full_name;
        $email = $user->email;
        ($user->gender == 0) ? $gender = 'Male': $gender = 'Female';
        $age = $user->age*1;
        if ($age == 0) $age = 10;
        $country = $user->country;
        $isPrivate = $user->isPrivate;

        return view('frontend.profile')->with(['user_avatar'=>$img_avatar, 'full_name'=>$full_name, 'email'=>$email,
            'gender'=>$gender, 'age'=>$age, 'country'=>$country, 'isPrivate'=>$isPrivate]);
    }
    public function getLiveProfileCurrencyData() {
        $data = app(UserCurrencyDetails::class)->where('user_id', \Auth::user()->id)->get();
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
        $currency_data = array();
        foreach( $userCurrencyData as $coin ) {
            $coin_data = array();
            $coin_data = $coin;
            $coin_data['price_usd'] = number_format($coin['price_usd'], 2, '.',',');
            $coin_data['total_cost'] = number_format($coin['total_cost'], 2, '.',',');
            $coin_data['purchased_price'] = number_format($coin['purchased_price'], 2, '.',',');
            $coin_data['profit_loss'] = number_format($coin['profit_loss'], 2, '.',',');

            $investedCapital += $coin['total_cost']*1;
            $currentValue += $coin['price_usd']*$coin['quantity'];
            $totalProfitLossValue += $coin['profit_loss'];
            $profitlossPercentage += $coin['profit_loss_percentage'];
            $coin_ids[] = $coin['id'];
            $currency_data[] = $coin_data;
        }
        $arr['full_name'] = \Auth::user()->full_name;
        is_null(\Auth::user()->user_avatar) ? $arr['avatar'] = $default_avatar : $arr['avatar'] = \Auth::user()->user_avatar;
        $arr['invested_capital'] = number_format($investedCapital, 2, '.',',');
        $arr['current_value'] = number_format($currentValue, 2, '.',',');
        $arr['total_profit_loss'] = number_format($totalProfitLossValue, 2, '.',',');
        $arr['total_profit_loss_percentage'] = number_format($profitlossPercentage, 2, '.',',');
        $arr['coins'] = count($dd);
        return response()->json(['total'=>$arr, 'currency_data'=>$currency_data]);
    }
    public function editPriceAlertEditForm() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $crypto_arr = array();
        foreach( $cryptoData as $crypto ) {
            $crypto_arr[$crypto->name] = $crypto->id;
        }
        $currency_name='';
        $limit_price=0;
        $price_alert_datas = app(CoinAlert::class)->where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->get();
        if ( $price_alert_datas )
            $price_alert_datas = $price_alert_datas->toArray();
        else
            $price_alert_datas = [];
        return view('frontend.editpricealert')->with(['detail_id'=>'NULL', 'limit_price'=>$limit_price, 'currency_name'=>$currency_name,
            'cryptoData'=>$cryptoData, 'coin_arr'=>json_encode($crypto_arr), 'price_alert_datas'=>$price_alert_datas]);
    }
    public function savePriceAlertData() {
        $detail_id = request()->get('detail_id');
        $coin_id = request()->get('coin_id');
        $coin_name = request()->get('coin_name');
        $fiat = request()->get('fiat');
        $limit_price = request()->get('limit_price');

        if ( $detail_id == 'NULL' ) {
            $model = new CoinAlert();
        }
        else {
            $model = app(CoinAlert::class)->where('id', $detail_id)->first();
        }
        $model->user_id = \Auth::user()->id;
        $model->fiat = $fiat;
        $model->coin_id = $coin_id;
        $model->coin_name = $coin_name;
        $model->limit_price = $limit_price;
        $model->email_alert = request()->get('email_alert');
        $model->audio_alert = request()->get('audio_alert');
        $model->audio_sent_state = 0;
        $model->email_sent_state = 0;
        $model->email_sent_date = date('Y-m-d');
        $model->save();
        return redirect()->route('edit.price.alert');
    }
    public function deletePriceAlertData($id) {
        app(CoinAlert::class)->where('id', $id)->delete();
        return redirect()->route('edit.price.alert');
    }
    public function editProfileForm() {
        $user = \Auth::user();
        $full_name = $user->full_name;
        $email = $user->email;
        $gender = $user->gender;
        $age = $user->age*1;
        if ($age == 0) $age = 10;
        $country = $user->country;
        return view('frontend.editprofile')->with(['full_name'=>$full_name, 'email'=>$email, 'gender'=>$gender, 'age'=>$age, 'country'=>$country]);
    }
    public function saveProfileData() {
        $user = \Auth::user();
        $full_name = request()->get('full_name');
        $email = request()->get('email');
        $gender = request()->get('gender');
        $age = request()->get('age');
        $country = request()->get('country');

        $user->full_name = $full_name;
        $user->email = $email;
        $user->gender = $gender;
        $user->age = $age;
        $user->country = $country;
        $user->save();
        return redirect()->route('profile');
    }

    public function addCryptoCurrencyForm() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $currency_name='';
        $quantity=0;
        $purchased_price=0;
        $purchased_date=date('Y-m-d');
        return view('frontend.addcryptocurrencyex')->with(['detail_id'=>'NULL', 'currency_name'=>$currency_name, 'quantity'=>$quantity, 'purchased_price'=>$purchased_price, 'purchased_date'=>$purchased_date, 'cryptoData'=>$cryptoData]);
    }
    public function addCryptoCurrencyFormEx($currency_name) {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $quantity=0;
        $purchased_price=0;
        $purchased_date=date('Y-m-d');
        return view('frontend.addcryptocurrencyex')->with(['detail_id'=>'NULL', 'currency_name'=>$currency_name, 'quantity'=>$quantity, 'purchased_price'=>$purchased_price, 'purchased_date'=>$purchased_date, 'cryptoData'=>$cryptoData]);
    }
    public function addCryptoCurrencyData() {
        $currency_name = request()->get('currency_name');
        $quantity = request()->get('quantity');
        $purchased_price = request()->get('purchased_price');
        $purchased_date = request()->get('purchased_date');
        $detail_id = request()->get('detail_id');

        $user = \Auth::user();
        if ( $detail_id == 'NULL' ) {
            $model = new UserCurrencyDetails();
        }
        else{
            $model = app(UserCurrencyDetails::class)->where('detail_id', $detail_id)->first();
        }
        $model->user_id = $user->id;
        $model->currency_name = $currency_name;
        $model->quantity = $quantity;
        $model->purchased_price = $purchased_price;
        $model->purchased_date = $purchased_date;
        $model->total_cost = $purchased_price*$quantity;
        $model->save();


        return redirect()->route('profile');
    }
    public function editCryptoCurrencyForm($detail_id) {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $data = app(UserCurrencyDetails::class)->where('detail_id', $detail_id)->first();
        return view('frontend.addcryptocurrencyex')->with(['detail_id'=>$detail_id, 'currency_name'=>$data->currency_name, 'quantity'=>$data->quantity, 'purchased_price'=>$data->purchased_price, 'purchased_date'=>$data->purchased_date, 'cryptoData'=>$cryptoData]);
    }
    public function deleteCryptoCurrencyForm($detail_id) {
        $model = new UserCurrencyDetails();
        $model->where('detail_id', $detail_id)->delete();
        echo 'ok';
    }

    public function selectDefaultAvatarImageForm() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $currency_name='';
        $quantity=0;
        $purchased_price=0;
        $purchased_date=date('Y-m-d');
        $base_dir = base_path()."/public/assets/images/avatars/master avatars/";
        $default_avatars = array();
        if (is_dir($base_dir)){
            if ($dh = opendir($base_dir)){
                while (($file = readdir($dh)) !== false){
                    if ( $file == '.' || $file == '..' ) continue;
                    else{
                        $filePath = $base_dir.$file;
                        if ( exif_imagetype($filePath) >= 1 && exif_imagetype($filePath) ) $default_avatars[] = "./assets/images/avatars/master avatars/".$file;
                    }
                }
                closedir($dh);
            }
        }

        return view('frontend.selectdefaultavatar')->with(['default_avatars'=>$default_avatars]);
    }
    public function selectCustomAvatarImageForm() {
        $cryptoData = Common::getRealTimeCryptoCurrencyList();
        $currency_name='';
        $quantity=0;
        $purchased_price=0;
        $purchased_date=date('Y-m-d');
        $base_dir = base_path()."/public/assets/images/avatars/master avatars/";
        $default_avatars = array();
        if (is_dir($base_dir)){
            if ($dh = opendir($base_dir)){
                while (($file = readdir($dh)) !== false){
                    if ( $file == '.' || $file == '..' ) continue;
                    else{
                        $filePath = $base_dir.$file;
                        if ( exif_imagetype($filePath) >= 1 && exif_imagetype($filePath) ) $default_avatars[] = "./assets/images/avatars/master avatars/".$file;
                    }
                }
                closedir($dh);
            }
        }

        return view('frontend.selectcustomavatar')->with(['default_avatars'=>$default_avatars]);
    }
    public function changeUserAvatarWithDefaultAvatar() {
        $user = \Auth::user();
        $user->user_avatar = request()->get('default_avatar');
        $user->save();
        return redirect()->route('profile');
    }
    public function changeUserAvatarWithCustomAvatar(Request $request) {
        $user = \Auth::user();
        $asset_image_file = $request->file('custom_avatar');
        if ( $asset_image_file ) {
            $asset_image_filename = 'user_avatar_'.$user->id.'.'.$asset_image_file->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/avatars/user_avatars/');
            if (!file_exists($destinationPath)) {
                \File::makeDirectory($destinationPath, 0777, true);
            }
            $asset_image_file->move($destinationPath, $asset_image_filename);
            $user_avatar = '/assets/images/avatars/user_avatars/'.$asset_image_filename;
            $user->user_avatar = $user_avatar;
            $user->save();
        }
        return redirect()->route('profile');
    }
    public function changeProfileStatus($status) {
        $user = \Auth::user();
        $user->isPrivate = $status;
        $user->save();
        return 'ok';
    }

    public function getCoinAlertData() {
        $user_id = \Auth::user()->id;
        $coinAlertData = Common::getAlertCoinData($user_id);

        $serverLink = 'http://'.$_SERVER['HTTP_HOST'];
        $subject = "PRICE ALERT!";
        $to_email =\Auth::user()->email;
        $to_fullname = \Auth::user()->full_name;
        $from_email = "manager@moonfolio.io";
        $from_fullname = "Team Moonfolio";
        
        $headers = "From: ".$from_fullname."<".$from_email.">\r\n";
        $headers .= "Reply-To: ".$from_email."\r\n";
        $headers .= "Reply-Path: ".$from_email."\r\n";
        
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";

        $audio_alert_datas = array();
        foreach( $coinAlertData as $coin ) {
            if ( $coin['audio_alert'] == 1 && $coin['audio_sent_state'] == 0 ) {
                $audio_alert_datas[] = $coin;
                app(CoinAlert::class)->where('id', $coin['id'])->update(['audio_sent_state'=>1]);
            }
            if ( $coin['email_alert'] == 1 && $coin['email_sent_state'] == 0 ) {
                $message = "<div>Hi {$to_fullname},<br><br>
	                    <div>".$coin['coin_name']." has been fallen below $".$coin['limit_price']."<br></div><br>
	                    <div style=\"display:inline-flex;margin-top:-20px;\">
	                        <div>Team Moonfolio.</div><img src='{$serverLink}/assets/images/background/logo.png' height=\"32px\" style=\"margin-top: -5px;\">
	                    </div>
	                    <div>You are receiving this alert, because you have requested it in your Moonfolio settings.</div>";

                app(CoinAlert::class)->where('id', $coin['id'])->update(['email_sent_state'=>1, 'email_sent_date'=>date('Y-m-d')]);
                if ( $message != '' )
                    @mail($to_email, $subject, $message, $headers);
            }

        }



        return response()->json($audio_alert_datas);
    }

    public function closeThisAccount() {
        $user = \Auth::user();
        app(User::class)->where('id', $user->id)->delete();
        app(UserCurrencyDetails::class)->where('user_id', $user->id)->delete();
        app(CoinAlert::class)->where('user_id', $user->id)->delete();
        \Auth::guard()->logout();
        request()->session()->invalidate();
        return 'ok';
    }
}
