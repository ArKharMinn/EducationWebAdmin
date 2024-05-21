@extends('layouts.master');

@section('content')
    <div class="login-form">
        <div class="text-center p-4">
            <h3>Sign in to CodeLab</h3>
        </div>

        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Enter Email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group my-3">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Enter Password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="au-btn au-btn--block mt-5 au-btn--blue m-b-20" type="submit">sign in</button>

        </form>
        <h5 class="text-center mb-2 text-muted">or</h5>
        <div class="">
            <a href="/auth/google/redirect" class="nav-link ">
                <button type="submit" class="btn btn-light rounded shadow-sm p-2">
                    <img class="col-1 me-3" src="{{ asset('admin/images/google_logo.png') }}" />Sign in with Google
                </button>
            </a>
        </div>

        <div class="register-link">
            <p>
                Don't you have account?
                <a href="{{ route('register') }}" class="nav-link d-inline">Sign Up Here</a>
            </p>
        </div>
    </div>
@endsection
