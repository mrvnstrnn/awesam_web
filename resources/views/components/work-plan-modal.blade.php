<div id="action_lessor_engagement" class="">
    <div class="row">
        <div class="col-12">
            <H5 class="pb-2">Planned Engagement Type</H5>
        </div>
    </div>
    <div class="row py-3 px-0" id="control_box_log">
        <div class="col my-1 text-center" data-value="Call">
            <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Call</small></div>
        </div>
        <div class="col my-1 text-center" data-value="Text">
            <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Text</small></div>
        </div>
        <div class="col my-1 text-center" data-value="Email">
            <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Email</small></div>
        </div>
        <div class="col my-1 text-center" data-value="Site Visit">
            <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Site Visit</small></div>

        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <div class="col-12">
            <H5 class="pb-2">Planned Engagement Details</H5>
        </div>
    </div>
    <div class="row py-3 px-0" id="control_form_log">
        <div class="col-12 py-3">

        <form class="engagement_form">
            <div class="position-relative row form-group">
                <label for="lessor_method_log" class="col-sm-3 col-form-label">Method</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="lessor_method_log" name="lessor_method_log" readonly="">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_date_log" class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-9">
                    <input type="text" id="lessor_date_log" name="lessor_date_log" class="form-control flatpicker flatpickr-input" readonly="readonly">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_remarks_log" class="col-sm-3 col-form-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="lessor_remarks_log" id="lessor_remarks_log" class="form-control"></textarea>
                    <small class="text-danger lessor_remarks-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group d-none">
                <label for="lessor_approval_log" class="col-sm-3 col-form-label">Approval</label>
                <div class="col-sm-9">
                    <select name="lessor_approval_log" id="lessor_approval_log" class="form-control">
                        <option value="engagement" selected="">Approval not yet secured</option>
                        <option value="active">Approval not yet secured</option>
                        <option value="approved">Approval Secured</option>
                        <option value="denied">Rejected</option>
                    </select>
                    <small class="text-danger lessor_approval-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group ">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 offset-sm-3 text-right">
                    <button class="btn btn-secondary cancel_engagement_log" type="button">Back to Engagement</button>
                    <button class="btn btn-primary save_engagement_log" data-log="true" type="button">Save Engagement</button>
                </div>
            </div>
        </form>
        </div>

    </div>
</div>                                
