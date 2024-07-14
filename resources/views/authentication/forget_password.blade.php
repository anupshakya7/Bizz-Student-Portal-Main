@extends('layout.main')
@section('content')
<div class="form_banner" style="background-image:url({{asset('images/login/background.jpg')}});">
    <div class="form_wrapper forget_form">
        <div class="row box g-0">
            <div class="col-sm-6 d-none d-sm-block">
                <img src="{{asset('images/login/forget.jpg')}}" alt="students" class="equal_height left_img">
            </div>
            <div class="col-sm-6">
                <div class="form_inner equal_height">
                    <div class="logo text-center">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('images/logo-uk.png') }}" alt="logo" class="full_logo">
                        </a>
                    </div>
                    <h3>Forget Password</h3>
                    <form action="{{route('forgetPassword.submit')}}" method="POST" id="forget_password_form">
                        @csrf

                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
                            placeholder="Enter Email Address">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif

                        <button type="submit" class="btn btn-primary submit">Submit</button>
                        <p class="ms-1">
                            Have an account <a href="{{ route('login') }}">Login</a> here
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection