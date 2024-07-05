<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Twilio\Rest\Client;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'profile_image',
        'email',
        'country_code',
        'mobile',
        'mobile_otp_code',
        'otp_expired_at',
        'mobile_verified_at',
        'address',
        'password',
        'is_active',
        'email_verification_code',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendSMS($receivedNumber){
        $message = 'Your verification OTP is '.$this->mobile_otp_code;
        try{
            $account_id = getenv('TWILIO_SID');
            $auth_token = getenv('TWILIO_TOKEN');
            $twilio_number = getenv('TWILIO_FROM');

            $client = new Client($account_id,$auth_token);
            $client->messages->create($receivedNumber,[
                'from'=>$twilio_number,
                'body'=>$message
            ]);
            info("SMS Sent Successfully!!!");
        }catch(Exception $e){
            return redirect()->back()->with('error',"Error: ".$e->getMessage());
        }
    }
}
