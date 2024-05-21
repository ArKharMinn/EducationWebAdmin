@extends('admin.layouts.master');

@section('content')
    <div class="page-wrapper">
        <div class="page-container">
            <div class="main-content">
                <a href="{{ route('setting#manage') }}" class="ms-5">
                    <button type="submit" class="btn btn-dark rounded mb-3">
                        <i class="fa-solid fa-chevron-left me-2"></i> Back
                    </button>
                </a>
                <div class="section__content section__content--p30 position-relative">
                    <div class="container-fluid p-4 bg-white col-10 offset-1">

                        <div class="">
                            <div class="row mb-3">
                                <h3 class="col-12">Edit Profile</h3>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <form action="{{ route('setting#updateProfile') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="mt-4 col-4">
                                                @if (Auth::user()->image)
                                                    <img id="previewImage" src="{{ asset('storage/' . Auth::user()->image) }}"
                                                        class="rounded" />
                                                @else
                                                    <img id="previewImage" src="{{ asset('admin/images/profileMale.jpg') }}"
                                                        class="rounded" />
                                                @endif
                                            </div>
                                            <div class="col mt-4 ms-3 ">
                                                <label for="changePp">
                                                    <div class="rounded border p-2 d-inline-block">
                                                        <i class="fa-solid fa-camera "></i> Change Avatar
                                                    </div>
                                                </label>
                                                <input type="file" name="image" id="changePp" class="d-none" />
                                                <a href="{{ route('setting#deletepp', Auth::user()->id) }}"
                                                    class="d-block ms-2 mt-2 nav-link">
                                                    <h5 class="text-danger ">Delete Profile</h5>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="p-2 mt-3">
                                            <div class="mt-3 ms-3">
                                                <div class="">
                                                    <label for="" class="">Full Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ Auth::user()->name }}" />
                                                </div>
                                                <div class=" my-2">
                                                    <label for="" class="">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ Auth::user()->email }}" />
                                                </div>
                                                <div class="">
                                                    <label for="" class="">Phone</label>
                                                    <input type="number" name="phone" class="form-control"
                                                        value="{{ Auth::user()->phone }}" />
                                                </div>
                                                <div class="my-2">
                                                    <label for="" class="">Address</label>
                                                    <input type="text" name="address" class="form-control"
                                                        value="{{ Auth::user()->address }}" />
                                                </div>
                                                <div class="mb-2">
                                                    @if (Auth::user()->gender == 'female')
                                                        <input type="radio" value="male" name="gender" /> Male
                                                        <input type="radio" class="ms-2" value="female" name="gender"
                                                            checked /> Female
                                                    @else
                                                        <input type="radio" value="male" name="gender" checked /> Male
                                                        <input type="radio" class="ms-2" value="female"
                                                            name="gender" /> Female
                                                    @endif
                                                </div>
                                                <div class="my-2">
                                                    <button type="submit" class="btn btn-dark btn-block">Save
                                                        Changes</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>

                                @if (Auth::user()->password != null || Auth::user()->password != '')
                                    <div class="col-6">
                                        <h3 class="mb-5">
                                            Change Password
                                        </h3>
                                        @if (session('change'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Password is successfully changed</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <div class="my-3">
                                            <form action="{{ route('setting#change') }}" method="POST">
                                                @csrf
                                                <div class="">
                                                    <label for="">Old Password</label>
                                                    <input type="password" name="oldPassword"
                                                        class="form-control @error('oldPassword') is-invalid @enderror" />
                                                    @error('oldPassword')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    @if (session('status'))
                                                        <small class="text-danger">The credential do not match</small>
                                                    @endif
                                                </div>
                                                <div class="my-2">
                                                    <label for="">New Password</label>
                                                    <input type="password" name="newPassword"
                                                        class="form-control @error('newPassword') is-invalid @enderror" />
                                                    @error('newPassword')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="">
                                                    <label for="">Confirm Password</label>
                                                    <input type="password" name="confirmPassword"
                                                        class="form-control @error('confirmPassword') is-invalid @enderror" />
                                                    @error('confirmPassword')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="mt-4">
                                                    <button type="submit" class="btn rounded btn-block btn-success">Set
                                                        New Password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#changePp').on('change', function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.onload = function(event) {
                    $('#previewImage').attr('src', event.target.result);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
