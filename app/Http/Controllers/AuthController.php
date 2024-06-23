<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

            return redirect()->back()->with('success', 'Registration Successfully!!!');
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



    public function login()
    {
        return view('authentication.login');
    }
}
