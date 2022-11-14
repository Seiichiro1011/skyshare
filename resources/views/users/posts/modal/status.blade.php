<div class="modal fade"  id="post-like-{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                     Likers
                </h3>
            </div>
            <div class="modal-body">
                @foreach ($liked_users as $like)
                @if($post->id===$like->post_id)
                <div class="row align-items-center mt-3">
                    <div class="col-auto">
                        <a href="{{route('profile.show',$like->user->id)}}" class="">
                                @if ($like->user->avatar)
                                <img src="{{asset('storage/avatars/' . $like->user->avatar)}}" alt="{{$like->user->avatar}}" class="rounded-circle user-avatar">
                                @else
                                <i class="fa-solid fa-circle-user text-secondary user-icon"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{route('profile.show',$like->user->id)}}" class="text-decoration-none text-dark fw-bold small">{{$like->user->name}}</a>
                        </div>
                        <div class="col-auto text-end">
                            @if(Auth::user()->id != $like->user->id)
                            @if ($like->user->isFollowed())
                                <form action="{{ route('follow.destroy',$like->user->id)}}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm ">Following</button>
                                </form>
                            @else
                                <form action="{{ route('follow.store',$like->user->id)}}" method="post" class="d-inline">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm  ">Follow</button>
                                </form>
                     @endif
                     @endif
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
     </div>
</div>
