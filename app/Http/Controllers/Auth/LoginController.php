<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthenticatesUser;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\PHPMailer;
use App\SMTP;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUser;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Activate the user with given activation code.
     * @param string $activationCode
     * @return string
     */
    public function loginUser($request)
    {
    	$email = $request->get('email');
        $user = app(User::class)->where('email', $email)->first();
        if ( $user ) {
        	if ( $user->email_confirmation == 0 ) {
	        	return 0;
	        }
	        else{
	        	return 1;
	        }
        }
        else {
          return 2;
        }
    }
    public function forgotPassForm() {
        return view('auth.forgotpass');
    }
    public function sendResetPassLink() {
        $email = request()->get('email');

        $user = app(User::class)->where('email', $email)->first();

        $serverLink = 'http://'.$_SERVER['HTTP_HOST'];
        $subject = "Change password";
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
        $mail->FromName   = "Team Moonfolio";
        $mail->AddReplyTo('manager@moonfolio.io');
        $mail->AddCC('manager@moonfolio.io');
        $mail->AddBCC('manager@moonfolio.io');

        $mail->AddAddress($to_email);
        $mail->Subject = $subject;
        $mail->IsHTML(true); //Or false if you do not want HTML content
        $mail->Body = "<div>Hi {$to_fullname},<br><br>
                    <div style='font-weight: bold;'>Please click on the link below to change your Moonfolio account password.</div><br>
                    <div>
                    <a href=\"{$serverLink}/resetpassform\" target='_blank'>Click Here.</a><br><br>
                    Greetings,<br><br>
                    Team Moonfolio.</div><br>
                    <div>Lets go to the moon!</div><br>
                    <img src='{$serverLink}/assets/images/background/black_logo.png' height=\"32px\" />";
//        $mail->AltBody = "No HTML Body. Great story goes here! 123123";

        if(!$mail->Send()){
//            echo "Error sending";
        } else {
//            echo "Mail successfully sent";
        }
        return view('auth.forgotpass')->with(['token'=>base64_encode('sent')]);
        //return redirect()->route('reset.pass');
    }

    public function resetResetPassInfo() {
        return view('auth.reset');
    }
    public function resetResetPassword() {
        $email = request()->get('email');
        $password = request()->get('password');

        $user = app(User::class)->where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();

        return redirect()->route('login');
    }
}
