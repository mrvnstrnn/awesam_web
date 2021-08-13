<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style> 

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                        <h5 class="menu-header-title">
                                            {{-- {{ $site_name }} --}}
                                            PR Memo
                                        </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 align-right">
                                    @php
                                        $json = json_decode($pr_memo->value, true);
                                    @endphp
                                    
                                    <form class="d-none" action="/export/line-items/{{ $json['generated_pr_memo'] }}" method="GET" target="_blank">
                                        <button class="btn btn-sm btn-shadow btn-success pull-right my-3 export_all_line_tems" type="submit">Export Line Items</button>
                                    </form>
                                    <ul class="tabs-animated body-tabs-animated nav mb-4">
                                        <li class="nav-item {{ $activity == "Set Ariba PR Number to Sites" ? 'd-none' : '' }}">
                                            <a role="tab" class="nav-link active" id="tab-action-details" data-toggle="tab" href="#tab-content-action-details">
                                                <span>Details</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $activity == "Set Ariba PR Number to Sites" ? 'd-none' : '' }}">
                                            <a role="tab" class="nav-link" id="tab-sites" data-toggle="tab" href="#tab-content-sites">
                                                <span>Sites</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $activity == "Set Ariba PR Number to Sites" ? 'd-none' : '' }}">
                                            <a role="tab" class="nav-link" id="tab-sites" data-toggle="tab" href="#tab-content-pdf">
                                                <span>Preview</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ $activity == "Set Ariba PR Number to Sites" ? 'd-none' : '' }}">
                                            <a role="tab" class="nav-link" id="tab-approvals" data-toggle="tab" href="#tab-content-approvals">
                                                <span>Approvals</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <form id="create_pr_form">
                                        @if ($activity == "Set Ariba PR Number to Sites")
                                        <div class="preview_div my-5">
                                            <div class="text-center">
                                                <i class="fa fa-file-pdf display-1"></i><br>
                                                <small>{{ $json['file_name'] }}</small>
                                            </div>
                                            <p>
                                                Note: Are you submitting this approved PR Memo to Arriba to get a PR Number? If yes you can click on the Download button to get the PDF file.
    
                                                If you want to view the details of this approved PR Memo or you already have a PR Number click on the Details button.
                                            </p>
                                        </div>
                                        {{-- <div class="text-center my-5">
                                            <a target="_blank" href="/files/{{ $json['file_name'] }}" download="{{ $json['file_name'] }}">
                                                <i class="fa fa-file display-1"></i>
                                                <H5>Download PDF</H5>
                                            </a>
                                            <small>{{ $json['file_name'] }}</small>
                                        </div> --}}

                                            <div class="form-group pr_number_area d-none">
                                                <label for="pr_number">PR #</label>
                                                <input type="text" name="pr_number" id="pr_number" class="form-control" {{ $activity == "Vendor Awarding of Sites" ? "disabled" : "" }} autofocus value="{{ $activity == 'Vendor Awarding of Sites' ? $sites_pr->site_pr : '' }}">
                                                <small class="pr_number-error text-danger"></small>
                                                {{-- <small>Note: Are you submitting this approved PR Memo to Arriba to get a PR Number? If yes you can click on the Download button to get the PDF file.

                                                    If you want to view the details of this approved PR Memo or you already have a PR Number click on the Details button.</small> --}}
                                            </div>
                                        @elseif ($activity == "Vendor Awarding of Sites")
                                            @php
                                                $sites_pr = \DB::connection('mysql2')->table('site')->select('site_pr')->where('sam_id', $pr_memo->sam_id)->first();
                                            @endphp
                                            <div class="form-row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="pr_number">PR #</label>
                                                        <input type="text" name="pr_number" id="pr_number" class="form-control" {{ $activity == "Vendor Awarding of Sites" ? "disabled" : "" }} value="{{ $activity == 'Vendor Awarding of Sites' ? $sites_pr->site_pr : '' }}">
                                                        <small class="pr_number-error text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="po_number">PO #</label>
                                                        <input type="text" name="po_number" id="po_number" autofocus class="form-control">
                                                        <small class="po_number-error text-danger"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="tab-content">
                                            <div class="tab-pane tabs-animation fade active show" id="tab-content-action-details" role="tabpanel">

                                                {{-- <form> --}}
                                                <div class="form_details_pr {{ $activity == "Set Ariba PR Number to Sites" ? 'd-none' : '' }}">
                                                    @php
                                                        $pr_sam_id = collect();
                                                        $vendor = \App\Models\Vendor::where("vendor_id", $json['vendor'])->first();
                                                        $generated_pr_memos = \App\Models\PrMemoSite::join('site', 'site.sam_id', 'pr_memo_site.sam_id')->where("pr_memo_site.pr_memo_id", $json['generated_pr_memo'])->get();
                                                    @endphp
                                                    <div class="form-row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="vendor">Vendor</label>
                                                                <input type="text" class="form-control" data-id="{{ $json['vendor'] }}" name="vendor" id="vendor" readonly value="{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="form-row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="to">To</label>
                                                                <input type="text" class="form-control" name="to" id="to" readonly value="{{ $json['to'] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="thru">Thru</label>
                                                                <input type="text" class="form-control" name="thru" id="thru" readonly value="{{ $json['thru'] }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="date_created">Date Created</label>
                                                                <input type="text" class="form-control" name="date_created" id="date_created" readonly value="{{ $json['date_created'] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="from">From</label>
                                                                <input type="text" class="form-control" name="from" id="from" readonly value="{{ $json['from'] }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="group">Group</label>
                                                                <input type="text" class="form-control" name="group" id="group" readonly value="{{ $json['group'] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="division">Division</label>
                                                                <input type="text" class="form-control" name="division" id="division" readonly value="{{ $json['division'] }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="department">Department</label>
                                                                <input type="text" class="form-control" name="department" id="department" readonly value="{{ $json['department'] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class=" col-12">
                                                            <div class="form-group">
                                                                <label for="subject">Subject</label>
                                                                <input type="text" class="form-control" name="subject" id="subject" readonly value="{{ $json['subject'] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="requested_amount">Requested Amount</label>
                                                                <input type="text" class="form-control" name="requested_amount" id="requested_amount" readonly value="{{ number_format($json['requested_amount'], 2) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="budget_source">Budget Source</label>
                                                                <input type="text" class="form-control" name="budget_source" id="budget_source" readonly value="{{ $json['budget_source'] }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="form-row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="recommendation">Recommendation</label>
                                                                <textarea style="resize: vertical;" type="text" cols="50" rows="5" class="form-control" name="recommendation" id="recommendation" readonly>{{ $json['recommendation'] }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- </form> --}}
                                            </div>
                                            <div class="tab-pane tabs-animation fade" id="tab-content-sites" role="tabpanel">
                                                
                                                <div class="line_items_area" class="d-none"></div>
                                                    {{-- <button class="btn btn-sm btn-shadow btn-success pull-right my-3 export_button" type="button">Export Line Items</button> --}}
                                                <div class="table-responsive pr_memo_site_table">
                                                    <table class="table table-hover pr_memo_site">
                                                        <thead>
                                                            <tr>
                                                                <th>SAM ID</th>
                                                                <th>Site Name</th>
                                                                <th>Site Address</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($generated_pr_memos as $generated_pr_memo)
                                                            @php
                                                                $pr_sam_id->push($generated_pr_memo->sam_id);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $generated_pr_memo->sam_id }}</td>
                                                                <td>{{ $generated_pr_memo->site_name }}</td>
                                                                <td>{{ $generated_pr_memo->site_address }}</td>
                                                                <td><button class="btn btn-sm btn-shadow btn-primary view-line-items" type="button" data-sam_id='{{ $generated_pr_memo->sam_id }}'>View line items</button></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane tabs-animation fade" id="tab-content-pdf" role="tabpanel">
                                                {{-- <form id="create_pr_form"> --}}
                                                    {{-- @if ($activity == "Set Ariba PR Number to Sites")
                                                        <div class="form-group">
                                                            <label for="pr_number">PR #</label>
                                                            <input type="text" name="pr_number" id="pr_number" class="form-control" {{ $activity == "Vendor Awarding of Sites" ? "disabled" : "" }}>
                                                            <small class="pr_number-error text-danger"></small>
                                                        </div>
                                        
                                                    @endif --}}
                                        
                                                    {{-- <div class="form-group">
                                                        <label for="vendor">Vendor</label>
                                                        @php
                                                            $vendor_name = \App\Models\Vendor::where('vendor_id', $json['vendor'])->first();
                                                        @endphp
                                                        <input type="text" name="vendor" id="vendor" class="form-control" value="{{ $vendor_name->vendor_sec_reg_name }} ({{ $vendor_name->vendor_acronym }})" readonly>
                                                    </div> --}}
                                                    
                                                    <div class="form-group">
                                                        <label for="pr_file">PR Memo File</label>
                                                        <iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/pdf/{{ $json['file_name'] }}" allowfullscreen></iframe>
                                                    </div>

                                                    <div class="my-3">
                                                        <a href="/files/{{ $json['file_name'] }}" download="{{ $json['file_name'] }}" target="_blank" class="btn btn-danger btn-shadow btn-sm"><i class="fas fa-lg fa-file-pdf mr-1"></i> Download PR Memo</a> <button type="button" class="btn btn-success btn-shadow btn-sm export_button"><i class="fas fa-lg fa-file-excel mr-1"></i> Download Line Items</button> 
                                                    </div>
                                                    
                                                {{-- </form> --}}
                                            </div>
                                            <div class="tab-pane tabs-animation fade" id="tab-content-approvals" role="tabpanel">
                                                <div class="table-responsive">
                                                    <table class="table table-hovered pr_approval">
                                                        @php
                                                            // print_r($pr_sam_id->all());
                                                            $approval_sites = \App\Models\SubActivityValue::whereIn('sam_id', $pr_sam_id->all())
                                                                                                                ->whereIn('type', ['create_pr'])
                                                                                                                ->get();
                                                        @endphp
                                                        <thead>
                                                            <tr>
                                                                <th>SAM ID</th>
                                                                <th>Type</th>
                                                                <th>Created By</th>
                                                                <th>Date Created</th>
                                                                <th>Date Approved</th>
                                                                <th>Approver</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($approval_sites as $approval_site)
                                                            @php
                                                                $creator = \App\Models\User::select('name')->where('id', $approval_site->user_id)->first();
                                                                $approver = \App\Models\User::select('name')->where('id', $approval_site->approver_id)->first();
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $approval_site->sam_id }}</td>
                                                                <td>{{ $approval_site->type }}</td>
                                                                <td>{{ $creator->name }}</td>
                                                                <td>{{ $approval_site->date_created }}</td>
                                                                <td>{{ is_null($approval_site) ? "Not yet approved." : $approval_site->date_approved }}</td>
                                                                <td>{{ is_null($approver) ? "Not yet approved." : $approver->name }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <hr>
                                        
                                        @if ($activity == "Set Ariba PR Number to Sites")
                                            <button type="button" class="float-right btn btn-shadow btn-success ml-1 d-none approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $pr_memo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Set PR Number</button>
                                            <button type="button" class="float-right btn btn-shadow btn-primary ml-1 form_details">PR Memo Details</button>

                                            <a href="/files/{{ $json['file_name'] }}" download="{{ $json['file_name'] }}" class="float-right btn btn-shadow btn-warning ml-1">Download PDF</a>
                                        @elseif ($activity == "Vendor Awarding of Sites")
                                            <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr my-3" id="approve_pr" data-data_action="true" data-id="{{ $pr_memo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Award to vendor</button>
                                        @else
                                            @if (\Auth::user()->profile_id == 10)
                                                <button type="button" class="float-right btn btn-shadow btn-success ml-1" data-toggle="modal" data-target="#recommendationModal">Approve PR</button>

                                                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr d-none my-3" id="approve_pr" data-data_action="true" data-id="{{ $pr_memo->id }}" data-sam_id="{{ $samid }}" data-pr_memo="{{ $json['generated_pr_memo'] }}" data-activity_name="{{ $activity }}">Approve PR</button>
                                            @else

                                                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr my-3" id="approve_pr" data-data_action="true" data-id="{{ $pr_memo->id }}" data-sam_id="{{ $samid }}" data-pr_memo="{{ $json['generated_pr_memo'] }}" data-activity_name="{{ $activity }}">Approve PR</button>
                                            @endif

                                            <button type="button" class="float-right btn btn-shadow btn-danger ml-1 reject_pr">Reject PR</button>
                                        @endif

                                    </form>
                                        
                                    <div class="row reject_remarks d-none">
                                        <div class="col-12">
                                            <p class="message_p">Are you sure you want to reject PR Memo?</p>
                                            <form class="reject_form">
                                                <div class="form-group">
                                                    <label for="remarks">Remarks:</label>
                                                    <textarea style="width: 100%;" name="remarks" id="remarks" rows="5" cols="100" class="form-control"></textarea>
                                                    <small class="text-danger remarks-error"></small>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-sm btn-shadow confirm_reject" id="reject_pr" data-data_action="false" data-id="{{ $pr_memo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}" data-pr_memo="{{ $json['generated_pr_memo'] }}">Reject PR</button>
                                                    
                                                    <button class="btn btn-secondary btn-sm btn-shadow cancel_reject">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(".pr_memo_site").DataTable();
    $(".pr_approval").DataTable();

    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });

    $(".export_button").on("click", function(){
        $(".export_all_line_tems").trigger("click");
    });
    

    $(".form_details").on("click", function(e){
        
        e.preventDefault();
        document.getElementById("pr_number").focus();

        $(".pr_number_area").removeClass("d-none");
        $(".form_details_pr").removeClass("d-none");
        $(".approve_reject_pr").removeClass("d-none");

        $(".form_details").addClass("d-none");

        $(".preview_div").addClass("d-none");
    });

    $(document).on("click", ".recommend, .no_thanks", function(e){
        $(".approve_reject_pr[data-data_action=true]").trigger("click");
    });
    
    $(".approve_reject_pr, .confirm_reject").on("click", function(e){
        e.preventDefault();

        var data_action = $(this).attr('data-data_action');
        var activity_name = $(this).attr('data-activity_name');
        var id = $(this).attr('data-id');
        var pr_memo = $(this).attr('data-pr_memo');

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var button_id = data_action == "false" ? "reject_pr" : "approve_pr";
        
        var sam_id = $(this).attr('data-sam_id');

        var remarks = $("#remarks").val();

        if (activity_name == "Set Ariba PR Number to Sites") {
            var url = "/accept-reject-endorsement";
            
            $("#create_pr_form small").text("");
            var sam_id = [sam_id];
            var pr_number = $("#pr_number").val();

            var button_text = "Set PR Number";

            data = {
                sam_id : sam_id,
                activity_name : activity_name,
                data_action : data_action,
                pr_number : pr_number
            }
        } else if (activity_name == "Vendor Awarding of Sites") {
            var url = "/vendor-awarding-sites";
            
            $("#create_pr_form small").text("");
            var sam_id = sam_id;
            var vendor = $("#vendor").val();
            var po_number = $("#po_number").val();

            var button_text = "Award to vendor";

            data = {
                sam_id : sam_id,
                activity_name : activity_name,
                data_action : data_action,
                po_number : po_number
                // vendor : vendor
            }
        } else {
            $(".reject_form small").text("");
            var recommendation_site = $("#recommendation_site").val();
            var button_text = data_action == "false" ? "Reject PR" : "Approve PR";
            url = "/approve-reject-pr-memo";
            data = {
                sam_id : sam_id,
                activity_name : activity_name,
                data_action : data_action,
                id : id,
                remarks : remarks,
                pr_memo : pr_memo,
                recommendation_site : recommendation_site
            }
        }

        $.ajax({
        url: url,
            data: data,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                        $("#viewInfoModal").modal("hide");
                        $("#recommendationModal").modal("hide");
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".reject_form")[0].reset();

                        $("#"+button_id).removeAttr("disabled");
                        $("#"+button_id).text(button_text);
                    });
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".reject_form ." + index + "-error").text(data);
                            $("#create_pr_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    
                    $("#"+button_id).removeAttr("disabled");
                    $("#"+button_id).text(button_text);
                }
            },
            error: function(resp){
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $("#"+button_id).removeAttr("disabled");
                $("#"+button_id).text(button_text);
            }
        });

    });

    $(".reject_pr").on("click", function(e){
        e.preventDefault();
        $("#create_pr_form").addClass("d-none");
        $(".reject_remarks").removeClass("d-none");
    });

    $(".cancel_reject").on("click", function(e){
        e.preventDefault();
        $("#create_pr_form").removeClass("d-none");
        $(".reject_remarks").addClass   ("d-none");

    });

    $(".view-line-items").on("click", function (e){
        e.preventDefault();

        var sam_id = $(this).attr('data-sam_id');
        
        var vendor = $("#vendor").attr('data-id');

        $("#viewInfoModal .line_items_area").removeClass("d-none");
        $("#viewInfoModal .pr_memo_site_table").addClass("d-none");

        $(".line_items_area div").remove();

        $.ajax({
            url: "/get-line-items/" + sam_id + "/" +vendor,
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".line_items_area").append(
                                '<div><label><b>'+index+'</b></label></div>'
                            );

                            $.each(data, function(i, checkbox_data) {
                                $(".line_items_area").append(
                                    '<div class="col-md-6 col-12">' +
                                    '<div class="form-group">' +
                                    '<input type="checkbox" data-text="'+ $("#viewInfoModal .menu-header-title").text() +'" disabled="disabled" value="'+checkbox_data.fsa_id+'" name="line_item" id="line_item'+checkbox_data.fsa_id+'"> <label for="line_item'+checkbox_data.fsa_id+'">' + checkbox_data.item +
                                    '</label></div></div>'
                                );
                            });
                        });


                        resp.site_items.forEach(element => {
                            $("input[value='" + element.fsa_id + "']").prop('checked', true);
                        });

                        $(".line_items_area").append(
                            // '<div><form action="/export/line-items/'+sam_id+'" method="GET" target="_blank"><button type="button" class="btn btn-shadow btn-sm btn-secondary cancel_line_items">Back to site list</button> <button type="submit" class="btn btn-shadow btn-sm btn-success" type="submit">Export Line Items</button></form></div>'
                            '<div><button type="button" class="btn btn-shadow btn-sm btn-secondary cancel_line_items">Back to site list</button></div>'
                        );

                        $("#viewInfoModal .menu-header-title").text(sam_id);
                    }
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });        
    });

    $(document).on("click", ".cancel_line_items", function(e){
        e.preventDefault();
        
        $("#viewInfoModal .menu-header-title").text( "PR Memo" );
        $("#viewInfoModal .line_items_area").addClass("d-none");
        $("#viewInfoModal .pr_memo_site_table").removeClass("d-none");
    });
    

</script>