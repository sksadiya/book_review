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
                            Edit review
                        </div>
                        <form action="{{ route('account.update-reviews',$review->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Review</label>
                                    <input type="text" value="{{ $review->review }}" class="form-control @error('review') is-invalid @enderror" placeholder="Review" name="review" id="review" />
                                    @error('review')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Ratings</label>
                                    <select name="rating" id="rating" class="form-control" placeholder="Rating">
                                        <option {{ ($review->ratings == 1) ? 'selected' : '' }} value="1">1</option>
                                        <option {{ ($review->ratings == 2) ? 'selected' : '' }} value="2">2</option>
                                        <option {{ ($review->ratings == 3) ? 'selected' : '' }} value="3">3</option>
                                        <option {{ ($review->ratings == 4) ? 'selected' : '' }} value="4">4</option>
                                        <option {{ ($review->ratings == 5) ? 'selected' : '' }} value="5">5</option>
                                    </select>
                                    @error('rating')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button class="btn btn-primary mt-2">Update</button>                     
                            </div>
                        </form>
                    </div>                
                </div>
            </div>       
        </div>
    @endsection