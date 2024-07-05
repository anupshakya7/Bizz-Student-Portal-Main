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
        <form action="{{ route('register.submit') }}" method="POST" id="registration_form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div id="image-preview-container">
                        <img id="image-preview" src="{{ asset('images/default.png') }}" alt="Image Preview"
                            style="display:block; border-radius:50%;margin:auto; width:120px; height:120px;object-fit: contain;">
                    </div>
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" id="profile_image"
                            accept="image/png, image/gif, image/jpeg" onchange="previewImage(event)">
                        @if ($errors->has('profile_image'))
                            <span class="text-danger">{{ $errors->first('profile_image') }}</span>
                        @endif
                    </div>
                </div>
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
                        <div class="cpi-input">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <div class="input-group border rounded">
                                <button class="btn btn-light dropdown-toggle d-flex align-items-center cpi-drop"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="me-1">🇳🇵</span>
                                </button>
                                <div class="dropdown-menu w-100">
                                    <button type="button" class="dropdown-item" data-cpi-icon="🇳🇵" data-cpi-ext="+977"
                                        data-cpi-min-length="10" data-cpi-max-length="10">
                                        🇳🇵 Nepal (+977)
                                    </button>
                                    <button type="button" class="dropdown-item" data-cpi-icon="🇬🇧" data-cpi-ext="+44"
                                        data-cpi-min-length="8" data-cpi-max-length="10">
                                        🇬🇧 United Kingdom (+44)
                                    </button>
                                </div>
                                <span class="input-group-text bg-white text-muted border-0 cpi-ext-txt">+977</span>
                                <input type="text" class="form-control border-0 phone-input flex-shrink-1"
                                    style="outline: none;" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                    pattern="[0-9]+" required minlength="10" maxlength="10">
                            </div>
                            <input type="hidden" name="country_code" class="country-code-input" value="+977">
                        </div>
                        @if ($errors->has('mobile'))
                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}"
                            placeholder="Enter Address">
                        @if ($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
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
                        <input type="checkbox" class="form-check-input" name="terms"
                            {{ old('terms') ? 'checked' : '' }} id="terms_condition">
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

        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            console.log(reader);

            reader.onload = function() {
                var imagePreview = document.getElementById('image-preview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#registration_form").validate({
                ignore: ".ignore",
                errorClass: "invalid",
                validClass: "success",
                rules: {
                    profile_image: {
                        required: true,
                        accept: 'image/*',
                        filesize: 2000000 //2MB
                    },
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
                    profile_image: {
                        required: "Please select an image",
                        accept: "Please select a valid image format (jpg, jpeg, png, gif)",
                        filesize: "File size must be less than 2MB"
                    },
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
