@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-body">
        <table style="width: 100%;" id="profile-table" class="table table-hover table-striped table-bordered" data-href="{{ route('all.profile') }}">
            <thead>
                <tr>
                    <th>Profile</th>
                    <th>Mode</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>Profile</th>
                    <th>Mode</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('modals')

<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="profile_form">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="profile_name">Profile Name</label>
                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                    <input id="profile_name" type="text" class="form-control" 
                                        name="profile_name" required autofocus placeholder="Profile name here...">
                
                                    <small id="profile_name-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row profile_list">
                        </div>
                        <small id="profile_checkbox-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_pofile" data-href="{{ route('update.profile') }}">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js_script')
    <script src="{{ asset('js/supervisor.js') }}"></script>
@endsection