@extends('admin.layouts.master');

@section('content')
    <div class="page-wrapper">


        <!-- PAGE CONTAINER-->
        <div class="page-container">

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid col-8 offset-2">
                        <div class="py-2 bg-white px-4 ">
                            <div class=" rounded shadow-sm border p-3 d-flex justify-content-start align-items-center">
                                <img src="{{ asset('admin/images/CODELAB logo.jpg') }}" class="col-1 rounded-circle" />
                                <h3 class="">Group Chat</h3>
                            </div>
                        </div>
                        <div class=" bg-white ">
                            <div class="" style="height: calc(500px);overflow-y: auto;">
                                @if (count($message) != 0)
                                    <div class="mt-3 col-10 offset-1">
                                        @foreach ($message as $message)
                                            @if ($message->user_id != Auth::user()->id || $message->user_name != Auth::user()->name)
                                                <p class="d-flex my-2 justify-content-start align-items-center">
                                                    {{ $message->user_name }}</p>
                                                <div class="d-flex my-2 justify-content-start align-items-center">
                                                    <p class="bg-secondary p-3 rounded text-white">
                                                        {{ $message->message }}</p>
                                                </div>
                                            @elseif ($message->user_id == Auth::user()->id && $message->user_name == Auth::user()->name)
                                                <p class="d-flex my-2 justify-content-end align-items-center">
                                                    {{ $message->user_name }}</p>
                                                <div class="d-flex my-2 justify-content-end align-items-center">
                                                    <a href="{{ route('groupChat#delete', $message->id) }}" class="item "
                                                        data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete text-danger me-3"></i>
                                                    </a>
                                                    <p class="bg-primary p-3 rounded text-white">
                                                        {{ $message->message }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="bg-white p-3">
                            <form action="{{ route('groupChat#send') }}" method="POST">
                                @csrf
                                <div class="d-flex">
                                    <input type="hidden" name="id" value="{{ Auth::user()->id }}" />
                                    <textarea rows="4" name="message" class="form-control @error('message') is-invalid @enderror me-3"
                                        placeholder="Enter Message"></textarea>
                                    <div class="">
                                        <button type="submit" title="send" class="btn p-3 btn-success rounded-circle">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
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

@section('scriptSource')
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
