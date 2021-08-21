@php
    $user_locations = \DB::connection('mysql2')
                            ->table('local_coop_user_locations')
                            ->where('user_id', \Auth::id())
                            ->get();

    $my_locations = collect();

    foreach ($user_locations as $user_location) {
        $my_locations->push($user_location->region);
    }
    
    if (\Auth::user()->profile_id == 18 || \Auth::user()->profile_id == 25) {
        $coops = \DB::connection('mysql2')
                        ->table("local_coop")
                        ->orderBy('coop_name')
                        ->get();
    } else {
        $coops = \DB::connection('mysql2')
                        ->table("local_coop")
                        ->whereIn('region', $my_locations->all())
                        ->orderBy('coop_name')
                        ->get();
    }
        
@endphp

<style>
    #issues_table tbody tr:hover {
        cursor: pointer;
        background-color: rgb(221, 221, 221);
    }
    .table_issues_child tbody tr td:nth-child(4), .table_history_child tbody tr td:nth-child(3), .table_engagements_child tbody tr td:nth-child(4) {
        overflow: hidden !important;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    label {
        text-transform: uppercase;
    }

    .table_issues_child thead th, .table_history_child thead th, .table_engagements_child thead th, .table_contact_child thead th {
        font-size: 11px !important;
    }
</style>


<div id="coop_details" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark">Coop Details</h5>
            <button type="button" class="close modal_close text-dark">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="mb-3 card mb-0" style="box-shadow: none;">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        @if (\Auth::user()->profile_id != 25)
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-details" class="nav-link active">Details</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-contacts" class="nav-link">Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-engagements" class="nav-link">Engagements</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-issues" class="nav-link">Issues</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane {{ \Auth::user()->profile_id != 25 ? "active" : "" }}" id="tab-coop-details" role="tabpanel">
                        </div>
                        <div class="tab-pane" id="tab-coop-contacts" role="tabpanel">
                            {{-- <table class="table" id="contacts_table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Staff</th>
                                        <th>Type</th>
                                        <th>Firstame</th>
                                        <th>Lastame</th>
                                        <th>Cellphone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> --}}

                            <div class="contact_div_edit d-none">
                                <form class="contact_form_update">
                                    <input type="hidden" name="action" id="action" value="contacts">
                                    <input type="hidden" name="ID" id="ID">
                                    <div class="position-relative row form-group d-none">
                                        <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                                        <div class="col-sm-9">
                                            <select name="coop" id="coop" class="form-control" readonly>
                                                <option value="">Select COOP</option>
                                                @foreach ($coops as $coop)
                                                    <option value="{{$coop->coop_name}}">{{ strtoupper($coop->coop_name)}}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger coop-error"></small>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="contact_type" class="col-sm-3 col-form-label">Contact Type</label>
                                        <div class="col-sm-9">
                                            <select id="contact_type" name="contact_type" class="form-control">
                                                <option value="">Select Contact Type</option>
                                                <option value="Accounting">Accounting</option>
                                                <option value="Area Engineer">Area Engineer</option>
                                                <option value="Engineering">Engineering</option>
                                                <option value="Exeutive Assistant to the GM">Exeutive Assistant to the GM</option>
                                                <option value="General Manager">General Manager</option>
                                                <option value="Secretary">Secretary</option>
                                            </select>
                                            <small class="text-danger contact_type-error"></small>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="firstname" class="col-sm-3 col-form-label">Firstname</label>
                                        <div class="col-sm-9">
                                            <input type="text" placeholder="Firstname" name="firstname" id="firstname" class="form-control" />
                                            <small class="text-danger firstname-error"></small>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="lastname" class="col-sm-3 col-form-label">Lastname</label>
                                        <div class="col-sm-9">
                                            <input type="text" placeholder="Lastname" name="lastname" id="lastname" class="form-control"/>
                                            <small class="text-danger lastname-error"></small>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="contact_number" class="col-sm-3 col-form-label">Cellphone</label>
                                        <div class="col-sm-9">
                                            <input type="text" placeholder="Cellphone" name="contact_number" id="contact_number" class="form-control"/>
                                            <small class="text-danger contact_number-error"></small>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" placeholder="Email" name="email" id="email" class="form-control"/>
                                            <small class="text-danger email-error"></small>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary btn-sm btn-shadow add_engagement" data-type="contacts" id="btn_update_contact">Update</button>
                                    <button type="button" class="btn btn-secondary btn-sm btn-shadow cancel_update">Cancel</button>
                                </form>
                            </div>
                            <div class="table-responsive table_contact_parent"></div>
                        </div>
                        <div class="tab-pane" id="tab-coop-engagements" role="tabpanel">
                            {{-- <table class="table" id="engagement_table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Staff</th>
                                        <th>Type</th>
                                        <th>Result</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> --}}

                            <div class="table-responsive table_engagements_parent"></div>
                            <form class="engagement_form_view d-none">
                                <div class="position-relative row form-group">
                                    <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="coop" id="coop" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="engagement_type" class="col-sm-3 col-form-label">Engagement Type</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="engagement_type" id="engagement_type" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="result_of_engagement" class="col-sm-3 col-form-label">Result of Engagement</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="result_of_engagement" id="result_of_engagement" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                    <div class="col-sm-9">
                                        <textarea name="remarks" id="remarks" class="form-control" disabled></textarea>
                                        <small class="text-danger remarks-error"></small>
                                    </div>
                                </div>

                                <button class="btn btn-secondary btn-sm back_to_engagement_list" type="button">Back to engagement list</button>
                            </form>
                        </div>
                        <div class="tab-pane {{ \Auth::user()->profile_id == 25 ? "active" : "" }}" id="tab-coop-issues" role="tabpanel">
                            <div id="issue_table_box">
                                {{-- <table class="table" id="issues_table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Staff</th>
                                            <th>Dependency</th>
                                            <th>Nature of Issue</th>
                                            <th>Description</th>
                                            <th>Status of Issue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table> --}}
                                
                                <div class="table-responsive table_issues_parent"></div>
                            </div>
                            
                            <form class="issue_form_view d-none">
                                <div class="position-relative row form-group">
                                    <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="coop" id="coop" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="dependency" class="col-sm-3 col-form-label">Dependency</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="dependency" id="dependency" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="nature_of_issue" class="col-sm-3 col-form-label">Nature of Issue </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nature_of_issue" id="nature_of_issue" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="issue" class="col-sm-3 col-form-label">Issue </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="issue" id="issue" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="description" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea name="description" id="description" class="form-control" disabled></textarea>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="issue_raised_by" class="col-sm-3 col-form-label">Issue Raised By</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="issue_raised_by" id="issue_raised_by" disabled>
                                    </div>
                                </div>
                    
                                <div class="position-relative row form-group">
                                    <label for="issue_raised_by_name" class="col-sm-3 col-form-label">Issue Raised By (Name)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="issue_raised_by_name" name="issue_raised_by_name" placeholder="Issue Raised By (Name)" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="date_of_issue" class="col-sm-3 col-form-label">Date of Issue</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control flatpicker" name="date_of_issue" id="date_of_issue" placeholder="Date of Issue" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="issue_assigned_to" class="col-sm-3 col-form-label">Issue Assigned To</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="issue_assigned_to" name="issue_assigned_to" placeholder="Issue Assigned To" disabled>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="status_of_issue" class="col-sm-3 col-form-label">Status of Issue</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="status_of_issue" id="status_of_issue" disabled>
                                    </div>
                                </div>
                            </form>
                            <div id="issue_history_box" class="d-none mt-5">
                                <div class="row border-bottom mb-3">
                                    <div class="col-sm-6">
                                        <H5>Issue History</H5>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-secondary mb-1" id="btn_back_to_issues" >Back to Issues</button>
                                        <button type="button" class="btn btn-primary mb-1" id="btn_add_issue" >Add History</button>
                                    </div>
                                </div>
                                <div class="table_history"></div>
                                <div class="table-responsive table_history_parent"></div>
                                {{-- <table class="table" id="issues_history">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Staff</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table> --}}
                            </div>
                            <div id="issue_add_box" class="d-none">
                                <div class="row border-bottom mb-3">
                                    <div class="col-sm-6">
                                        <H5>Add History</H5>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-secondary mb-1" id="btn_cancel_add_issues" >Cancel Add Issue</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form class="add_history_form">
                                            <input type="hidden" name="hidden_program_id" id="hidden_program_id">
                                            <input type="hidden" name="issue_id" id="issue_id">
                                            <input type="hidden" name="action" id="action" value="issue_history">
                                            {{-- <div class="form-group">
                                                <label for="date_history">Date History</label>
                                                <input type="date" name="date_history" id="date_history" class="form-control">
                                                <small class="date_history-error text-danger"></small>
                                            </div> --}}

                                            <div class="form-group d-none">
                                                <label for="user_id">Staff</label>
                                                <select class="form-control" name="user_id" id="user_id"></select>
                                                <small class="user_id-error text-danger"></small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="status_of_issue">Status of Issue</label>
                                                <select name="status_of_issue" id="status_of_issue" class="form-control">
                                                    <option value="">Status of Issue</option>
                                                    <option value="Not Started">Not Started</option>
                                                    <option value="Ongoing">Ongoing</option>
                                                    <option value="On Hold">On Hold</option>
                                                    <option value="Resolved">Resolved</option>
                                                </select>
                                                <small class="text-danger status_of_issue-error"></small>
                                            </div>

                                            <div class="form-group">
                                                <label for="remarks">Remarks</label>
                                                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="5"></textarea>
                                                <small class="remarks-error text-danger"></small>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-primary add_engagement" id="save_history" data-type="issue_history">Save History</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal_close">Close</button>
        </div>
        </div>
    </div>
</div>

<div id="add_issue" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark"><i class="pe-7s-gleam pe-lg mr-2"></i>Add Issue</h5>
            <button type="button" class="close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form class="issue_form">
            <input type="hidden" name="action" id="action" value="issues">
            <div class="position-relative row form-group">
                <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                <div class="col-sm-9">
                    <select name="coop" id="coop" class="form-control">
                        <option value="">Select COOP</option>
                        @foreach ($coops as $coop)
                            <option value="{{$coop->coop_name}}">{{strtoupper($coop->coop_name)}}</option>
                        @endforeach
                    </select>
                    <small class="text-danger coop-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="dependency" class="col-sm-3 col-form-label">Dependency</label>
                <div class="col-sm-9">
                    <select name="dependency" id="dependency" class="form-control">
                        <option value="Dependency">Dependency</option>
                        <option value="COOP">COOP</option>
                        <option value="Globe">Globe</option>
                        <option value="LGU">LGU</option>
                        <option value="Others">Others</option>
                    </select>
                    <small class="text-danger dependency-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="nature_of_issue" class="col-sm-3 col-form-label">Nature of Issue </label>
                <div class="col-sm-9">
                    <select name="nature_of_issue" id="nature_of_issue" class="form-control">

                        @php
                            $issues = \DB::table('issue_type')
                                    ->select('issue_type')
                                    ->distinct()
                                    ->where('program_id', 7)
                                    ->get();
                        @endphp     
                        <option value="">Nature of Issue</option>
                        @foreach ($issues as $issue)
                            <option value="{{ $issue->issue_type }}">{{ $issue->issue_type }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger nature_of_issue-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="issue" class="col-sm-3 col-form-label">Issue </label>
                <div class="col-sm-9">
                    <select name="issue" id="issue" class="form-control">
                        <option value="">Select Issue</option>
                    </select>
                    <small class="text-danger issue-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control"></textarea>
                    <small class="text-danger description-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="issue_raised_by" class="col-sm-3 col-form-label">Issue Raised By</label>
                <div class="col-sm-9">
                    <select name="issue_raised_by" id="issue_raised_by" class="form-control">
                        <option>Issue Raised By</option>
                        <option value="COOP">COOP</option>
                        <option value="Globe">Globe</option>
                        <option value="HOA">HOA</option>
                    </select>
                    <small class="text-danger issue_raised_by-error"></small>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="issue_raised_by_name" class="col-sm-3 col-form-label">Issue Raised By (Name)</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="issue_raised_by_name" name="issue_raised_by_name" placeholder="Issue Raised By (Name)">
                    <small class="text-danger issue_raised_by_name-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="date_of_issue" class="col-sm-3 col-form-label">Date of Issue</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control flatpicker" name="date_of_issue" id="date_of_issue" placeholder="Date of Issue">
                    <small class="text-danger date_of_issue-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="issue_assigned_to" class="col-sm-3 col-form-label">Issue Assigned To</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="issue_assigned_to" name="issue_assigned_to" placeholder="Issue Assigned To">
                    <small class="text-danger issue_assigned_to-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="status_of_issue" class="col-sm-3 col-form-label">Status of Issue</label>
                <div class="col-sm-9">
                    <select name="status_of_issue" id="status_of_issue" class="form-control">
                        <option value="">Status of Issue</option>
                        <option value="Not Started">Not Started</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                    <small class="text-danger status_of_issue-error"></small>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add_engagement" id="add_issue_btn" data-type="issues">Add Issue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="add_engagement" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark"><i class="pe-7s-star pe-lg mr-2"></i>Add Engagement</h5>
            <button type="button" class="close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form class="engagement_form">
            <input type="hidden" name="action" id="action" value="engagements">
            <div class="position-relative row form-group">
                <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                <div class="col-sm-9">
                    <select name="coop" id="coop" class="form-control">
                        <option value="">Select COOP</option>
                        @foreach ($coops as $coop)
                            <option value="{{$coop->coop_name}}">{{strtoupper($coop->coop_name)}}</option>
                        @endforeach
                    </select>
                    <small class="text-danger coop-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="engagement_type" class="col-sm-3 col-form-label">Engagement Type</label>
                <div class="col-sm-9">
                    <select name="engagement_type" id="engagement_type" class="form-control">
                        <option value="">Select Engagement Type</option>
                        <option value="Transport">Transport</option>
                        <option value="XDEAL">XDEAL</option>
                        <option value="Power Upgrade">Power Upgrade</option>
                        <option value="New Sites">New Sites</option>
                        <option value="Sites for Permanent Power">Sites for Permanent Power</option>
                        <option value="RTA">RTA</option>
                        <option value="JPA">JPA</option>
                        <option value="Bills Payment">Bills Payment</option>
                    </select>
                    <small class="text-danger engagement_type-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="result_of_engagement" class="col-sm-3 col-form-label">Result of Engagement</label>
                <div class="col-sm-9">
                    <select name="result_of_engagement" id="result_of_engagement" class="form-control">
                        <option value="">Select Engagement Result</option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Engaged">Engaged</option>
                    </select>
                    <small class="text-danger result_of_engagement-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" class="form-control"></textarea>
                    <small class="text-danger remarks-error"></small>
                </div>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add_engagement" id="add_engagement_btn" data-type="engagements">Add Engagement</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="add_contact" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark"><i class="pe-7s-user pe-lg mr-2"></i>Add Contact</h5>
            <button type="button" class="close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="contact_form">
                <input type="hidden" name="action" id="action" value="contacts">
                <div class="position-relative row form-group">
                    <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                    <div class="col-sm-9">
                        <select name="coop" id="coop" class="form-control">
                            <option value="">Select COOP</option>
                            @foreach ($coops as $coop)
                                <option value="{{$coop->coop_name}}">{{strtoupper($coop->coop_name)}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger coop-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="contact_type" class="col-sm-3 col-form-label">Contact Type</label>
                    <div class="col-sm-9">
                        <select id="contact_type" name="contact_type" class="form-control">
                            <option value="">Select Contact Type</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Area Engineer">Area Engineer</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Exeutive Assistant to the GM">Exeutive Assistant to the GM</option>
                            <option value="General Manager">General Manager</option>
                            <option value="Secretary">Secretary</option>
                        </select>
                        <small class="text-danger contact_type-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="firstname" class="col-sm-3 col-form-label">Firstname</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Firstname" name="firstname" id="firstname" class="form-control" />
                        <small class="text-danger firstname-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="lastname" class="col-sm-3 col-form-label">Lastname</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Lastname" name="lastname" id="lastname" class="form-control"/>
                        <small class="text-danger lastname-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="contact_number" class="col-sm-3 col-form-label">Cellphone</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Cellphone" name="contact_number" id="contact_number" class="form-control"/>
                        <small class="text-danger contact_number-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" placeholder="Email" name="email" id="email" class="form-control"/>
                        <small class="text-danger email-error"></small>
                    </div>
                </div>
            </form>
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary add_engagement" id="add_contact_btn" data-type="contacts">Add Contact</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
  

<div id="coop_issues" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark"><i class="pe-7s-plugin pe-lg mr-2"></i>Coop Issues</h5>
            <button type="button" class="close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="table-coop-issues-div" class="table-responsive">

            </div>
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>