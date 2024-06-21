@extends('layout.main')
@section('content')
<div class="card p-3 mt-3">
    <h2>Register</h2>
    <form action="{{route('register.submit')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}">
            @if($errors->has('name'))
            <span class="text-danger">{{$errors->first('name')}}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" value="{{old('name')}}">
            @if($errors->has('email'))
            <span class="text-danger">{{$errors->first('email')}}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password">
            @if($errors->has('password'))
            <span class="text-danger">{{$errors->first('password')}}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="c_password" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="c_password">
            @if($errors->has('password_confirmation'))
            <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
            @endif
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="terms_condition">
            <label class="form-check-label" for="terms_condition" id="terms_condition">Check our terms and condition</label>
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <span class="ms-1">
            Already have an account <a href="{{route('login')}}">Sign In</a> here
        </span>
    </form>
</div>
@endsection