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
    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Issue Validation" activitytype="all-site-issues"/>
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
                                    </form>
                                    <div class="row">
                                        <div class="col-12 text-right border-top pt-3 mt-3">
                                            <button class="btn btn-shadow btn-lg btn-primary pull-right accept_issue" type="button">Accept Issue</button>
                                            <button class="btn btn-shadow btn-lg mr-2 btn-danger pull-right reject_issue" type="button">Reject Issue</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row reject_remarks d-none">
                                    <div class="col-12">
                                        <p class="message_p">Are you sure you want to reject this issue?</p>
                                        <form class="reject_form">
                                            <div class="form-group">
                                                <label for="remarks">Remarks:</label>
                                                <textarea style="width: 100%;" name="remarks" id="remarks" rows="5" cols="100" class="form-control"></textarea>
                                                <small class="text-danger remarks-error"></small>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-sm btn-shadow confirm_reject" type="button">Confirm</button>
                                                
                                                <button class="btn btn-secondary btn-sm btn-shadow cancel_reject" type="button">Cancel</button>
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

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 10;
    var table_to_load = 'issue_validation';
    var main_activity = "Issue Validation";
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>

<script type="text/javascript" src="/js/modal-issue-validation.js"></script>  

<script>

    $(document).ready(function () {
        $("#btn_add_remarks").on("click", function(){
            $(".add_remarks_issue_form").removeClass("d-none");
            $(".issue_details_div").addClass("d-none");
        });

        $(".btn_cancel_remarks").on("click", function(){
            $(".add_remarks_issue_form").addClass("d-none");
            $(".issue_details_div").removeClass("d-none");
        });

        $(".accept_issue").on("click", function(){
            Swal.fire(
                'Success',
                "Successfully accepted issue.",
                'success'
            )

            $("#viewIssueModal").modal("hide");
        });

        $(".reject_issue").on("click", function(){
            $(".issue_details_div").addClass("d-none");
            $(".reject_remarks").removeClass("d-none");
        });

        $(".cancel_reject").on("click", function(){
            $(".issue_details_div").removeClass("d-none");
            $(".reject_remarks").addClass("d-none");
        });

        $(".confirm_reject").on("click", function(){
            Swal.fire(
                'Success',
                "Successfully rejected issue.",
                'success'
            )

            $("#viewIssueModal").modal("hide");
        });
    });
    
</script>

@endsection