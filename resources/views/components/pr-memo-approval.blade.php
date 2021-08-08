<div class="row mb-3">
    <div class="col-12 align-right">
        @php
            $json = json_decode($prmemo->value, true);
        @endphp
        <ul class="tabs-animated body-tabs-animated nav mb-4">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-action-details" data-toggle="tab" href="#tab-content-action-details">
                    <span>Details</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-sites" data-toggle="tab" href="#tab-content-sites">
                    <span>Sites</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-sites" data-toggle="tab" href="#tab-content-pdf">
                    <span>PDF</span>
                </a>
            </li>
        </ul>

        <form id="create_pr_form">
            @if ($activity == "Set Ariba PR Number to Sites")
                <div class="form-group">
                    <label for="pr_number">PR #</label>
                    <input type="text" name="pr_number" id="pr_number" class="form-control" {{ $activity == "Vendor Awarding of Sites" ? "disabled" : "" }} value="{{ $activity == 'Vendor Awarding of Sites' ? $sites_pr->site_pr : '' }}">
                    <small class="pr_number-error text-danger"></small>
                </div>
            @elseif ($activity == "Vendor Awarding of Sites")
                @php
                    $sites_pr = \DB::connection('mysql2')->table('site')->select('site_pr')->where('sam_id', $prmemo->sam_id)->first();
                @endphp
                <div class="form-group">
                    <label for="pr_number">PR #</label>
                    <input type="text" name="pr_number" id="pr_number" class="form-control" {{ $activity == "Vendor Awarding of Sites" ? "disabled" : "" }} value="{{ $activity == 'Vendor Awarding of Sites' ? $sites_pr->site_pr : '' }}">
                    <small class="pr_number-error text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="po_number">PO #</label>
                    <input type="text" name="po_number" id="po_number" class="form-control">
                    <small class="po_number-error text-danger"></small>
                </div>
            @endif
            <div class="tab-content">
                <div class="tab-pane tabs-animation fade active show" id="tab-content-action-details" role="tabpanel">

                    {{-- <form> --}}
                        @php
                            $vendor = \App\Models\Vendor::where("vendor_id", $json['vendor'])->first();
                            $generated_pr_memos = \App\Models\PrMemoSite::join('site', 'site.sam_id', 'pr_memo_site.sam_id')->where("pr_memo_site.pr_memo_id", $json['generated_pr_memo'])->get();
                        @endphp
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="vendor">Vendor</label>
                                    <input type="text" class="form-control" name="vendor" id="vendor" readonly value="{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})">
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
                    {{-- </form> --}}
                </div>
                <div class="tab-pane tabs-animation fade" id="tab-content-sites" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover pr_memo_site">
                            <thead>
                                <tr>
                                    <th>SAM ID</th>
                                    <th>Site Name</th>
                                    <th>Site Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($generated_pr_memos as $generated_pr_memo)
                                <tr>
                                    <td>{{ $generated_pr_memo->sam_id }}</td>
                                    <td>{{ $generated_pr_memo->site_name }}</td>
                                    <td>{{ $generated_pr_memo->site_address }}</td>
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
                        
                    {{-- </form> --}}
                </div>
                
                
            </div>
            
            @if ($activity == "Set Ariba PR Number to Sites")
                
                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Set PR</button>
            @elseif ($activity == "Vendor Awarding of Sites")
            
                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Award to vendor</button>
            @else
                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-pr_memo="{{ $json['generated_pr_memo'] }}" data-activity_name="{{ $activity }}">Approve PR</button>

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
                        <button class="btn btn-primary btn-sm btn-shadow confirm_reject" id="reject_pr" data-data_action="false" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}" data-pr_memo="{{ $json['generated_pr_memo'] }}">Reject PR</button>
                        
                        <button class="btn btn-secondary btn-sm btn-shadow cancel_reject">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    
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

            var button_text = "Set PR";

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
            var button_text = data_action == "false" ? "Reject PR" : "Approve PR";
            url = "/approve-reject-pr-memo";
            data = {
                sam_id : sam_id,
                activity_name : activity_name,
                data_action : data_action,
                id : id,
                remarks : remarks,
                pr_memo : pr_memo
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

    $(".pr_memo_site").DataTable();
    

</script>