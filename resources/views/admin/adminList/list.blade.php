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
                            <div class="col-5 rounded bg-white p-3">
                                <h4 class="">Admins</h4>
                                <div class="p-2 my-2">
                                    <form action="{{ route('admin#list') }}" method="GET">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request('search') }}" placeholder="Search for Admin" />
                                    </form>
                                </div>
                                @if (count($admin) != 0)
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="text-center table table-data2" id="myTable">
                                            <thead class="">
                                                <tr class="fw-bolder">
                                                    <th>PROFILE</th>
                                                    <th>NAME</th>
                                                    <th>ADMIN ID</th>
                                                    <th>DATE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span id="" class="row">
                                                    @foreach ($admin as $a)
                                                        <tr class="tr-shadow myList" id="myListAdmin">
                                                            <td class="col-2">
                                                                @if ($a->image)
                                                                    <img class="rounded-circle imgSrc"
                                                                        src="{{ asset('storage/' . $a->image) }}">
                                                                @else
                                                                    <img class="rounded-circle imgSrc"
                                                                        src="{{ asset('admin/images/profileMale.jpg') }}">
                                                                @endif
                                                            </td>
                                                            <td class="desc">{{ $a->name }}@if (Auth::user()->id === $a->id)
                                                                    (You)
                                                                @endif
                                                            </td>
                                                            <td id="" class="desc">{{ $a->admin_id }}</td>
                                                            <td id="adminId" class="desc d-none">{{ $a->id }}</td>
                                                            <td class="desc date">{{ $a->created_at->format('d-F-Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </span>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h3 class="text-center text-secondary mt-5">There is no Admin</h3>
                                @endif

                                <div class="mt-5">
                                    {{ $admin->links('pagination::bootstrap-5') }}
                                </div>
                            </div>

                            <div class="col-7 adminDetail">

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
                var imgSrcPP = $(this).find('.imgSrc')
                $id = $(this).find('#adminId').text();
                $date = $(this).find('.date').text();
                $.ajax({
                    type: 'get',
                    url: '{{ route('admin#detail') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            var imageSrc = response[$i].image ?
                                '{{ asset('storage/response[$i].image') }}' :
                                '{{ asset('admin/images/profileMale.jpg') }}';
                            $list += `
                        <div class="rounded bg-white shadow-sm mt-5 " id="hideDiv">
                            <div class="bg-dark text-white p-3 rounded">
                                <h4 class="text-end" id="hideX">
                                 <i class="fa-solid fa-rectangle-xmark text-danger"></i>
                                </h4>
                                <div class="row">
                                    <div class="col-3 profile">
                                        <img class="rounded-circle" src="${imageSrc}">
                                    </div>
                                    <div class="col-9 d-flex align-items-center">
                                        <div>
                                            <h4 class="text-white">${response[$i].name}</h4>
                                            <p class="text-white">Admin ID : ${response[$i].admin_id}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="p-3">
                                    <div class="border rounded p-3">
                                        <div class="row">
                                            <h3 class="col-8">Basic Details</h3>
                                            <div class="table-data-feature col-4">
                                              <button class="item roleBtnAdmin" data-toggle="tooltip" data-placement="top" title="Admin to Teacher">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                                <div class="d-none" id="idAdmin">${response[$i].id}</div>
                                              </button>
                                              <button class="item deleteBtnAdmin" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                                <div class="d-none" id="idAdmin">${response[$i].id}</div>
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
                        $('.adminDetail').html($list)
                        $('#dateFormat').text($date)
                        $('#hideX').click(function() {
                            $('#hideDiv').hide()
                            $('#myTable tr').removeClass('table-dark');
                        })


                        $('.deleteBtnAdmin').click(function() {
                            $idAdmin = $(this).find('#idAdmin').text()
                            $.ajax({
                                type: 'get',
                                url: '{{ route('admin#delete') }}',
                                data: {
                                    'id': $idAdmin
                                },
                                dataType: 'json',
                                success: function(response) {
                                    $('#hideDiv').hide()
                                    $('#myListAdmin').hide()
                                }
                            })
                        })

                        $('.roleBtnAdmin').click(function() {
                            $idAdmin = $(this).find('#idAdmin').text()
                            $.ajax({
                                type: 'get',
                                url: '{{ route('admin#changeRole') }}',
                                data: {
                                    'id': $idAdmin
                                },
                                dataType: 'json',
                                success: function(response) {
                                    $('#hideDiv').hide()
                                    $('#myListAdmin').hide()
                                }
                            })
                        })
                    }
                })

            })
        })
    </script>
@endsection
