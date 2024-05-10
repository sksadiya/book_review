@extends('layouts.app')
    @section('main')

        <div class="container">
          
            <div class="row my-5">
                <div class="col-md-3">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header  text-white">
                            Welcome, {{ $user->name }}                        
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="{{ asset('uploads/profile/thumb/'.$user->image) }}" class="img-fluid rounded-circle" alt="{{ $user->name }}">                            
                            </div>
                            <div class="h5 text-center">
                                <strong>{{ $user->name }}</strong>
                                <p class="h6 mt-2 text-muted">5 Reviews</p>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-lg mt-3">
                        <div class="card-header  text-white">
                            Navigation
                        </div>
                        <div class="card-body sidebar">
                            @include('layouts.sidebar')
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                @include('layouts.message')
                    <div class="card border-0 shadow">
                        <div class="card-header  text-white">
                            Profile
                        </div>
                        <form action="{{ route('account.updateProfile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" id="name" />
                                    @error('name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email"  name="email" id="email"/>
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                    <img src="{{ asset('uploads/profile/thumb/'.$user->image) }}" class="img-fluid mt-4" alt="{{ $user->name }}" >
                                </div>   
                                <button class="btn btn-primary mt-2">Update</button>                     
                            </div>
                        </form>
                    </div>                
                </div>
            </div>       
        </div>
    @endsection