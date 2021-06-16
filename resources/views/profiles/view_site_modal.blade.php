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

<div class="modal fade" id="modal_issue" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="view_issue_form mb-2">
                        <input type="hidden" name="issue_id">
                        <div class="form-row mb-1">
                            <div class="col-4">
                                <label for="issue_type" class="mr-sm-2">Issue Type</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="issue_type" id="issue_type" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-row mb-1">
                            <div class="col-4">
                                <label for="issue" class="mr-sm-2">Issue</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="issue" id="issue" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-row mb-1">
                            <div class="col-4">
                                <label for="start_date" class="mr-sm-2">Issue Started</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="start_date" id="start_date" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-row mb-1">
                            <div class="col-4">
                                <label for="issue_details" class="mr-sm-2">Issue Details</label>
                            </div>
                            <div class="col-8">
                                <textarea name="issue_details" id="issue_details" cols="30" rows="10" class="form-control" disabled></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary cancel_issue">Cancel Issue</button>
            </div>
        </div>
    </div>
</div>
