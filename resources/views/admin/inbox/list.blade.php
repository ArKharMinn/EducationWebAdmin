@extends('admin.layouts.master');

@section('content')
    <div class="page-wrapper">


        <!-- PAGE CONTAINER-->
        <div class="page-container">

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">

                    <div class="container-fluid">
                        <div class="row bg-white col-10 offset-1">
                            <div class="col-3">
                                <div class="py-4">
                                    <h4 class="">Chats</h4>
                                    <div class="p-2 my-2">
                                        <form action="" method="GET">
                                            <input type="text" class="form-control" name="search"
                                                value="{{ request('search') }}" placeholder="Search..." />
                                        </form>
                                    </div>
                                </div>
                                @if (count($student) != 0)
                                    <div class="p-3">
                                        @foreach ($student as $s)
                                            <a href="{{ route('inbox#list', ['id' => $s->id]) }}" class="nav-link">
                                                <div
                                                    class="p-2 d-flex justify-start align-items-center @if (request('id') == $s->id) rounded bg-primary @endif">
                                                    @if ($s->image)
                                                        <img src="{{ asset('storage/' . $s->image) }}" style="width: 50px"
                                                            class="rounded-circle" />
                                                    @else
                                                        <img src="{{ asset('admin/images/profileMale.jpg') }}"
                                                            style="width: 50px" class="rounded-circle" />
                                                    @endif
                                                    <h5 class="mx-3 @if (request('id') == $s->id) text-white @endif">
                                                        {{ $s->name }}</h5>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <h3 class="text-centers my-5">There is no Student</h3>
                                @endif
                            </div>
                            <div class="col-6 p-3">
                                @if (request('id') != 0)
                                    <div class="border p-2 d-flex justify-content-between align-items-center">
                                        @foreach ($studentNavBar as $bar)
                                            <div class=" d-flex justify-start align-items-center">
                                                @if ($bar->image)
                                                    <img src="{{ asset('storage/' . $bar->image) }}" style="width: 50px"
                                                        class="rounded-circle" />
                                                @else
                                                    <img src="{{ asset('admin/images/profileMale.jpg') }}"
                                                        style="width: 50px" class="rounded-circle" />
                                                @endif
                                                <h5 class="mx-3">{{ $bar->name }}</h5>
                                            </div>
                                            <div class="mx-3">
                                                <h4 class="">
                                                    <i class="fa-solid fa-circle-info text-primary"></i>
                                                </h4>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-10 offset-1" style="height: calc(500px);overflow-y: auto;">
                                        @if (count($message) != 0 || count($adminMessage) != 0)
                                            <div class="mt-3">
                                                @if (Auth::user()->role == 'teacher')
                                                    @foreach ($message as $message)
                                                        @if ($message->teacher_id == Auth::user()->id && $message->to_userId == Auth::user()->teacher_id)
                                                            <div
                                                                class="d-flex my-2 justify-content-start align-items-center">
                                                                <p class="bg-secondary p-3 rounded text-white">
                                                                    {{ $message->message }}</p>
                                                            </div>
                                                        @else
                                                            <div class="d-flex my-2 justify-content-end align-items-center">
                                                                <a href="{{ route('inbox#delete', $message->id) }}"
                                                                    class="item " data-toggle="tooltip"
                                                                    data-placement="top" title="Delete">
                                                                    <i class="zmdi zmdi-delete text-danger me-3"></i>
                                                                </a>
                                                                <p class="bg-primary p-3 rounded text-white">
                                                                    {{ $message->message }}</p>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($adminMessage as $admin)
                                                        <div class="d-flex my-2 justify-content-end align-items-center">
                                                            <a href="{{ route('inbox#delete', $admin->id) }}"
                                                                class="item " data-toggle="tooltip" data-placement="top"
                                                                title="Delete">
                                                                <i class="zmdi zmdi-delete text-danger me-3"></i>
                                                            </a>
                                                            <p class="bg-primary p-3 rounded text-white">
                                                                {{ $admin->message }}</p>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="">
                                        <form action="{{ route('inbox#sendMessage') }}" method="POST">
                                            @csrf
                                            <div class="d-flex">
                                                <input type="hidden" value="{{ request('id') }}" name="studentId" />
                                                <textarea rows="4" name="message" class="form-control @error('message') is-invalid @enderror me-3"
                                                    placeholder="Enter Message"></textarea>
                                                <div class="">
                                                    <button type="submit" title="send"
                                                        class="btn p-3 btn-success rounded-circle">
                                                        <i class="fa-solid fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="col-3 p-3">
                                <div class=" text-center mt-4">
                                    @if (request('id'))
                                        <div class="">
                                            @foreach ($studentNavBar as $studentNavBar)
                                                @if ($studentNavBar->image)
                                                    <img src="{{ asset('storage/' . $studentNavBar->image) }}"
                                                        style="width: 100px" class="rounded-circle" />
                                                @else
                                                    <img src="{{ asset('admin/images/profileMale.jpg') }}"
                                                        style="width: 100px" class="rounded-circle" />
                                                @endif
                                                <h4 class="my-2">{{ $studentNavBar->name }}</h4>
                                                <p class="">{{ $studentNavBar->email }}</p>
                                                <div class="text-start p-3 border shadow-sm mt-5">
                                                    <p class="">Student ID : {{ $studentNavBar->student_id }}</p>
                                                    <p class="">Phone : {{ $studentNavBar->phone }}</p>
                                                    <p class="">Address : {{ $studentNavBar->address }}</p>
                                                    <p class="">Gender : {{ $studentNavBar->gender }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
