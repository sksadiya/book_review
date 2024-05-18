@extends('layouts.app')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layouts.sidebar')           
            </div>
            <div class="col-md-9">
                
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        My Reviews
                    </div>
                    <div class="card-body pb-0">            
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>                                  
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                @if (!empty($reviews))
                                    @foreach ($reviews as $review)
                                    <tr>
                                        <td>{{ $review->book->title }}</td>
                                        <td>{{ $review->review}}</td>                                        
                                        <td><i class="fa-regular fa-star"></i> {{ $review->ratings }}</td>
                                        @if ($review->status == 1)
                                            <td>Active</td>
                                            @else
                                            <td>Block</td>
                                        @endif
                                        <td>
                                            <a href="edit-review.html" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('myReview.delete',$review->id) }}" onclick="return confirm('are you sure?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                     @endforeach
                                    @endif
                                </tbody>
                            </thead>
                        </table>   
                        <nav aria-label="Page navigation " >
                            {{$reviews->links()}}
                          </nav>                  
                    </div>
                    
                </div>                
            </div>
        </div>       
    </div>
  @endsection