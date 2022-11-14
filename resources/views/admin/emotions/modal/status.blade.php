
{{-- Edit --}}
<div class="modal fade" id="edit-emotion-{{$emotion->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Emotion
                </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.emotions.update',$emotion->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="name" class="form-control"
                    value="{{ old('name',$emotion->name)}}" autofocus>

                </div>
            <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Update</button>
                </form>
            </div>
        </div>
     </div>
</div>

{{--Delete  --}}
<div class="modal fade" id="delete-emotion-{{$emotion->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash"></i> Delete Emotion
                </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{$emotion->name}}</strong> emotion?</p>

                <p>This action affect all the posts under this emotion. Posts without a emotion will fall under Uncategorized.</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.emotions.destroy',$emotion->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
     </div>
</div>
