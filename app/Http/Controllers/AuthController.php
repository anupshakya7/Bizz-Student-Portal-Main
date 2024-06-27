<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\EmailVerificationMail;
use App\Mail\ForgetPasswordMail;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register()
    {
        return view('authentication.register');
    }

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'firstname' => 'required|min:2|max:100',
            'lastname' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:100',
            'password_confirmation' => 'required|same:password',
            'terms' => 'required',
            'grecaptcha' => 'required'
        ]);

        $grecaptcha = $request->grecaptcha;

        $client = new Client();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' => [
                    'secret' => env('RECAPTCHA_SECRET_KEY'),
                    'response' => $grecaptcha
                ]
            ]
        );
        $body = json_decode((string) $response->getBody());

        if ($body->success == true) {
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verification_code' => Str::random(40),
            ]);

            Mail::to($request->email)->send(new EmailVerificationMail($user));

            return redirect()->route('login')->with('success', 'Registration Successfully!!!. Please check your email address for email verification link');
        } else {
            return redirect()->back()->with('error', 'Invalid Recaptcha');
        }
    }

    public function checkEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function verifyEmail($verification_code)
    {
        $user = User::where('email_verification_code', $verification_code)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid URL');
        } else {
            if ($user->email_verified_at) {
                return redirect()->route('login')->with('error', 'Email already Verified');
            } else {
                $user->update([
                    'email_verified_at' => Carbon::now()
                ]);

                return redirect()->route('login')->with('success', 'Email Successfully Verified');
            }
        }
    }

    public function login()
    {
        return view('authentication.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:100',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email is not Registered');
        } else {
            if (!$user->email_verified_at) {
                return redirect()->back()->with('error', 'Email is not Verified');
            } else {
                if (!$user->is_active) {
                    return redirect()->back()->with('error', 'User is not active. Contact Admin');
                } else {
                    $remember_me = ($request->remember_me) ? true : false;
                    if (auth()->attempt($request->only('email', 'password'))) {
                        return redirect()->route('dashboard')->with('success', 'Login Successfully!!!');
                    } else {
                        return redirect()->back()->with('error', 'Invalid Credentials');
                    }
                }
            }
        }
    }

    public function forgetPassword(){
        return view('authentication.forget_password');
    }

    public function forgetPasswordSubmit(Request $request){
        $request->validate([
            'email'=>'required|email'
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user){
            return redirect()->back()->with('error','User not Found.');
        }else{
            $reset_code = Str::random(200);
            PasswordReset::create([
                'user_id'=>$user->id,
                'reset_code'=> $reset_code
            ]);

            Mail::to($user->email)->send(new ForgetPasswordMail($user->firstname,$reset_code));
            return redirect()->back()->with('success','We have sent you a password reset link. Please check your email.');
        }
    }
    
    public function resetPassword($resetcode){
        $passwordResetCode = PasswordReset::where('reset_code',$resetcode)->first();
        if(!$passwordResetCode || Carbon::now()->subMinutes(10) > $passwordResetCode->created_at){
            return redirect()->route('forgetPassword')->with('error','Invalid password reset link or link expired.');
        }else{
            return view('authentication.reset_password',compact('resetcode'));
        }
    }

    public function resetPasswordSubmit(Request $request,$resetcode){
        $passwordResetData = PasswordReset::where('reset_code',$resetcode)->first();

        if(!$passwordResetData || Carbon::now()->subMinutes(10) > $passwordResetData->created_at){
            return redirect()->route('forgetPassword')->with('error','Invalid password reset link or link expired.');
        }else{
            $request->validate([
                'email'=>'required|email',
                'password'=>'required|min:6|max:100',
                'password_confirmation'=>'required|same:password'
            ]);

            $user = User::find($passwordResetData->user_id);

            if($user->email != $request->email){
                return redirect()->back()->with('error','Enter correct Email.');
            }else{
                $passwordResetData->delete();
                $user->update([
                    'password'=>bcrypt($request->password)
                ]);

                return redirect()->route('login')->with('success','Password Successfully Reset!!!');
            }
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logout Successfully!!!');
    }
}
