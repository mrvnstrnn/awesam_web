<form class="w-100" id="form-upload" enctype="multipart/form-data">@csrf
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
