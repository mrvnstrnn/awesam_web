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
                                                Modal Title
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
                                                <textarea name="issue_details" id="issue_details" cols="30" rows="10" class="form-control"></textarea>
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
                                </div>
                                <hr>
                                <div class="table_div"></div>

                                <button class="mt-1 btn btn-primary float-right resolve_issue" type="button">Resolve Issue</button>
                                <button type="button" class="mt-1 btn btn-outline-danger mr-1 float-right" data-dismiss="modal">Close</button>
                            </div>
                            {{-- <div class="modal-footer">
                                <button class="mt-1 btn btn-primary float-right resolve_issue" type="button">Resolve Issue</button>
                                <button type="button" class="mt-1 btn btn-outline-danger mr-1 float-right" data-dismiss="modal">Close</button>
                            </div> --}}
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

@endsection