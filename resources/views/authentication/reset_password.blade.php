@extends('layout.main')
@section('content')
<div class="card p-3 mt-5">
    <h2>Reset Password</h2>
    <form action="{{route('resetPassword.submit',$resetcode)}}" method="POST" id="reset_password_form">
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
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="Enter Password">
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="c_password" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="c_password"
                        placeholder="Enter Confirm Password">
                    @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
@endsection