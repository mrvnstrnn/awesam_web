<form class="w-100" id="form-upload" enctype="multipart/form-data">@csrf
    {{-- <div class="position-relative form-group mb-2 px-2">
        <label for="doc_upload" class="doc_upload_label">labeler</label>
        <div class="input-group">
            <input type="file" name="doc_upload" id="doc_upload" class="p-1 form-control">
        </div>
    </div> --}}
    <div class="list-uploaded"></div>
    <hr class="hr-border">
    <div class="dropzone"></div>
    <input type="hidden" name="sam_id" id="sam_id">
    <input type="hidden" name="sub_activity_id" id="sub_activity_id">
    <input type="hidden" name="file_name" id="file_name">
    <div class="position-relative form-group w-100 mb-0 mt-3">
        <button type="button" class="btn btn-sm btn-primary float-right upload_file">Upload</button>
        <button type="button" class="cancel_uploader btn btn-sm btn-outline-danger float-right mr-1" data-dismiss="modal" aria-label="Close">
            Cancel
        </button>
    </div>
</form>
