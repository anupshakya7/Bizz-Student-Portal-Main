<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\EmailVerificationMail;
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

        if($body->success == true) {
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verification_code' => Str::random(40),
            ]);

            Mail::to($request->email)->send(new EmailVerificationMail($user));

            return redirect()->back()->with('success', 'Registration Successfully!!!. Please check your email address for email verification link');
        } else {
            return redirect()->back()->with('error', 'Invalid Recaptcha');
        }
    }

    public function checkEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function verifyEmail($verification_code){
        $user = User::where('email_verification_code',$verification_code)->first();
        if(!$user){
            return redirect()->route('register')->with('error','Invalid URL');
        }else{
            if($user->email_verified_at){
                return redirect()->route('register')->with('error','Email already Verified');
            }else{
                $user->update([
                    'email_verified_at'=>Carbon::now()
                ]);

                return redirect()->route('register')->with('success','Email Successfully Verified');
            }
        }
    }

    public function login()
    {
        return view('authentication.login');
    }

    public function loginSubmit(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|max:100',
            'grecaptcha'=>'required'
        ]);

        //Check Recaptcha
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

        if($body->success == true) {
            $user = User::where('email',$request->email)->first();
            if(!$user){
                return redirect()->back()->with('error','Email is not Registered');
            }else{
                if(!$user->email_verified_at){
                    return redirect()->back()->with('error','Email is not Verified');
                }else{
                    if(!$user->is_active){
                        return redirect()->back()->with('error','User is not active. Contact Admin');
                    }else{
                        $remember_me = ($request->remember_me)?true:false;
                        if(auth()->attempt($request->only('email','password'))){
                            return redirect()->route('dashboard')->with('success','Login Successfully!!!');
                        }else{
                            return redirect()->back('error','Invalid Credentials');
                        }
                    }
                }
            }
        }else{
            return redirect()->back()->with('error','Invalid Recaptcha');
        } 
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login')->with('success','Logout Successfully!!!');
    }
}
