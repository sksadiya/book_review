@extends('layouts.app')
@section('main')
    <div class="container mt-3 pb-5">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-3">Books</h2>
                    <div class="mt-2">
                        <a href="{{ route('home') }}" class="btn btn-dark text-white">Clear</a>
                    </div>
                </div>
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <form action="" method="get">
                        <div class="row">
                            <div class="col-lg-11 col-md-11">
                                <input type="text" value="{{ Request::get('search') }}" class="form-control form-control-lg" name="search" id="search" placeholder="Search by title">
                            </div>
                            <div class="col-lg-1 col-md-1">
                                <button class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-magnifying-glass"></i></button>                                                                    
                            </div>                                                                                 
                        </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
                    @if(!empty($books))
                    @foreach ($books as $book)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card border-0 shadow-lg">
                            @if (!empty($book->image))
                            <a href="{{ route('detail',$book->id) }}"><img src="{{ asset('uploads/books/thumb/'.$book->image) }}" alt="" class="card-img-top"></a>
                            @else
                            <a href="{{ route('detail',$book->id) }}"><img src="{{ asset('images/elementor-placeholder-image.webp') }}" alt="" class="card-img-top"></a>
                            @endif
                            <div class="card-body">
                                <h3 class="h4 heading"><a href="{{ route('detail',$book->id) }}">{{ $book->title }}</a></h3>
                                <p>by {{ $book->author }}</p>
                                <div class="star-rating d-inline-flex ml-2" title="">
                                    <span class="rating-text theme-font theme-yellow">{{ number_format($book->average_rating, 1) }}</span>
                                    <div class="star-rating d-inline-flex mx-2" title="">
                                        <div class="back-stars ">
                                            <i class="fa fa-star " aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
        
                                            <div class="front-stars" style="width: {{ $book->average_rating * 20 }}%">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="theme-font text-muted">({{ $book->reviews_count }} Reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <nav aria-label="Page navigation " >
                        {{ $books->links() }}
                      </nav>    
                </div>
            </div>
        </div>
    </div>    
@endsection