@extends('layouts.app')

@section('title','Admin:Users')

@section('content')
<table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-success text-secondary">
            <tr>
                <th></th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
        @foreach($all_users as $user)
            <tr>
                <td>
                    @if ($user->avatar)
                    <a href="{{ route('profile.show',$user->id)}}" >
                    <img src="{{ asset('/storage/avatars/' . $user->avatar)}}" alt="{{ $user->avatar}}" class="rounded-circle d-block mx-auto admin-users-avatar">
                    </a>
                    @else
                    <a href="{{ route('profile.show',$user->id)}}" class="text-decoration-none text-secondary">
                        <i class="fa-solid fa-circle-user d-block text-center admin-users-icon"></i>
                    </a>
                    @endif
                </td>
                <td>
                    <a href="{{ route('profile.show',$user->id)}}" class="text-decoration-none text-dark fw-bold">{{$user->name}}</a>
                </td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                    @if ($user->trashed())
                        <i class="fa-regular fa-circle text-secondary"></i>&nbsp; Inactive
                    @else
                        <i class="fa-solid fa-circle text-success"></i>&nbsp; Active
                    @endif
                </td>
                <td>
                    @if(!($user->id===Auth::user()->id))
                    <div class="dropdown">
                        <button class="btn btn-sm box-shadow " id="admin-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        @if ($user->trashed())
                        <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="admin-dropdown">
                            <button type="button" class="dropdown-item  p-2" data-bs-toggle="modal" data-bs-target="#activate-user-{{$user->id}}">
                                <i class="fa-solid fa-user-check"></i> Activate {{$user->name}}
                            </button>
                        </div>
                        @else
                        <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="admin-dropdown">
                            <button type="button" class="dropdown-item text-danger p-2" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{$user->id}}">
                                <i class="fa-solid fa-user-large-slash"></i> Deactivate {{$user->name}}
                            </button>
                        </div>
                        @endif
                    </div>
                        @include('admin.users.modal.status')
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
       </table>

       <div class="d-flex justify-content-center ">
        {{ $all_users->links() }}
        </div>
       @endsection
