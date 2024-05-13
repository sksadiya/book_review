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
                        Edit Book
                    </div>
                    <form action="{{ route('books.update',$book->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" value="{{ $book->title }}" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" />
                                @error('title')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" value="{{ $book->author }}" class="form-control @error('author') is-invalid @enderror" placeholder="Author"  name="author" id="author"/>
                                @error('author')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5">{{ $book->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="Image" class="form-label">Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image"/>
                                @error('image')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                            @if (!empty($book->image))
                            <img src="{{ asset('uploads/books/thumb/'.$book->image)}}" alt="{{ $book->image }}" height="200" width="200">
                            @endif
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option {{ ($book->status == 0 ? 'selected' : '')}} value="0">Block</option>
                                    <option {{ ($book->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                </select>
                                @error('status')
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