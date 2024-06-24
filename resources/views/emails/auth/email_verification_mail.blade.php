@component('mail::message')

Hello {{$user->firstname}}
@component('mail::button', ['url' => route('register.verifyEmail',$user->email_verification_code)])
Click here to verify your email address
@endcomponent

<p>Or copy paste the following link on your web browser to verify your email address</p>

<p><a href="{{route('register.verifyEmail',$user->email_verification_code)}}">
    {{route('register.verifyEmail',$user->email_verification_code)}}    
</a></p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
