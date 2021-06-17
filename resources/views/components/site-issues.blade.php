<div class="row">
    <div class="col-12">
        <button id="btn_add_issue_switch" class="mt-1 btn btn-danger float-right" type="button">Add Issue</button>
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
                    <input type="text" name="start_date" id="start_date" class="form-control flatpicker">
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
            <div class="form-row mb-1">
                <div class="col-12">
                    <button class="mt-1 btn btn-danger float-right add_issue" type="button">Add Issue</button>
                    <button id="btn_add_issue_cancel" class="mt-1 btn btn-outline-danger mr-1 float-right" type="button">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- <div class="divider"></div> --}}
<div class="row">
    <div class="col-12">
        <h5 class="card-title">Issue List</h5>
        <table class="mb-0 table table-bordered my_table_issue w-100" data-href="/get-my-issue/{{ $site[0]->sam_id }}">
            <thead>
                <tr>
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
