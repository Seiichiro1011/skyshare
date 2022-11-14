@extends('layouts.app')


@section('title','Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="row justify-content-center">
    @if(session('success'))
         <div class="alert alert-success text-center col-8">{{session('success')}}</div>
    @endif
    </div>
        <div class="col-8">
            <form action="{{route('profile.update')}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h2 class="mb-3 fw-light text-muted">Update Profile</h2>

            <div class="row mb-3">
                <div class="col-xl-4">
                    @if($user->avatar)
                        <img src="{{asset('storage/avatars/' . $user->avatar)}}" alt="{{$user->avatar}}" class="img-thumbnail rounded-circle d-block mx-auto profile-avatar">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary d-block text-center profile-icon"></i>
                    @endif
                </div>
                <div class="col-auto align-self-end">
                    <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1" aria-describedby="avatar-info">
                    <div class="form-text">
                        Acceptable formats: jpeg,jpg,png,gif only <br>
                        Max file size is 1048KB
                    </div>
                    {{-- Error --}}
                    @error("avatar")
                    <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label fw-bold p-0">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$user->name)}}" autofocus>
                @error("name")
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold p-0">E-Mail Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email',$user->email)}}">
                @error("email")
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="introduction" class="form-label fw-bold p-0">Introduction</label>
                <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{old('introduction',$user->introduction)}}</textarea>
                @error("introduction")
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-warning px-5">Save</button>
            </div>

            </form>
        </div>
    </div>

    {{-- Update password --}}
    <div class="row justify-content-center mt-5">
        <div class="col-8">
            <form action="{{route('profile.updatePass')}}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h2 class="mb-3 fw-light text-muted">Update Password</h2>

            <div class="mb-3">
                <label for="old_password" class="form-label fw-bold p-0">Current Password</label>
                <input type="password" name="old_password" id="old_password" class="form-control" required>
                @if(session('old_password_error'))
                <p class="text-danger small">{{session('old_password_error')}}</p>
                @endif
                @error("old_password")
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label fw-bold p-0">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>

                <div class="form-text">
                    Your password must be at least 8 characters long, and contain letters and numbers
                </div>
                @if(session('new_password_error'))
                <p class="text-danger small">{{session('new_password_error')}}</p>
                @endif
                @error("new_password")
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-bold p-0">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                @error("password_confirmation")
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-warning px-5">Update Password</button>
            </div>

            </form>
        </div>
    </div>
@endsection
