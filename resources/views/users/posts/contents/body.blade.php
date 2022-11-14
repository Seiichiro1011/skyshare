{{-- clicable image --}}
<div class="container p-0">
    <a href="{{route('post.show',$post->id)}}">
        <img src="{{asset('/storage/images/' . $post->image)}}" alt="$post->image" class="w-100">
    </a>
</div>
<div class="card-body">
    {{-- heart button +no. of likes + categories --}}
    <div class="row align-items-center">
        <div class="col-auto pe-0">
            @if ($post->isLiked())
                <form action="{{ route('like.destroy',$post->id)}} " method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm  shadow-none ps-0 "><i class="fa-solid fa-heart text-danger" ></i></button>
            </form>
            @else
                <form action="{{ route('like.store',$post->id)}}" method="post">
                @csrf
                <button type="submit" class="btn btn-sm shadow-none ps-0"><i class="fa-regular fa-heart"></i></button>
            </form>
            @endif
        </div>

            <div class="col-auto px-0">
            @if(!($post->likes->count()===0))
            <button  class="btn btn-link text-decoration-none text-dark px-0" data-bs-toggle="modal" data-bs-target="#post-like-{{$post->id}}">
                <span>{{$post->likes->count()}}</span>
            </button>
            @else
                <span>{{$post->likes->count()}}</span>
            @endif
                @include('users.posts.modal.status')
        </div>
        <div class="col text-end">
            @if ($post->emotionPost->count()==0)
            <div class="badge bg-dark text-wrap">
                Uncategorized
            </div>
            @endif
            @foreach($post->emotionPost as $emotion_post)
                    <div class="badge bg-secondary bg-opacity-50">
                        {{$emotion_post->emotion->name}}
                    </div>
            @endforeach
        </div>
    </div>
    {{-- owner +description --}}
    <a href="{{route('profile.show',$post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
    &nbsp;
    <p class="d-inline fw-light">{{$post->description}}</p>

    {{-- comments --}}
    @include('users.posts.contents.comments')
</div>
