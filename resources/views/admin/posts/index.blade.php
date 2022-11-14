@extends('layouts.app')

@section('title','Admin:Posts')

@section('content')
<table class="table table-hover align-middle bg-white border">
        <thead class="small table-primary text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>
                    <a href="{{ route('post.show',$post->id)}}" >
                        <img src="{{ asset('/storage/images/' . $post->image)}}" alt="{{ $post->image}}" class=" d-block mx-auto admin-posts-img">
                    </a>
                </td>
                <td>@if ($post->categoryPost->count()==0)
                    <div class="badge bg-dark text-wrap">
                        Uncategorized
                    </div>
                    @endif
                    @foreach($post->categoryPost as $category_post)
                    <div class="badge bg-secondary bg-opacity-50">
                        {{$category_post->category->name}}
                    </div>
                    @endforeach
               </td>
                <td>
                    <a href="{{ route('profile.show',$post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
                </td>
                <td>{{$post->created_at}}</td>
                <td>
                    @if ($post->trashed())
                        <i class="fa-regular fa-circle text-secondary"></i>&nbsp; Hidden
                    @else
                        <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                    @endif
                </td>
                <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" id="admin-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            @if ($post->trashed())
                            <div class="dropdown-menu p-0" aria-labelledby="admin-dropdown">
                                <button type="button" class="dropdown-item  p-2" data-bs-toggle="modal" data-bs-target="#unhide-post-{{$post->id}}">
                                    <i class="fa-solid fa-eye"></i> Unhide Post {{$post->id}}
                                </button>
                            </div>
                            @else
                                <div class="dropdown-menu p-0" aria-labelledby="admin-dropdown">
                                    <button type="button" class="dropdown-item text-danger p-2" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post {{$post->id}}
                                    </button>
                                </div>
                            @endif
                    </div>
                        @include('admin.posts.modal.status')
                </td>
            </tr>
        @empty
            <tr>
                <td class="lead text-muted text-center">No posts found.</td>
            </tr>
        @endforelse
        </tbody>

</table>
       <div class="d-flex justify-content-center ">
            {{ $all_posts->links() }}
        </div>
@endsection
