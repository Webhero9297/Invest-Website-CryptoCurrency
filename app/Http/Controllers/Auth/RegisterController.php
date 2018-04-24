<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterUser;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\PHPMailer;
use App\SMTP;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegisterUser;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $activation_code = substr(str_replace('/', '', Hash::make($data['email'])), -24);
//        dd($activation_code);
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_confirmation' => 0,
            'activation_code' => $activation_code,
        ]);
        return $user;
    }

    public function verificationForm($code) {
        $this->sendEmail($code);
        return view('frontend.verification')->with(['code'=>$code]);
    }
    public function verificationEmail() {
        $code = request()->get('code');
        $this->sendEmail($code);
        return view('frontend.verification')->with(['code'=>$code]);
    }
    private function sendEmail($code) {
        $user = app(User::class)->where('activation_code', $code)->first();
//        $serverLink = 'http://'.$_SERVER['HTTP_HOST'];
//        $subject = "Welcome to Moonfolio";
//        $to_email = $user->email;
//        $to_fullname = $user->full_name;
//        $from_email = "manager@moonfolio.io";
//        $from_fullname = "Welcome to Moonfolio";
//
//        $headers = "From: ".$from_fullname."<".$from_email.">\r\n";
//        $headers .= "Reply-To: ".$from_email."\r\n";
//        $headers .= "Reply-Path: ".$from_email."\r\n";
//
//        $headers .= "MIME-Version: 1.0\r\n";
//        $headers .= "Content-type: text/html; charset=utf-8\r\n";
//
//        $message = "<div>Hi {$to_fullname},<br><br>
//                    <div style='font-weight: bold;'>Please click on the link below to activate your Moonfolio account.</div><br>
//                    <div>
//                    <a href=\"{$serverLink}/verify-user/{$code}\" target='_blank'>Click Here.</a><br><br>
//                    Greetings,<br><br>
//                    Team Moonfolio.</div><br>
//                    <div style=\"display:inline-flex;margin-top:-20px;\">
//                        <div>Lets go to the moon!</div><img src='{$serverLink}/assets/images/background/logo.png' height=\"32px\" style=\"margin-top: -5px;\">
//                    </div>";
//
//        if (!@mail($to_email, $subject, $message, $headers)) {
//            print_r($message);
//        }
//        else {
//
//        }

        $serverLink = 'http://'.$_SERVER['HTTP_HOST'];
        $subject = "Welcome to Moonfolio";
        $to_email = $user->email;
        $to_fullname = $user->full_name;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "mail.moonfolio.io";
        $mail->Port = 25;
        //$mail->SMTPSecure = 'SSL';
        $mail->SMTPAuth = true;
        $mail->Username = "manager@moonfolio.io";
        $mail->Password = "Moonfolio1114!";
        $mail->IsSendmail(true);
        $mail->CharSet ="UTF-8";

        $mail->SetFrom("manager@moonfolio.io");
        $mail->FromName   = "Welcome to Moonfolio";
        $mail->AddReplyTo('manager@moonfolio.io');
        $mail->AddCC('manager@moonfolio.io');
        $mail->AddBCC('manager@moonfolio.io');

        $mail->AddAddress($to_email);
        $mail->Subject = $subject;
        $mail->IsHTML(true); //Or false if you do not want HTML content
        $mail->Body = "<div>Hi {$to_fullname},<br><br>
                    <div style='font-weight: bold;'>Please click on the link below to activate your Moonfolio account.</div><br>
                    <div>
                    <a href=\"{$serverLink}/verify-user/{$code}\" target='_blank'>Click Here.</a><br><br>
                    Greetings,<br><br>
                    Team Moonfolio.</div><br>
                    <div style=\"display:inline-flex;margin-top:-20px;\">
                        <div>Lets go to the moon!</div><img src='{$serverLink}/assets/images/background/black_logo.png' height=\"32px\" style=\"margin-top: -10px;\">
                    </div>";
//        $mail->AltBody = "No HTML Body. Great story goes here! 123123";

        if(!$mail->Send()){
//            echo "Error sending";
        } else {
//            echo "Mail successfully sent";
        }
    }
    /**
     * Activate the user with given activation code.
     * @param string $activationCode
     * @return string
     */
    public function activateUser(string $activationCode)
    {
        try {
            $user = app(User::class)->where('activation_code', $activationCode)->first();
            if (!$user) {
                return "The code does not exist for any user in our system.";
            }
            $user->email_confirmation  = 1;
            $user->activation_code = null;
            $user->save();
            auth()->login($user);
        } catch (\Exception $exception) {
            logger()->error($exception);
            return "Whoops! something went wrong.";
        }
        return redirect()->route('login');
    }
}
