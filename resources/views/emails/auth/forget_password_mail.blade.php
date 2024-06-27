@component('mail::message')
Hello {{$username}}

@component('mail::button', ['url' => route('resetPassword',$resetcode)])
Click here to reset your password
@endcomponent
<p>Or copy & paste the following link to your browser</p>
<p><a href="{{route('resetPassword',$resetcode)}}">{{route('resetPassword',$resetcode)}}</a></p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
