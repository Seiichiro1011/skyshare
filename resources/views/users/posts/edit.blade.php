@extends('layouts.app')

@section('title','Edit Post')

@section('content')
<form action="{{route('post.update',$post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    {{-- for security --}}
    {{-- cross site request forgeries --}}
    <div class="mb-3">
        <label for="emotion" class="form-label d-block fw-bold">
            Emotions <span class="text-muted fw-normal">(up to 3)</span>
        </label>
        @foreach($all_emotions as $emotion)
        <div class="form-check form-check-inline">
            @if (in_array($emotion->id,$selected_emotions))
                <input type="checkbox" name="emotion[]" id="{{$emotion->name}}" value="{{ $emotion->id}}" class="form-check-input" checked>
            @else
                <input type="checkbox" name="emotion[]" id="{{$emotion->name}}" value="{{ $emotion->id}}" class="form-check-input">
            @endif

            <label for="{{$emotion->name}}" class="form-check-label">{{$emotion->name}}</label>
        </div>
        @endforeach
        {{-- Error --}}
        @error('emotion')
        <p class="text-danger small">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-3">
        {{-- Description --}}
        <label for="description" class="form-label fw-bold">
            Description
        </label>
        <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{old('description',$post->description)}}</textarea>
        {{-- Error --}}
        @error('description')
        <p class="text-danger sdmall">{{$message}}</p>
        @enderror
    </div>
    <div class="row mb-4">
        <div class="col-6">
            <label for="image" class="form-label fw-bold">Image</label>
            <img src="{{asset('/storage/images/' . $post->image)}}" alt="{{$post->image}}" class="img-thumbnail w-100">
            <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">
            <div id="image-info" class="form-text" >
                <p class="mb-0">Acceptable formats: jpeg,jpg,png,gif only</p>
                <p>Max file size is 1048KB</p>
              </div>
            {{-- Error --}}
            @error('image')
            <p class="text-danger small">{{$message}}</p>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-warning px-5">Save
    </button>

</form>
@endsection
