@extends('layouts.master');

@section('content')
    <div class="">
        <div id="hideDiv" style="display: {{ session('hidden') ? 'none' : 'block' }}"
            class="p-4 m-5 rounded position-absolute shadow-lg z-3 bg-white">
            <a href="{{ route('login') }}">
                <button type="submit" class="btn btn-dark">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back
                </button>
            </a>
            <div class="my-4">
                <h4>Confirmation</h4>
            </div>
            <input type="password" id="code" class="form-control" placeholder="Enter Code" />
            <small class="text-danger" id="vali"></small>
            <div class="mt-3 float-end">
                <button type="submit" class="btn btn-success goBtn">Go</button>
            </div>
        </div>

        <div class="login-form">
            <h3 class="mb-3 text-center">Register</h3>
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label class="mb-1">Username</label>
                    <input class="form-control" value="{{ old('name') }}" type="text" name="name"
                        placeholder="Username">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group my-3">
                    <label class="mb-1">Email</label>
                    <input class="form-control" value="{{ old('email') }}" type="email" name="email"
                        placeholder="Email">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="mb-1">Phone</label>
                    <input class="form-control" value="{{ old('phone') }}" type="number" name="phone"
                        placeholder="09.......">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group my-3">
                    <label class="mb-1">Address</label>
                    <input class="form-control" value="{{ old('address') }}" type="text" name="address"
                        placeholder="Address">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="">
                        <label class="mb-1">Gender</label>
                        <input type="radio" value="male" class="" name="gender" />Male
                        <input type="radio" value="female" class="ms-2" name="gender" />Female
                    </div>
                    @error('gender')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group my-3">
                    <label class="mb-1">Password</label>
                    <input class="form-control" value="{{ old('password') }}" type="password" name="password"
                        placeholder="Password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="mb-1">Confirm Password</label>
                    <input class="form-control" value="{{ old('password_confirmation') }}" type="password"
                        name="password_confirmation" placeholder="Confirm Password">
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="au-btn au-btn--block mt-4 au-btn--green " type="submit">register</button>

            </form>
            <p class="text-center mb-2">or</p>
            <div class="">
                <a href="/auth/google/redirect" class="nav-link ">
                    <button type="submit" class="btn btn-light rounded shadow-sm p-2">
                        <img class="col-1 me-3" src="{{ asset('admin/images/google_logo.png') }}" />Sign in with Google
                    </button>
                </a>
            </div>
            <div class="register-link">
                <p>
                    Already have account?
                    <a href="{{ route('login') }}" class="nav-link d-inline">Sign In</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $hide = localStorage.getItem('hidden')
            if ($hide) {
                $('#hideDiv').hide()
            }
            $('.goBtn').click(function() {
                $parentNode = $(this).parents('div')
                $code = $parentNode.find('#code').val()
                if (!$code) {
                    $('#vali').text('Code must be fill')
                }
                if ($code == 111111) {
                    $('#hideDiv').hide()
                    localStorage.setItem('hidden', true)
                }
                if ($code != 111111) {
                    window.location.href = "http://localhost:8000/login"
                }
            })
        })
    </script>
@endsection
