@extends('admin.layouts.master');

@section('content')
  <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <a href="{{ route('teacher#list') }}">
                    <button type="submit" class="btn btn-dark">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back
                    </button>
                </a>
                <div class="container-fluid mt-3 row">
                    <div class="login-form col-4 offset-4 p-3 bg-white">
                        <form action="{{ route('teacher#create') }}" method="post">
                            @csrf
                            @error('terms')
                              <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="form-group">
                                <label class="mb-2">Username</label>
                                <input class="form-control" value="{{ old('name') }}" type="text" name="name" placeholder="Username">
                                @error('name')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group my-3">
                                <label class="mb-2">Email</label>
                                <input class="form-control" value="{{ old('email') }}" type="email" name="email" placeholder="Email">
                                @error('email')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-2">Phone</label>
                                <input class="form-control" value="{{ old('phone') }}" type="number" name="phone" placeholder="09.......">
                                @error('phone')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group my-3">
                                <label class="mb-2">Address</label>
                                <input class="form-control" value="{{ old('address') }}" type="text" name="address" placeholder="Address">
                                @error('address')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <label class="mb-2">Gender</label>
                                    <input type="radio" value="male" class="" name="gender"/>Male
                                    <input type="radio" value="female" class="ms-2" name="gender"/>Female
                                </div>
                                @error('gender')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group my-3">
                                <label class="mb-2">Password</label>
                                <input class="form-control" value="{{ old('password') }}" type="password" name="password" placeholder="Password">
                                @error('password')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-2">Confirm Password</label>
                                <input class="form-control" value="{{ old('password_confirmation') }}" type="password" name="password_confirmation" placeholder="Confirm Password">
                                @error('password_confirmation')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button class="au-btn au-btn--block mt-3 au-btn--green" type="submit">
                                <i class="fa-solid fa-user-plus"></i> Add Teacher
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
@endsection

@section('scripts')
 <script>
    $(document).ready(function(){

    })
 </script>
@endsection
