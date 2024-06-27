@extends('layout.main')
@section('content')
<div class="card p-3 mt-5">
    <h2>Forget Password</h2>
    <form action="{{route('forgetPassword.submit')}}" method="POST" id="forget_password_form">
        @csrf
        <div class="row">
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
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <span class="ms-1">
            Have an account <a href="{{ route('login') }}">Login</a> here
        </span>
    </form>
</div>
@endsection