@extends('admin.layouts.master');

@section('content')
    <div class="page-wrapper">


        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="mb-3">
                        <a href="{{ route('teacher#add') }}">
                            <button class="btn btn-success">
                                <i class="fa-solid fa-user-plus me-2"></i>Add Teacher
                            </button>
                        </a>
                        @if (session('status'))
                            <div class="col-5 mt-2 alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Successfully added!</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-5 rounded bg-white p-3">
                                <h4 class="">Teachers</h4>
                                <div class="p-2 my-2">
                                    <form action="" method="GET">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request('search') }}" placeholder="Search for teachers" />
                                    </form>
                                </div>
                                @if (count($teacher) != 0)
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="text-center table table-data2" id="myTable">
                                            <thead class="">
                                                <tr class="fw-bolder">
                                                    <th>PROFILE</th>
                                                    <th>NAME</th>
                                                    <th>TEACHER ID</th>
                                                    <th>DATE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span id="" class="row">
                                                    @foreach ($teacher as $t)
                                                        <tr class="tr-shadow myList" id="dMyList">
                                                            <td class="col-2">
                                                                @if ($t->image == null)
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('admin/images/profileMale.jpg') }}">
                                                                @else
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('storage/' . $t->image) }}">
                                                                @endif
                                                            </td>
                                                            <td class="desc">{{ $t->name }}</td>
                                                            <td id="" class="desc">{{ $t->teacher_id }}</td>
                                                            <td id="teacherId" class="desc d-none">{{ $t->id }}</td>
                                                            <td class="desc date">{{ $t->created_at->format('d-F-Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </span>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h3 class="text-center text-secondary mt-5">There is no teacher</h3>
                                @endif

                                <div class="mt-5">
                                    {{ $teacher->links('pagination::bootstrap-5') }}
                                </div>
                            </div>

                            <div class="col-7 teacherDetail">

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
                $id = $(this).find('#teacherId').text();
                $date = $(this).find('.date').text();

                $.ajax({
                    type: 'get',
                    url: '{{ route('teacher#detail') }}',
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
                                            <p class="text-white">teacher ID : ${response[$i].teacher_id}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="p-3">
                                    <div class="border rounded p-3">
                                        <div class="row">
                                            <h3 class="col-8">Basic Details</h3>
                                            <div class="table-data-feature col-4">
                                              <button class="item roleBtnTeacher" data-toggle="tooltip" data-placement="top" title="Teacher to Admin">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                                <div class="d-none" id="idTeacher">${response[$i].id}</div>
                                              </button>
                                              <button class="item deleteBtnTeacher" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                                <div class="d-none" id="idTeacher">${response[$i].id}</div>
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
                                        Joined Date <span id="dateFormat"></span>
                                    </h5>
                                </div>
                            </div>

                        `
                        }
                        $('.teacherDetail').html($list);
                        $('#dateFormat').text($date)
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

                        $('.deleteBtnTeacher').click(function() {
                            $idTeacher = $(this).find('#idTeacher').text()
                            $.ajax({
                                type: 'get',
                                url: '{{ route('teacher#delete') }}',
                                data: {
                                    'id': $idTeacher
                                },
                                dataType: 'json',
                                success: function(response) {
                                    $('#hideDiv').hide()
                                    $('#dMyList').hide()
                                }
                            })
                        })

                        $('.roleBtnTeacher').click(function() {
                            $idTeacher = $(this).find('#idTeacher').text()
                            $.ajax({
                                type: 'get',
                                url: '{{ route('teacher#changeRole') }}',
                                data: {
                                    'id': $idTeacher
                                },
                                dataType: 'json',
                                success: function(response) {
                                    $('#hideDiv').hide()
                                    $('#dMyList').hide()
                                }
                            })
                        })
                    }
                })
            })
        })
    </script>
@endsection
