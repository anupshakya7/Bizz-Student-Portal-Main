@extends('layout.main')
@section('style')
    <style>
        label.invalid {
            color: red;
            font-size: 14px;
        }

        input.invalid {
            border: 2px solid red;
        }

        input.success {
            border: 2px solid green;
        }

        #remember_me {
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="card p-3 mt-3">
        <h2>Login</h2>
        <form action="{{ route('login.submit') }}" method="POST" id="login_form">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember_me"
                        {{ old('remember_me') ? 'checked' : '' }} value="true" id="remember_me">
                    <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>
                <div id="remember_me_error"></div>
                @if ($errors->has('terms'))
                    <span class="text-danger">{{ $errors->first('terms') }}</span>
                @endif
            </div>
            <div class="col-md-12 mb-3">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"
                    data-callback="recaptchaDataCallbackLogin" data-expired-callback="recaptchaExpireCallbackLogin">
                </div>
                <input type="hidden" name="grecaptcha" id="hiddenRecaptchaLogin">
                <div id="hiddenRecaptchaLoginError"></div>
                @if ($errors->has('grecaptcha'))
                    <span class="text-danger">{{ $errors->first('grecaptcha') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <span class="ms-1">
                Don't have an account <a href="{{ route('register') }}">Sign Up</a> here
            </span>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function recaptchaDataCallbackLogin(response) {
            $('#hiddenRecaptchaLogin').val(response);
            $('#hiddenRecaptchaLoginError').html('');
        }

        function recaptchaExpireCallbackLogin() {
            $('#hiddenRecaptchaLogin').val('');
        }
    </script>
    <script>
        // $(document).ready(function(){
        //     $('#login_form').validate({
        //         ignore: ".ignore",
        //         errorClass:"invalid",
        //         validClass:"success",
        //         rules:{
        //             email: {
        //                 required: true,
        //                 email: true,
        //             },
        //             password: {
        //                 required: true,
        //                 minlenght: 6,
        //                 maxlength: 100,
        //             },
        //             grecaptcha: "required",
        //         },
        //         messages:{
        //             email: {
        //                 required: "Please Enter Email Address",
        //                 email: "Your email address must be in the format of name@domain.com"
        //             },
        //             password: {
        //                 required: "Please Enter Password",
        //             },
        //             grecaptcha: "Captcha field is required",
        //         },
        //         errorPlacement:function(error,element){
        //             if(element.attr('name')=="grecaptcha"){
        //                 error.appendTo($('#hiddenRecaptchaLoginError'));
        //             }else{
        //                 error.insertAfter(element);
        //             }
        //         },
        //         submitHandler:function(form){
        //             $.LoadingOverlay("show");
        //             form.submit();
        //         }

        //     })
        // });
    </script>
@endsection
