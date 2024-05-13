@extends('layouts.app')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layouts.sidebar')
            </div>
            <div class="col-md-9">
                @include('layouts.message')
                <form action="{{ route('account.changePasswordPost') }}" method="post">
                @csrf
                    <div class="card border-0 shadow">
                        <div class="card-header  text-white">
                            Change Password
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Old Password</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Old Password" name="old_password" id="old_password" />
                                @error('old_password')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" placeholder="New Password"  name="new_password" id="new_password"/>
                                @error('new_password')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" placeholder="Confirm Password"  name="password_confirm" id="password_confirm"/>
                                @error('password_confirm')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="btn btn-primary mt-2">Update</button>                     
                        </div>
                    </div>      
                </form>          
            </div>
        </div>       
    </div>
 @endsection