@extends('layouts.app')
        @section('main')
        <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                        @include('layouts.sidebar')
            </div>
            <div class="col-md-9">
            @include('layouts.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Books
                    </div>
                    <div class="card-body pb-0">            
                        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>            
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                                <tbody>
                                    @if (!empty($books))
                                    @foreach ($books as $book)
                                    <tr>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>3.0 (3 Reviews)</td>
                                        <td>{{ $book->status  }}</td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                            <a href="{{ route('books.edit',$book->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('books.delete',$book->id) }}" onclick="return confirm('are you sure?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">No Record Found</td>
                                        </tr>
                                    @endif
                                    
                                </tbody>
                            </thead>
                        </table>   
                        <nav aria-label="Page navigation " >
                           {{ $books->links() }}
                          </nav>                  
                    </div>
                    
                </div>                
            </div>
        </div>       
    </div>
       @endsection
