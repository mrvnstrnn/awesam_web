@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-body">
        <button class="btn btn-sm btn-primary m-3 addnewpermission_btn">Add new permission</button>
        <table style="width: 100%;" id="permission-table" class="table table-hover table-striped table-bordered" data-href="{{ route('all.permission') }}">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Subheading</th>
                    <th>Menu</th>
                    <th>Slug</th>
                    <th>Level One</th>
                    <th>Level Two</th>
                    <th>Level Three</th>
                    <th>Icon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Subheading</th>
                    <th>Menu</th>
                    <th>Slug</th>
                    <th>Level One</th>
                    <th>Level Two</th>
                    <th>Level Three</th>
                    <th>Icon</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('modals')

<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="permission_form">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="title">Title</label>
                                    <input type="hidden" name="hidden_permission_id" id="id">
                                    <input id="title" type="text" class="form-control" 
                                        name="title" required autofocus placeholder="Title here...">
                
                                    <small id="title-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="title_subheading">Title Subheading</label>
                                    <input id="title_subheading" type="text" class="form-control" 
                                        name="title_subheading" required placeholder="Title Subheading here...">
                
                                    <small id="title_subheading-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="menu">Menu</label>
                                    <input id="menu" type="text" class="form-control" 
                                        name="menu" required placeholder="Menu here...">
                
                                    <small id="menu-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="slug">Slug</label>
                                    <input id="slug" type="text" class="form-control" 
                                        name="slug" required placeholder="Slug here...">
                
                                    <small id="slug-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="level_one">Level One</label>
                                    <input id="level_one" type="text" class="form-control" 
                                        name="level_one" required value="profile_menu" readonly>
                
                                    <small id="level_one-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="level_two">Level Two</label>
                                    <input id="level_two" type="text" class="form-control" 
                                        name="level_two" required placeholder="Level two here...">
                
                                    <small id="level_two-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="level_three">Level Three</label>
                                    <input id="level_three" type="text" class="form-control" 
                                        name="level_three" required placeholder="Level three here...">
                
                                    <small id="level_three-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="position-relative form-group">
                                    <label for="icon">Icon</label>
                                    <input id="icon" type="text" class="form-control" 
                                        name="icon" required placeholder="Icon here...">
                
                                    <small id="icon-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary addupdate_permission" data-href="{{ route('addupdate.permission') }}">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deletePermissionModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <input type="hidden" name="hidden_permission_id" id="hidden_permission_id">
                    Are you sure you want to delete this permission <b class="permission_name"></b>?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary confirm_delete_permission" data-href="{{ route('delete.permission') }}">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM
        
    });
</script>

@endsection

@section('js_script')
    <script src="{{ asset('js/supervisor.js') }}"></script>
@endsection