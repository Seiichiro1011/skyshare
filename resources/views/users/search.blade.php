@extends('layouts.app')

@section('title','Search')

@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <p class="h5 text-muted mb-4">Search results for "<span class="fw-bold">{{$search}}</span>"</p>
            @forelse ($users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show',$user->id)}}">
                            @if($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar)}}" alt="{{$user->avatar}}" class="rounded-circle search-user-avatar">
                            @else
                            <i class="fa-solid fa-circle-user text-secondary search-user-icon"></i>
                            @endif
                        </a>
                    </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show',$user->id)}}" class="text-decoration-none text-dark fw-bold">{{$user->name}}</a>
                            <p class="text-muted nm-0">{{$user->email}}</p>
                        </div>
                        <div class="col-auto">
                            @if ($user->id !==Auth::user()->id)
                                @if ($user->isFollowed())
                                    <form action="{{ route('follow.destroy',$user->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary opacity-50 fw-bold btn-sm">Following</button>
                                    </form>
                            @else
                            <form action="{{ route('follow.store',$user->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                            </form>
                         @endif
                        @endif
                        </div>
                    </div>
                @empty
                        <p class="lead text-muted text-center">No users found.</p>
                @endforelse
        </div>
    </div>
@endsection
