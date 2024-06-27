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

        #terms_condition {
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="card p-3 mt-5">
        <h2>Register</h2>
        <form action="{{ route('register.submit') }}" method="POST" id="registration_form">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" id="firstname"
                            value="{{ old('firstname') }}" placeholder="Enter First Name">
                        @if ($errors->has('firstname'))
                            <span class="text-danger">{{ $errors->first('firstname') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-control" id="lastname"
                            value="{{ old('lastname') }}" placeholder="Enter Last Name">
                        @if ($errors->has('lastname'))
                            <span class="text-danger">{{ $errors->first('lastname') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
                            placeholder="Enter Email Address">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Enter Password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="c_password" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="c_password"
                            placeholder="Enter Confirm Password">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="terms" {{ old('terms') ? 'checked' : '' }}
                            id="terms_condition">
                        <label class="form-check-label" for="terms_condition">Check our terms and
                            condition</label>
                    </div>
                    <div id="terms_error"></div>
                    @if ($errors->has('terms'))
                        <span class="text-danger">{{ $errors->first('terms') }}</span>
                    @endif
                </div>
                <div class="col-md-12 mb-3">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"
                        data-callback="recaptchaDataCallbackRegister"
                        data-expired-callback="recaptchaExpireCallbackRegister">
                    </div>
                    <input type="hidden" name="grecaptcha" id="hiddenRecaptchaRegister">
                    <div id="hiddenRecaptchaRegisterError"></div>
                    @if ($errors->has('grecaptcha'))
                        <span class="text-danger">{{ $errors->first('grecaptcha') }}</span>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
            <span class="ms-1">
                Already have an account <a href="{{ route('login') }}">Login</a> here
            </span>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function recaptchaDataCallbackRegister(response) {
            $("#hiddenRecaptchaRegister").val(response);
            $("#hiddenRecaptchaRegisterError").html("");
        }

        function recaptchaExpireCallbackRegister() {
            $("#hiddenRecaptchaRegister").val();
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#registration_form").validate({
                ignore: ".ignore",
                errorClass: "invalid",
                validClass: "success",
                rules: {
                    firstname: {
                        required: true,
                        minlenght: 2,
                        maxlength: 100,
                    },
                    lastname: {
                        required: true,
                        minlenght: 2,
                        maxlength: 100,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: baseUrl + "/auth/register/check_email_unique",
                            type: "post",
                            data: {
                                email: function() {
                                    return $('#email').val();
                                },
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                    },
                    password: {
                        required: true,
                        minlenght: 6,
                        maxlength: 100,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password",
                    },
                    terms: "required",
                    grecaptcha: "required",
                },
                messages: {
                    firstname: {
                        required: "Please Enter First Name",
                    },
                    lastname: {
                        required: "Please Enter Last Name",
                    },
                    email: {
                        required: "Please Enter Email Address",
                        email: "Your email address must be in the format of name@domain.com",
                        remote: "Email already is use. Try with different Email",
                    },
                    password: {
                        required: "Please Enter Password",
                    },
                    password_confirmation: {
                        required: "Need to Confirm Password",
                    },
                    terms: "Please accept our terms and conditions",
                    grecaptcha: "Captcha field is required",
                },
                errorPlacement: function(error, element) {
                    if (element.attr('name') == 'terms') {
                        error.appendTo($('#terms_error'));
                    } else if (element.attr('name') == 'grecaptcha') {
                        error.appendTo($('#hiddenRecaptchaRegisterError'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    $.LoadingOverlay("show");
                    form.submit();
                }
            });
        });
    </script>
@endsection
