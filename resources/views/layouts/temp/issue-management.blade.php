@extends('layouts.main')

@section('content')

    <style>
        .modal-dialog{
            -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
            -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
            -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
            box-shadow: 0 5px 15px rgba(0,0,0,0);
        }   
    </style>  

    {{-- <x-assigned-sites mode="vendor"/> --}}
    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Issue Management" activitytype="all-site-issues"/>
    {{-- <x-issue-validation-datatable ajaxdatatablesource="site-milestones" tableheader="Issue Validation" activitytype="all"/> --}}

@endsection


@section('modals')

    <x-milestone-modal />

    <div class="modal fade" id="viewIssueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card ">
    
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <h5 class="menu-header-title">
                                            Issue Validation
                                        </h5>
                                    </div>
                                </div>
                            </div> 
                            <div class="modal-body">
                                <div class="issue_details_div">
                                    <H5 class="mb-3">Issue Details</H5>
                                    <form class="update_issue_form mb-2">
                                        <input type="hidden" name="hidden_issue_id" id="hidden_issue_id">
                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="issue_type" class="mr-sm-2">Issue Type</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="issue_type" id="issue_type" class="form-control" readonly>
                                                <small class="text-danger issue_type-error"></small>
                                            </div>
                                        </div>
                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="issue" class="mr-sm-2">Issue</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="issue" id="issue" class="form-control" readonly>
                                                <small class="text-danger issue-error"></small>
                                            </div>
                                        </div>
                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="issue" class="mr-sm-2">Final Issue / Callout</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="issue_callout" id="issue_callout" class="form-control" readonly>
                                                <small class="text-danger issue-error"></small>
                                            </div>
                                        </div>


                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="start_date" class="mr-sm-2">Issue Started</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="start_date" id="start_date" class="form-control flatpicker" readonly>
                                                <small class="text-danger start_date-error"></small>
                                            </div>
                                        </div>

                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="issue_details" class="mr-sm-2">Issue Details</label>
                                            </div>
                                            <div class="col-8">
                                                <textarea name="issue_details" id="issue_details" cols="30" rows="5" class="form-control"></textarea>
                                                <small class="text-danger issue_details-error"></small>
                                            </div>
                                        </div>
                                        {{-- <div class="form-row mb-1">
                                            <div class="col-12">
                                                <hr>    
                                                <button class="mt-1 btn btn-primary float-right resolve_issue" type="button">Resolve Issue</button>
                                                <button type="button" class="mt-1 btn btn-outline-danger mr-1 float-right" data-dismiss="modal">Close</button>
                                            </div>
                                        </div> --}}
                                    </form>
                                    <hr>
                                    <H5 class="mb-4">Issue History</H5>
                                    <div class="table_div"></div>
                                    <div class="row">
                                        <div class="col-12 text-right border-top pt-3">
                                            {{-- <button type="button" class="mt-1 btn btn-outline-danger mr-1" data-dismiss="modal">Close</button> --}}
                                            @if(\Auth::user()->profile_id == 3 || \Auth::user()->profile_id == 28 || \Auth::user()->profile_id == 8)
                                                <button class="btn btn-success btn-lg resolve_issue" type="button">Resolve Issue</button>
                                            @endif
                                            <button class="btn btn-shadow btn-lg btn-primary add_update" type="button">Add Update</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="add_remarks_issue_form d-none">
                                    <H5 class="mb-3">Add Issue Update</H5>
                                    <form class="mb-2 remarks_issue_form">
                                        <input type="hidden" name="site_issue_id" id="site_issue_id">
                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="status" class="mr-sm-2">Status</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="active">Active</option>
                                                    <option value="resolved">Resolved</option>
                                                    <option value="cancelled">Cancel</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="remarks" class="mr-sm-2">Remarks</label>
                                            </div>
                                            <div class="col-8">
                                                <textarea type="text" class="form-control" name="remarks" id="remarks"></textarea>
                                                <small class="text-danger remarks-errors"></small>
                                            </div>
                                        </div>
                            
                                        <div class="form-row mb-1">
                                            <div class="col-4">
                                                <label for="date_engage" class="mr-sm-2">Date of Update</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control" name="date_engage" id="date_engage" readonly>
                                                <small class="text-danger date_engage-errors"></small>
                                            </div>
                                        </div>
                        
                                        <div class="row">
                                            <div class="col-12 text-right border-top pt-3 mt-3">
                                                <button class="btn btn-lg btn-secondary btn_cancel_remarks  mr-2" type="button">Cancel</button>
                                                <button class="btn btn-lg btn-primary add_btn_remarks_submit " type="button">Save Update</button>
                                            </div>
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

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 10;
    var table_to_load = 'issue_management';
    var main_activity = "Issue Validation";
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>

<script type="text/javascript" src="/js/modal-issue-validation.js"></script>  

<script>

    $(document).ready(function () {
        $(document).on("click", ".add_update", function(){
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            $("#date_engage").val(today);

            $(".add_remarks_issue_form").removeClass("d-none");
            $(".issue_details_div").addClass("d-none");
        });

        $(document).on("click", ".btn_cancel_remarks", function(){
            $(".add_remarks_issue_form").addClass("d-none");
            $(".issue_details_div").removeClass("d-none");
        });

        $(".add_btn_remarks_submit").on("click", function(){

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var site_issue_id = $("#site_issue_id").val();

            $(".add_remarks_issue_form small").text();

            $.ajax({
                url: "/add-remarks",
                method: "POST",
                data: $(".remarks_issue_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if (!resp.error) {
                        $("#table_issue_child_"+site_issue_id).DataTable().ajax.reload(function(){
                            $(".remarks_issue_form")[0].reset();
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $(".add_btn_remarks_submit").removeAttr("disabled");
                            $(".add_btn_remarks_submit").text("Add Update");

                            $(".btn_cancel_remarks").trigger("click");
                        });

                        $(".my_table_issue").DataTable().ajax.reload();
                        
                    } else {
                        
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                console.log(index);
                                $(".add_remarks_issue_form ." + index + "-errors").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".add_btn_remarks_submit").removeAttr("disabled");
                        $(".add_btn_remarks_submit").text("Add Update");
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp,
                        'success'
                    )

                    $(".add_btn_remarks_submit").removeAttr("disabled");
                    $(".add_btn_remarks_submit").text("Add Update");
                }
            });
        });
    })
</script>

@endsection