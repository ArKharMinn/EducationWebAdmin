@extends('admin.layouts.master');

@section('content')
    <div class="page-wrapper">
        <div class="page-container">
            <div class="main-content">
                <div class="section__content section__content--p30 position-relative">
                    <div class="container-fluid p-4 bg-white col-8 offset-2">
                        <div class="">
                            <div class="row mb-3">
                                <h3 class="col-10">My Profile</h3>
                                <div class="col-2">
                                    <a href="{{ route('setting#editProfile') }}">
                                        <button class="btn btn-outline-dark rounded">Edit
                                            <i class="fa-solid fa-user-pen ms-2"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            @if (session('editProfile'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Profile successfully updated</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="row rounded p-2 border shadow-sm">
                                <div class="col-2">
                                    @if (Auth::user()->image)
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded-circle " />
                                    @else
                                        <img src="{{ asset('admin/images/profileMale.jpg') }}" class="rounded-circle" />
                                    @endif
                                </div>
                                <div class="col mt-3 ms-3">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p class="mt-2">ID : {{ Auth::user()->admin_id }}</p>
                                    <p>{{ Auth::user()->address }}</p>
                                </div>
                            </div>
                            <div class="rounded p-2 mt-3 border shadow-sm">
                                <div class="">
                                    <h4>Personal Infomation</h4>
                                </div>
                                <div class="mt-3 ms-3">
                                    <div class="">
                                        <p>Name</p>
                                        <h4>{{ Auth::user()->name }}</h4>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-6">
                                            <p class="">Email</p>
                                            <h4>{{ Auth::user()->email }}</h4>
                                        </div>
                                        <div class="col-6">
                                            <p class="">Phone</p>
                                            <h4>{{ Auth::user()->phone }}</h4>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <p class="">Address</p>
                                            <h4>{{ Auth::user()->address }}</h4>
                                        </div>
                                        <div class="col-6">
                                            <p class="">Gender</p>
                                            <h4>{{ Auth::user()->gender }}</h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-2 deleteParentDiv">
                                <h4 class="text-danger p-2 text-end deleteAcc">Delete Account</h4>
                                <div class="text-end me-3 d-none " id="deleteBtn">
                                    <input type="hidden" id="userId" value="{{ Auth::user()->id }}" />
                                    <button class="btn btn-danger rounded me-3" id="yesBtn">Yes</button>
                                    <button class="btn btn-dark rounded" id="noBtn">No</button>
                                </div>
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
            $('.deleteAcc').click(function() {
                $('#deleteBtn').removeClass('d-none')
            })
            $('#noBtn').click(function() {
                $('#deleteBtn').addClass('d-none')
            })
            $('#yesBtn').click(function() {
                $parentNode = $(this).parents('.deleteParentDiv');
                $id = $parentNode.find('#userId').val();

                $.ajax({
                    type: 'get',
                    url: '{{ route('setting#deleteAcc') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '/';
                    }
                })
            })
        })
    </script>
@endsection
