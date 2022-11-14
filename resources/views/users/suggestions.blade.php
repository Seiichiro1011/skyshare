@extends('layouts.app')

@section('title','Suggestions')
@section('content')
<div class="col-7 mx-auto">
<p class="fw-bold">Suggested</p>

@foreach($suggested_users as $user)
        <div class="row align-items-center mt-3">
            <div class="col-auto">
                <a href="{{route('profile.show',$user->id)}}" class="">
                    @if ($user->avatar)
                        <img src="{{asset('storage/avatars/' . $user->avatar)}}" alt="{{$user->avatar}}" class="rounded-circle suggested-avatar">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary suggested-icon"></i>
                    @endif
                </a>
            </div>
                <div class="col ps-0 text-truncate">
                    {{-- clickable name --}}
                    <a href="{{ route('profile.show',$user->id)}}" class="text-decoration-none text-dark fw-bold">
                        {{$user->name}}
                    </a>
                    {{-- email --}}
                    <p class="text-muted my-0">{{$user->email}}</p>
                    {{-- Subtitles --}}
                    @if($user->isFollowingMe())
                        <p class="text-muted mb-0">Follows you</p>
                    @elseif($user->followers->count()===0)
                        <p class="text-muted mb-0">No followers yet</p>
                    @else
                    <p class="text-muted mb-0">
                        {{$user->followers->count()}}
                        {{$user->followers->count()===1 ? 'follower' : 'followers'}}
                    </p>
                    @endif
                </div>
                <div class="col-auto text-end">
                    <form action="{{ route('follow.store',$user->id)}}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm ">Follow</button>
                    </form>
                </div>
            </div>
            @endforeach
</div>
@endsection
