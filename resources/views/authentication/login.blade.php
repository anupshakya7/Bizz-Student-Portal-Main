@extends('layout.main')
@section('content')
<div class="card p-3 mt-3">
    <h2>Login</h2>
    <form action="{{route('login.submit')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}">
            @if($errors->has('email'))
            <span class="text-danger">{{$errors->first('email')}}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}">
            @if($errors->has('password'))
            <span class="text-danger">{{$errors->first('password')}}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection