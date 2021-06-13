<div class="modal fade" id="modal-sub_activity" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Site Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/download-pdf" method="POST" target="_blank">@csrf
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                </div>
                <input type="hidden" name="sam_id" id="sam_id">
                <input type="hidden" name="sub_activity_id" id="sub_activity_id">
                {{-- <textarea name="template" id="template" class="d-none" cols="30" rows="10"></textarea> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                    <button type="submit" class="btn btn btn-success print_to_pdf">Print to PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
