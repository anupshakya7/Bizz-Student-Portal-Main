@component('mail::message')
Dear {{$user->user['given_name']}},

<p>We have generated a new password for your account. Please find it below:</p>

<p><b>New Password:</b> 123456</p>
<p>[Click Here For Login] <a href="{{route('login')}}">{{route('login')}}</a></p>

<p>For security reasons, we strongly recommend that you change this password immediately after logging in.</p>
<p>If you encounter any issues or need further assistance, please do not hesitate to contact our support team.</p>
{{ config('app.name') }}
@endcomponent
