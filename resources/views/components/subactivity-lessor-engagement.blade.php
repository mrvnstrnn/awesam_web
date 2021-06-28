<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div id="action_lessor_engagement" class=''>
    <div class="row py-5 px-4" id="control_box">
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Call">
            <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Call</small></div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Text">
            <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Text</small></div>
        </div>
        <div class="col-md-3 col-sm-6 my-3 text-center contact-lessor" data-value="Email">
            <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Email</small></div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Site Visit">
            <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Site Visit</small></div>

        </div>
    </div>
    <div class="row py-3 px-5 d-none" id="control_form">
        <div class="col-12 py-3">
        <form class="">
            <div class="position-relative row form-group">
                <label for="lessor_date" class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-9">
                    <input type="text" id="lessor_date" name="lessor_date" class="form-control" readonly>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_method" class="col-sm-3 col-form-label">Method</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="lessor_method" name="lessor_method" readonly>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_remarks" class="col-sm-3 col-form-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="lessor_remarks" id="lessor_remarks" class="form-control"></textarea>
                    <small class="text-danger lessor_remarks-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lesor_approval" class="col-sm-3 col-form-label">Approval</label>
                <div class="col-sm-9">
                    <select name="lessor_approval" id="lessor_approval" class="form-control">
                        <option value="active">Approval not yet secured</option>
                        <option value="approved">Approval Secured</option>
                        <option value="denied">Lessor Rejected</option>
                    </select>
                    <small class="text-danger lessor_approval-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group ">
                <div class="col-sm-10 offset-sm-3">
                    <button class="btn btn-secondary save_engagement" type="button">Save Engagement</button>
                </div>
            </div>
        </form>
        </div>

    </div>
    <div class="row">
        <div class="col-12 table-responsive table_lessor_parent">
            {{-- <table class="table_lessor align-middle mb-0 table table-borderless table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Remarks</th>
                        <th>Approved</th>
                    </tr>
                </thead>
            </table> --}}
        </div>
    </div>
</div>


<script>
    
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

</script>