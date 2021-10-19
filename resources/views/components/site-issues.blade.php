<div class="row mb-3 add_button_issue_div">
    <div class="col-12 align-right border-bottom">
        <button id="btn_add_issue_switch" class=" mb-3 btn btn-danger float-right" type="button">Add Issue</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form class="add_issue_form mb-2 d-none">
            <input type="hidden" name="hidden_program_id" value="{{ $site[0]->program_id }}">
            <input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
            <div class="form-row mb-1">
                <div class="col-4">
                    <label for="issue_type" class="mr-sm-2">Issue Type</label>
                </div>
                <div class="col-8">
                    @php
                        $types = \App\Models\IssueType::select('*')->where('program_id', $site[0]->program_id)->get();
                        $type_array = array_keys($types->groupBy('issue_type')->toArray());
                    @endphp

                    <select name="issue_type" id="issue_type" class="form-control">
                        <option value="">Please select issue type</option>
                        @for ($i = 0; $i < count($type_array); $i++)
                            <option value="{{ $type_array[$i]  }}">{{ $type_array[$i] }}</option>
                        @endfor
                    </select>
                    <small class="text-danger issue_type-error"></small>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <label for="issue" class="mr-sm-2">Issue</label>
                </div>
                <div class="col-8">
                    <select name="issue" id="issue" class="form-control"></select>
                    <small class="text-danger issue-error"></small>
                </div>
            </div>

            <div class="form-row mb-1">
                <div class="col-4">
                    <label for="start_date" class="mr-sm-2">Issue Started</label>
                </div>
                <div class="col-8">
                    <input type="text" name="start_date" id="start_date" class="form-control flatpicker" style="background-color: white !important;">
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
            <div class="form-row mb-1">
                <div class="col-12">
                    <hr>    
                    <button class="mt-1 btn btn-danger float-right add_issue" type="button">Add Issue</button>
                    <button id="btn_add_issue_cancel" class="mt-1 btn btn-secondary mr-1 float-right" type="button">Cancel</button>
                </div>
            </div>
        </form>

        <div class="view_issue_form d-none">
            <form class="mb-2">
                <div class="form-row mb-1">
                    <div class="col-4">
                        <label for="issue_type" class="mr-sm-2">Issue Type</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" name="issue_type" id="issue_type" disabled>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="col-4">
                        <label for="issue" class="mr-sm-2">Issue</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" name="issue" id="issue" disabled>
                    </div>
                </div>
    
                <div class="form-row mb-1">
                    <div class="col-4">
                        <label for="start_date" class="mr-sm-2">Issue Started</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" name="start_date" id="start_date" disabled>
                    </div>
                </div>
    
                <div class="form-row mb-1">
                    <div class="col-4">
                        <label for="issue_details" class="mr-sm-2">Issue Details</label>
                    </div>
                    <div class="col-8">
                        <textarea name="issue_details" id="issue_details" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            </form>
    
            {{-- @if (\Auth::user()->profile_id == 2) --}}
            <button id="btn_add_remarks" class=" mb-3 btn btn-primary float-right" type="button">Add Update</button>
            {{-- @endif --}}
            <button class=" mb-3 btn btn-secondary float-right btn_back_to_list mr-2" type="button">Back to issue list</button>

            <br><hr><br>

        </div>

        <div class="add_remarks_issue_form d-none">
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
                        <input type="date" class="form-control" name="date_engage" id="date_engage">
                        <small class="text-danger date_engage-errors"></small>
                    </div>
                </div>

                {{-- @if (\Auth::user()->profile_id == 2) --}}
                <button class="btn btn-sm btn-primary add_btn_remarks_submit float-right" type="button">Add Update</button>
                {{-- @endif --}}
                <button class="btn btn-sm btn-secondary btn_cancel_remarks float-right mr-2" type="button">Cancel</button>
            </form>

            <br><hr><br>
        </div>

        <div class="table-list-issue"></div>
    </div>
</div>
{{-- <div class="divider"></div> --}}
<div class="row" id="issue_table">
    <div class="col-12">
        <table class="table-hover mb-0 table table-bordered my_table_issue w-100" data-href="/get-my-issue/{{ $site[0]->sam_id }}">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>Issue</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<script src="/js/site-issues.js"></script>

