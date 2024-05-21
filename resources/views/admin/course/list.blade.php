@extends('admin.layouts.master');

@section('title', 'Category');

@section('content')
    <div class="page-wrapper">


        <!-- PAGE CONTAINER-->
        <div class="page-container">

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="table-data__tool row p-3 rounded shadow-sm bg-white">
                                <div class="table-data__tool-left col-8 ">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Course</h2>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <form class="form-header" action="{{ route('course#list') }}" method="GET">
                                        @csrf
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input id="inputClear" type="text" name="search"
                                                value="{{ request('search') }}" class="form-control"
                                                placeholder="Search Course">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="clearInput"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div id=""
                                    class="col-3 bg-white table-responsive table-responsive-data2 rounded p-3">
                                    @if (session('status'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Couse Uploaded!</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{ route('course#create') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group ">
                                            <div class="">
                                                <input type="text" placeholder="Enter Title" name="title"
                                                    class="form-control" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="my-3">
                                                <select name="category" class="form-select">
                                                    <option value="">Choose Category</option>
                                                    @foreach ($category as $c)
                                                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="my-3 border">
                                                <label for="changePp" id="">
                                                    <div class="bg-white text-center">
                                                        <img src="{{ asset('admin/images/Add_Image_icon.png') }}"
                                                            class="col-6 my-2" id="previewImage" />
                                                    </div>
                                                </label>
                                                <input id="changePp" name="image" type="file"
                                                    class="d-none form-control" />
                                                @error('image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="my-3">
                                                <textarea cols="30" rows="6" placeholder="Enter Description" name="description" class="form-control"></textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <button id="createCategory" type="submit" class="btn btn-info">
                                            <span id="">UPLOAD</span>
                                            <i class="fa-solid fa-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <div class="">
                                        <form class="form-header" action="{{ route('quiz#list') }}" method="GET">
                                            @csrf
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                </div>
                                                <input id="inputClear" type="text" name="search"
                                                    value="{{ request('search') }}" class="form-control"
                                                    placeholder="Search Course">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="clearInput"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    @if (session('update'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Course Updated!</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (count($data) != 0)
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="text-center table table-data2" id="courseTable">
                                                <thead class="">
                                                    <tr class="fw-bolder">
                                                        <th>IMAGE</th>
                                                        <th>NAME</th>
                                                        <th>CATEGORY </th>
                                                        <th>DESCRIPTION</th>
                                                        <th>VIEW COUNT</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <span class="row" id="sortTableData">
                                                        @foreach ($data as $d)
                                                            <tr class="tr-shadow" id="tableData">
                                                                <td class="categoryId d-none">
                                                                    {{ $d->id }}
                                                                </td>
                                                                <td class="col-4">
                                                                    <img class=""
                                                                        src="{{ asset('storage/' . $d->image) }}" />
                                                                </td>
                                                                <td>
                                                                    <span class="block-email">{{ $d->title }}</span>
                                                                </td>
                                                                <td>
                                                                    {{ $d->categoryTitle }}
                                                                </td>
                                                                <td class="desc col-5">
                                                                    {{ Str::limit($d->description, $limit = 50, $end = '...') }}
                                                                </td>
                                                                <td>
                                                                    {{ $d->view_count }}
                                                                </td>
                                                                <td>
                                                                    <div class="table-data-feature">

                                                                        <button id="" class="item editBtn"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Edit">
                                                                            <i class="zmdi zmdi-edit"></i>
                                                                        </button>

                                                                        <button class="item deleteBtn"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Delete">
                                                                            <i class="zmdi zmdi-delete"></i>
                                                                        </button>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </span>

                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <h3 class="text-center text-secondary mt-5">There is no Course</h3>
                                    @endif

                                    <div class="mt-5">
                                        {{ $data->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                                <div class="col-3 editList" id="">

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
            $('#clearInput').click(function() {
                $('#inputClear').val('')
            })
            $('.editBtn').click(function() {
                $('#courseTable tr').removeClass('table-dark');
                $(this).parents('tr').addClass('table-dark')
            })
            $('.editBtn').click(function() {
                $parentNode = $(this).parents('tr');
                $id = $parentNode.find('.categoryId').text();

                $.ajax({
                    type: 'get',
                    url: '{{ route('course#detail') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $list += `
                         <div class="bg-white p-2" id="hideDiv">
                            <div class="text-end p-2" id="hideX">
                                <i class="fa-solid fa-rectangle-xmark text-danger"></i>
                            </div>
                            <form action="{{ route('course#update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <img src="{{ asset('storage/${response[$i].image}') }}"/>
                                <label for="chooseImage">
                                    Choose Image
                                </label>
                                <input type="file" name="image" id="chooseImage" class="d-none"/>
                                <input type="hidden" name="id" value="${response[$i].id}"/>
                                <select class="my-3 form-select" name="category_id">
                                    @foreach ($category as $c)
                                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                                    @endforeach
                                </select>
                                <input id="cc-pament" name="title" value="${response[$i].title}" type="text" class="form-control @error('title')  is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Category Title">
                                <textarea cols="30" rows="10" placeholder="Enter Description" name="description" class="my-3 form-control">${response[$i].description}</textarea>
                                <div class="mt-2">
                                  <a href="">
                                    <button id="payment-button " id="editCategory" type="submit" class="btn btn-info rounded">
                                      <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                  </a>
                                </div>
                            </form>
                         </div>
                              `
                        }
                        $('.editList').html($list);
                        $('#hideX').click(function() {
                            $('#hideDiv').hide();
                            $('#courseTable tr').removeClass('table-dark');
                        })
                    }
                })
            })
            $('.deleteBtn').click(function() {
                $parentNode = $(this).parents('tr');
                $id = $parentNode.find('.categoryId').text();

                $.ajax({
                    type: 'get',
                    url: '{{ route('course#delete') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#tableData').hide()
                    }
                })
            })
            $('#changePp').on('change', function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.onload = function(event) {
                    $('#previewImage').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            });
        })
    </script>
@endsection
