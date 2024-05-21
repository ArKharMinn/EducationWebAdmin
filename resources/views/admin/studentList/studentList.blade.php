@extends('admin.layouts.master');

@section('content')
    <div class="page-wrapper">


        <!-- PAGE CONTAINER-->
        <div class="page-container">

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="col-10 mb-4 bg-white p-3">
                            <h4 class="mb-3">Top 3 Students</h4>
                            @if (count($student) != 0)
                                <div class="table-responsive table-responsive-data2">
                                    <table class="text-center table table-data2" id="">
                                        <thead class="">
                                            <tr class="fw-bolder">
                                                <th>SCORE</th>
                                                <th>PROFILE</th>
                                                <th>NAME</th>
                                                <th>STUDENT ID</th>
                                                <th>GENDER</th>
                                                <th>EMAIL</th>
                                                <th>ADDRESS</th>
                                                <th>DATE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span id="" class="row">
                                                @foreach ($score as $s)
                                                    <tr class="tr-shadow" id="">
                                                        <td class="block-email">
                                                            <i
                                                                class="fa-solid fa-crown me-2 text-warning"></i>{{ $s->score }}
                                                        </td>
                                                        <td class="col-1">
                                                            @if ($s->image == null)
                                                                <img class="rounded-circle"
                                                                    src="{{ asset('admin/images/profileMale.jpg') }}">
                                                            @else
                                                                <img class="rounded-circle"
                                                                    src="{{ asset('storage/' . $s->image) }}">
                                                            @endif
                                                        </td>
                                                        <td class="desc">{{ $s->name }}</td>
                                                        <td class="desc">{{ $s->student_id }}</td>
                                                        <td class="desc">{{ $s->gender }}</td>
                                                        <td class="desc">{{ $s->email }}</td>
                                                        <td class="desc">{{ $s->address }}</td>
                                                        <td>
                                                            {{ $s->created_at->format('d-F-Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </span>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h3 class="text-center text-secondary mt-5">There is no student</h3>
                            @endif

                            <div class="mt-5">
                                {{ $student->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 rounded bg-white p-3">
                                <h4 class="">Students</h4>
                                <div class="p-2 my-2">
                                    <form action="" method="GET">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request('search') }}" placeholder="Search for students" />
                                    </form>
                                </div>
                                @if (count($student) != 0)
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="text-center table table-data2" id="myTable">
                                            <thead class="">
                                                <tr class="fw-bolder">
                                                    <th>PROFILE</th>
                                                    <th>NAME</th>
                                                    <th>STUDENT ID</th>
                                                    <th>DATE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span id="" class="row">
                                                    @foreach ($student as $s)
                                                        <tr class="tr-shadow myList" id="myListStudent">
                                                            <td class="col-2">
                                                                @if ($s->image == null)
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('admin/images/profileMale.jpg') }}">
                                                                @else
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('storage/' . $s->image) }}">
                                                                @endif
                                                            </td>
                                                            <td class="desc">{{ $s->name }}</td>
                                                            <td id="studentId" class="desc d-none">{{ $s->id }}</td>
                                                            <td id="" class="desc">{{ $s->student_id }}</td>
                                                            <td class="desc dateFormat">
                                                                {{ $s->created_at->format('d-F-Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </span>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h3 class="text-center text-secondary mt-5">There is no student</h3>
                                @endif

                                <div class="mt-5">
                                    {{ $student->links('pagination::bootstrap-5') }}
                                </div>
                            </div>

                            <div class="col-7 studentDetail">

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
            $('#myTable tr').click(function() {
                $('#myTable tr').removeClass('table-dark');
                $(this).addClass('table-dark')
            })
            $('.myList').click(function() {
                $id = $(this).find('#studentId').text();
                $date = $(this).find('.dateFormat').text();

                $.ajax({
                    type: 'get',
                    url: '{{ route('student#detail') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $list += `
                        <div class="rounded bg-white shadow-sm mt-5 " id="hideDiv">
                            <div class="bg-dark text-white p-3 rounded">
                                <h4 class="text-end" id="hideX">
                                 <i class="fa-solid fa-rectangle-xmark text-danger"></i>
                                </h4>
                                <div class="row">
                                    <div class="col-3">
                                        <img id="profile" class="rounded-circle" src=""/>
                                    </div>
                                    <div class="col-9 d-flex align-items-center">
                                        <div>
                                            <h4 class="text-white">${response[$i].name}</h4>
                                            <p class="text-white">Student ID : ${response[$i].student_id}</p>
                                            <h4 class="text-white mt-2">Score : ${response[$i].score}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="p-3">
                                    <div class="border rounded p-3">
                                        <div class="row">
                                            <h3 class="col-8">Basic Details</h3>
                                            <div class="table-data-feature col-4">
                                              <button class="item deleteBtnStudent" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                                <div class="d-none" id="idStudent">${response[$i].id}</div>
                                              </button>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                         <div class="col">
                                            <h5>Gender</h5> ${response[$i].gender}
                                         </div>
                                         <div class="col">
                                            <h5>Address</h5> ${response[$i].address}
                                         </div>
                                         <div class="col">
                                            <h5>Phone</h5> ${response[$i].phone}
                                         </div>
                                         <div class="col">
                                            <h5>Email</h5> ${response[$i].email}
                                         </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h5>
                                        <i class="fa-solid fa-clock"></i>
                                        Joined Date <span class="date"></span>
                                    </h5>
                                </div>
                            </div>

                        `
                        }
                        $('.studentDetail').html($list);
                        $('.date').text($date)
                        if ($('#profile').attr('src') === null || $('#profile').attr('src') ===
                            "") {
                            $('#profile').attr('src',
                                '{{ asset('admin/images/profileMale.jpg') }}')
                        } else {
                            $('#profile').attr('src', '{{ asset('storage/') }}')
                        }
                        $('#hideX').click(function() {
                            $('#hideDiv').hide()
                            $('#myTable tr').removeClass('table-dark');
                        })

                        $('.deleteBtnStudent').click(function() {
                            $idStudent = $(this).find('#idStudent').text()
                            $.ajax({
                                type: 'get',
                                url: '{{ route('student#delete') }}',
                                data: {
                                    'id': $idStudent
                                },
                                dataType: 'json',
                                success: function(response) {
                                    $('#hideDiv').hide()
                                    $('#myListStudent').hide()
                                }
                            })
                        })
                    }
                })
            })
        })
    </script>
@endsection
