@extends('admin.layouts.master');

@section('content')
    <div class="page-wrapper">


        <!-- PAGE CONTAINER-->
        <div class="page-container">

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-2 p-3 bg-white rounded">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('admin/images/students.png') }}" />
                                    </div>
                                    <div class="col-7 mt-2">
                                        <h5>Students</h5>
                                        <h3 class="mt-2">{{ count($student) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 mx-2 p-3 bg-white rounded shadow-sm">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('admin/images/teachers.png') }}" />
                                    </div>
                                    <div class="col-7 mt-2">
                                        <h5>Teachers</h5>
                                        <h3 class="mt-2">{{ count($teacher) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 p-3 bg-white rounded shadow-sm">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('admin/images/admin.png') }}" />
                                    </div>
                                    <div class="col-7 mt-2">
                                        <h5>Admins</h5>
                                        <h3 class="mt-2">{{ count($admin) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 ms-2 p-3 bg-white rounded shadow-sm">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('admin/images/course.jpg') }}" />
                                    </div>
                                    <div class="col-7 mt-2">
                                        <h5>Courses</h5>
                                        <h3 class="mt-2">{{ count($course) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 ms-2 p-3 bg-white rounded shadow-sm">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('admin/images/quizzes.png') }}" />
                                    </div>
                                    <div class="col-7 mt-2">
                                        <h5>Quizzes</h5>
                                        <h3 class="mt-2">{{ count($quiz) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-7">
                                <div class="my-3 row">
                                    <h4 class="col-11">New Students</h4>
                                    <a href="{{ route('student#list') }}" class="col-1 text-center mt-1">
                                        <h4 class=""><i class="fa-solid fa-ellipsis"></i></h4>
                                    </a>
                                </div>
                                <div class="table-responsive table-responsive-data2 rounded">
                                    @if (count($student) != 0)
                                        <table class="text-center table table-data2" id="myTable">
                                            <thead class="">
                                                <tr class="fw-bolder">
                                                    <th>PROFILE</th>
                                                    <th>STUDENT ID</th>
                                                    <th>NAME</th>
                                                    <th>EMAIL</th>
                                                    <th>SCORE</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($student as $c)
                                                    <tr class="tr-shadow studentParentDiv" id="deleteParentStudent">
                                                        <td class="col-1" id="">
                                                            @if ($c->image == null)
                                                                @if ($c->gender == 'female')
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('admin/images/profileFemale.jpg') }}" />
                                                                @else
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('admin/images/profileMale.jpg') }}" />
                                                                @endif
                                                            @else
                                                                <img class="rounded-circle"
                                                                    src="{{ asset('storage/' + $c->image) }}" />
                                                            @endif
                                                        </td>
                                                        <td id="studentId" class="desc d-none">{{ $c->id }}</td>
                                                        <td id="" class="desc">{{ $c->student_id }}</td>
                                                        <td>
                                                            <span class="block-email">{{ $c->name }}</span>
                                                        </td>
                                                        <td>{{ $c->email }}</td>
                                                        <td>{{ $c->score }}</td>
                                                        <td id="date">{{ $c->created_at->format('d-F-Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <h3 class="text-center text-danger m-5">There is no students</h3>
                                    @endif
                                </div>
                            </div>
                            <div class="listItem col-3 text-center">

                            </div>
                        </div>

                        @if (Auth::user()->role == 'admin')
                            <div class="row">
                                <div class="col-7">
                                    <div class="my-3 row">
                                        <h4 class="col-11">New Teachers</h4>
                                        <a href="{{ route('teacher#list') }}" class="col-1 text-center mt-1">
                                            <h4 class=""><i class="fa-solid fa-ellipsis"></i></h4>
                                        </a>
                                    </div>
                                    <div class="table-responsive table-responsive-data2 rounded">
                                        @if (count($teacher) != 0)
                                            <table class="text-center table table-data2" id="teacherList">
                                                <thead class="">
                                                    <tr class="fw-bolder">
                                                        <th>PROFILE</th>
                                                        <th>TEACHER ID</th>
                                                        <th>NAME</th>
                                                        <th>GENDER</th>
                                                        <th>EMAIL</th>
                                                        <th>DATE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($teacher as $t)
                                                        <tr class="tr-shadow teacherParentDiv" id="">
                                                            <td class="col-1">
                                                                @if ($t->image == null)
                                                                    @if ($t->gender == 'female')
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('admin/images/profileFemale.jpg') }}" />
                                                                    @else
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('admin/images/profileMale.jpg') }}" />
                                                                    @endif
                                                                @else
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('storage/' + $t->image) }}" />
                                                                @endif
                                                            </td>
                                                            <td id="teacherId" class="desc d-none">{{ $t->id }}</td>
                                                            <td id="" class="desc">{{ $t->teacher_id }}</td>
                                                            <td>
                                                                <span class="block-email">{{ $t->name }}</span>
                                                            </td>
                                                            <td>{{ $t->gender }}</td>
                                                            <td>{{ $t->email }}</td>
                                                            <td id="date">{{ $t->created_at->format('d-F-Y') }}</td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <h3 class="text-center text-danger m-5">There is no teachers</h3>
                                        @endif
                                    </div>
                                </div>
                                <div class="listItemTeacher col-3 text-center">

                                </div>
                            </div>
                        @endif
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
            $('#myTable tr').click(function() {
                $('#myTable tr').removeClass('table-dark');
                $(this).addClass('table-dark')
            })
            $('.studentParentDiv').click(function() {
                $id = $(this).find('#studentId').text()
                $date = $(this).find('#date').text()
                $.ajax({
                    type: 'get',
                    url: '{{ route('dashboard#student') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $list += `
                        <div class=" bg-white p-3 mt-5 " id="hideDiv">
                            <div class="text-end" id="hideX">
                                <i class="fa-solid fa-rectangle-xmark text-danger"></i>
                            </div>

                                <h5 class="my-3">Student ID : ${response[$i].student_id}</h5>
                                <img class="rounded-circle col-5" src="${response[$i].image ? response[$i].image : '{{ asset('admin/images/profileMale.jpg') }}'}"/>
                                <h4>${response[$i].name}</h4>
                                <div class="mx-2">Score : ${response[$i].score}</div>
                                <div>
                                    <div>
                                        <i class="fa-solid fa-phone me-2"></i> ${response[$i].phone}
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-envelope me-2"></i> ${response[$i].email}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div >
                                            Gender
                                        </div>
                                        <div class="">
                                            ${response[$i].gender}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div >
                                            Address
                                        </div>
                                        <div class="">
                                            ${response[$i].address}
                                        </div>
                                    </div>
                                </div>
                                <div class="mx-3">
                                    <h5>
                                        <i class="fa-solid fa-clock"></i>
                                        Joined Date : <span id="dateFormat"></span>
                                    </h5>
                                </div>
                            </div>

                        `
                        }
                        $('.listItem').html($list)
                        $('#dateFormat').text($date)
                        $('#hideDiv').click(function() {
                            $('#hideDiv').hide();
                            $('#myTable tr').removeClass('table-dark');
                        })
                    }
                })
            })


            //teacher
            $('#teacherList tr').click(function() {
                $('#teacherList tr').removeClass('table-dark');
                $(this).addClass('table-dark')
            })
            $('.teacherParentDiv').click(function() {
                $id = $(this).find('#teacherId').text()
                $date = $(this).find('#date').text()

                $.ajax({
                    type: 'get',
                    url: '{{ route('dashboard#teacher') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $list += `
                        <div class=" bg-white p-3 mt-5 " id="hideDiv">
                            <div class="text-end" id="hideX">
                                <i class="fa-solid fa-rectangle-xmark text-danger"></i>
                            </div>
                                <h5 class="mb-2">Teacher ID : ${response[$i].teacher_id}</h5>
                                <img class="rounded-circle my-3 col-5" src="{{ asset('admin/images/profileMale.jpg') }}"/>
                                <h4>${response[$i].name}</h4>
                                <div>
                                    <div class="my-2">
                                        <i class="fa-solid fa-phone me-2"></i> ${response[$i].phone}
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-envelope me-2"></i> ${response[$i].email}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <div >
                                            Gender
                                        </div>
                                        <div class="">
                                            ${response[$i].gender}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div >
                                            Address
                                        </div>
                                        <div class="">
                                            ${response[$i].address}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <h5>
                                        <i class="fa-solid fa-clock"></i>
                                        Joined Date <span id="dateFormat"></span></h5>
                                </div>
                            </div>

                        `
                        }
                        $('.listItemTeacher').html($list)
                        $('#dateFormat').text($date)
                        $('#hideX').click(function() {
                            $('#hideDiv').hide();
                            $('#teacherList tr').removeClass('table-dark');
                        })
                    }
                })
            })
        })
    </script>
@endsection
