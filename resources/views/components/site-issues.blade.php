<div class="row">
    <div class="col-12">
        <button id="btn_add_issue_switch" class="mt-1 btn btn-danger float-right" type="button">Add Issue</button>
        <form class="add_issue_form mb-2 d-none">
            <div class="form-row mb-1">
                <div class="col-5">
                    <label for="exampleEmail22" class="mr-sm-2">Issue Type</label>
                </div>
                <div class="col-7">
                    <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-5">
                    <label for="exampleEmail22" class="mr-sm-2">Issue</label>
                </div>
                <div class="col-7">
                    <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-5">
                    <label for="exampleEmail22" class="mr-sm-2">Issue Details</label>
                </div>
                <div class="col-7">
                    <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-12">
                    <button class="mt-1 btn btn-danger float-right" type="button">Add Issue</button>
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
        <table class="mb-0 table table-bordered">
            <thead>
                <tr>
                    <th>Start Date</th>
                    <th>Issue</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">No Issue</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
