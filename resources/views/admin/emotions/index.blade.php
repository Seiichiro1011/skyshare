@extends('layouts.app')

@section('title','Admin:Emotions')

@section('content')
<form action="{{ route('admin.emotions.store')}}" method="post" >
    @csrf
    <div class="row">
       <div class="col-4 pe-0">
            <input type="text" name="name" id="name" class="form-control" placeholder="Add a emotion..." autofocus>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
    </div>
    @error('name')
    <p class="text-danger small">{{$message}}</p>
    @enderror
</form>
    <div class="row mt-5">
        <div class="col-md-7">
            <table class="table table-hover align-middle bg-white border">
                <thead class="small table-warning text-secondary">
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>COUNT</th>
                        <th>LATEST UPDATED</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($all_emotions as $emotion)
                    <tr>
                        <td>{{$emotion->id}}</td>
                        <td>
                         {{$emotion->name}}
                        </td>
                        <td>{{$emotion->emotionPost->count()}}</td>
                        <td>{{$emotion->updated_at}}</td>
                        <td>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-emotion-{{$emotion->id}}"><i class="fa-solid fa-pen"></i>
                                        </button>

                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-emotion-{{$emotion->id}}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                        @include('admin.emotions.modal.status')
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td>Uncategorized</td>
                        <td>{{$count}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
        </table>
    </div>
</div>
@endsection
