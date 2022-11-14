@extends('layouts.app')

@section('title','Create Post')

@section('content')
<form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    {{-- for security --}}
    {{-- cross site request forgeries --}}
    <div class="mb-3">
        <label for="emotion" class="form-label d-block fw-bold">
            Emotion <span class="text-muted fw-normal">(up to 3)</span>
        </label>
        @foreach($all_emotions as $emotion)
        <div class="form-check form-check-inline">
            <input type="checkbox" name="emotion[]" id="{{$emotion->name}}" value="{{ $emotion->id}}" class="form-check-input">
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
        <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{old('description')}}</textarea>
        {{-- Error --}}
        @error('description')
        <p class="text-danger sdmall">{{$message}}</p>
        @enderror
    </div>
    <div class="mb-4">
        {{-- Image --}}
        <label for="image" class="form-label fw-bold">
            Image
        </label>
        <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
        <div id="image-info" class="form-text" >
            <p class="mb-0">Acceptable formats: jpeg,jpg,png,gif only</p>
            <p>Max file size is 1048KB</p>
          </div>
        {{-- Error --}}
        @error('image')
        <p class="text-danger small">{{$message}}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary px-5">Post</button>

</form>
@endsection
