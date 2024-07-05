@extends('layout.main')

@section('content')
<div class="form_banner" style="background-image:url({{asset('images/login/background.jpg')}});">
    <div class="form_wrapper reset_form">
        <div class="row box g-0">
            <div class="col-sm-6 d-none d-sm-block">
                <img src="{{asset('images/login/forget.jpg')}}" alt="students" class="equal_height left_img">
            </div>
            <div class="col-sm-6">
                <div class="form_inner equal_height">
                    <div class="logo text-center">
                        <img src="{{asset('images/logo.png')}}" alt="logo">
                    </div>
                    <h3>Reset Password</h3>
                    <form action="{{route('resetPassword.submit',$resetcode)}}" method="POST" id="reset_password_form">
                        @csrf
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
                                placeholder="Enter Email Address">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Enter Password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif

                            <label for="c_password" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="c_password"
                                placeholder="Enter Confirm Password">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif

                        <button type="submit" class="btn btn-primary submit">Reset Password</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
@endsection