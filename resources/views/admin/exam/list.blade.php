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
                            <div class="col-4 rounded bg-white p-3">
                                @if (session('create'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Question Created!</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('quiz#create') }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="question">Question:</label><br>
                                        <textarea class="form-control" id="question" name="question" rows="4" cols="50"></textarea>
                                        @error('question')
                                            <small class="text-danger my-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="my-3">
                                        <label for="category">Category:</label><br>
                                        <select id="category" class="form-select" name="category_id">
                                            <option value="">Choose Category</option>
                                            @foreach ($post as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <small class="text-danger my-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="p-3 border">
                                        <label for="option">Options:</label><br>
                                        <textarea class="form-control" id="option" name="option[]" rows="2" cols="50"></textarea>
                                        <textarea class="form-control" id="option" name="option[]" rows="2" cols="50"></textarea>
                                        <textarea class="form-control" id="option" name="option[]" rows="2" cols="50"></textarea>

                                        @error('option')
                                            <small class="text-danger my-1 d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="my-3">
                                        <label for="correct_option">Correct Option:</label><br>
                                        <input class="form-control" type="text" id="correct_option"
                                            name="correct_option">
                                        @error('correct_option')
                                            <small class="text-danger my-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button class="btn btn-secondary my-3" type="submit">Create Quiz</button>
                                </form>
                            </div>

                            <div class="col-4">
                                <div class="">
                                    <form class="form-header" action="{{ route('quiz#list') }}" method="GET">
                                        @csrf
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input id="inputClear" type="text" name="search"
                                                value="{{ request('search') }}" class="form-control"
                                                placeholder="Search Quiz">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="clearInput"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @if (session('update'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Quiz Updated!</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (count($quiz) != 0)
                                    <div class="table-responsive table-responsive-data2">
                                        <table class="text-center table table-data2" id="myTable">
                                            <thead class="">
                                                <tr class="fw-bolder">
                                                    <th>ID</th>
                                                    <th>CATEGORY </th>
                                                    <th>QUESTION</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span class="row" id="sortTableData">
                                                    @foreach ($quiz as $q)
                                                        <tr class="tr-shadow myList" id="tableData">
                                                            <td class="categoryId">
                                                                {{ $q->id }}
                                                            </td>
                                                            <td>
                                                                <span class="block-email">{{ $q->category }}</span>
                                                            </td>
                                                            <td>
                                                                {{ Str::limit($q->question, $limit = 20, $end = '...') }}
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
                                                </span>

                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h3 class="text-center text-secondary mt-5">There is no Quiz</h3>
                                @endif

                                <div class="mt-5">
                                    {{ $quiz->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            <div class="col-4 editList" id="">

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
            $('#clearInput').click(function() {
                $('#inputClear').val('')
            })
            $('.editBtn').click(function() {
                $('#myTable tr').removeClass('table-dark');
                $(this).parents('tr').addClass('table-dark')
            })
            $('.editBtn').click(function() {
                $parentNode = $(this).parents('tr');
                $id = $parentNode.find('.categoryId').text();
                $.ajax({
                    type: 'get',
                    url: '{{ route('quiz#detail') }}',
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
                            <form action="{{ route('quiz#update') }}" method="POST">
                                @csrf
                                <label for="" class="my-3">Category</label>
                                <select class="form-select" name="category_id">
                                    @foreach ($post as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <label for="" class="my-3">Question</label>
                                <textarea cols="30" rows="5" name="question" class=" form-control">${response[$i].question}</textarea>
                                <div class="p-3 mt-3 border">
                                    <label for="" class="">Options</label>
                                    <textarea cols="30" rows="2" name="option[]" class=" form-control">${response[$i].option[0]}</textarea>
                                    <textarea cols="30" rows="2" name="option[]" class=" form-control">${response[$i].option[1]}</textarea>
                                    <textarea cols="30" rows="2" name="option[]" class=" form-control">${response[$i].option[2]}</textarea>
                                </div>
                                <input type="hidden" name="id" value="${response[$i].id}"/>
                                <div class="">
                                    <label for="" class="my-3 text-success form-label">Answer</label>
                                    <input id="cc-pament" name="correct_option" value="${response[$i].correct_option}" type="text" class="form-control">
                                </div>
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
                            $('#myTable tr').removeClass('table-dark');
                        })
                    }
                })
            })
            $('.deleteBtn').click(function() {
                $parentNode = $(this).parents('tr');
                $id = $parentNode.find('.categoryId').text();

                $.ajax({
                    type: 'get',
                    url: '{{ route('quiz#delete') }}',
                    data: {
                        'id': $id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#tableData').hide();
                        $('#hideDiv').hide();
                    }
                })
            })
        })
    </script>
@endsection
