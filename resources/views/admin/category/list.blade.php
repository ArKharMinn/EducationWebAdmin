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
                                        <h2 class="title-1">Category</h2>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <form class="form-header" action="{{ route('category#list') }}" method="GET">
                                        @csrf
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input id="inputClear" type="text" name="search"
                                                value="{{ request('search') }}" class="form-control"
                                                placeholder="Search Category">
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
                                            <strong>Category Created!</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{ route('category#create') }}" method="POST">
                                        @csrf
                                        <div class="form-group ">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament " name="title" type="text"
                                                class="createTitle form-control @error('title')  is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Category...">
                                            @error('title')
                                                <small class="text-danger invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group ">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea cols="30" rows="6" placeholder="Enter Description" name="description" class="form-control"></textarea>
                                            @error('description')
                                                <small class="text-danger invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button id="createCategory" type="submit" class="btn btn-info">
                                            <span id="">Create</span>
                                            <i class="fa-solid fa-circle-right"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6 ">
                                    @if (session('update'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Category Updated!</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (count($data) != 0)
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="text-center table table-data2" id="courseTable">
                                                <thead class="">
                                                    <tr class="fw-bolder">
                                                        <th>ID</th>
                                                        <th>CATEGORY NAME</th>
                                                        <th>DESCRIPTION</th>
                                                        <th>CREATED DATE</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $category)
                                                        <tr class="tr-shadow" id="tableData">
                                                            <td class="categoryId">{{ $category->id }}</td>
                                                            <td>
                                                                <span class="block-email">{{ $category->title }}</span>
                                                            </td>
                                                            <td class="desc">{{ $category->description }}</td>
                                                            <td class="desc">{{ $category->created_at->format('j-F-Y') }}
                                                            </td>
                                                            <td>
                                                                <div class="table-data-feature">

                                                                    <button id="" class="item editBtn"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                    </button>

                                                                    <button class="item deleteBtn" data-toggle="tooltip"
                                                                        data-placement="top" title="Delete">
                                                                        <i class="zmdi zmdi-delete"></i>
                                                                    </button>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <h3 class="text-center text-secondary mt-5">There is no Categories</h3>
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
                    url: '{{ route('category#detail') }}',
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
                            <form action="{{ route('category#update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="${response[$i].id}"/>
                                <input id="cc-pament" name="title" value="${response[$i].title}" type="text" class="form-control @error('title')  is-invalid @enderror" aria-required="true" aria-invalid="false">
                                <input id="cc-pament" name="description" value="${response[$i].description}" type="text" class="my-3 form-control @error('description')  is-invalid @enderror" aria-required="true" aria-invalid="false">
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
                        $('#editCategory').click(function() {
                            console.log('hi')
                        })
                    }
                })
            })
            $('.deleteBtn').click(function() {
                $parentNode = $(this).parents('tr');
                $id = $parentNode.find('.categoryId').text();

                $.ajax({
                    type: 'get',
                    url: '{{ route('category#delete') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#tableData').hide()
                    }
                })
            })
        })
    </script>
@endsection
