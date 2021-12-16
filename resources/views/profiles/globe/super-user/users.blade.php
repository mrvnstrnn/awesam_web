@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-body">
        <button class="btn btn-lg btn-primary add_user" type="button" data-action="true">Add User</button>
        <table style="width: 100%;" id="users-table" class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    {{-- <th>Profile</th>
                    <th>Vendor</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
  
@endsection

@section('modals')

<div class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="add_user_form">
                        <div class="form-group">
                            <input type="text" name="id" id="id" class="form-control">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control">
                            <small class="firstname-error text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control">
                            <small class="lastname-error text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <small class="email-error text-danger"></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="profile">Profile</label>
                            <select name="profile" id="profile" class="form-control">
                                @php
                                    $profiles  = \App\Models\Profile::orderBy('profile')->get();  
                                @endphp

                                @foreach ($profiles as $profile)
                                    <option value="{{ $profile->id }}">{{ $profile->profile }}</option>
                                @endforeach
                            </select>
                            <small class="profile-error text-danger"></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="form-control">
                                <option value="">Not Applicable</option>
                                @php
                                    $vendors  = \App\Models\Vendor::orderBy('vendor_acronym')->get();  
                                @endphp

                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_acronym }}</option>
                                @endforeach
                            </select>
                            <small class="vendor-error text-danger"></small>
                        </div>

                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save_user">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_script')

<script>
    $(document).ready(() => {
        $('#users-table').DataTable({
            processing: true,
            serverSide: false,
            filter: true,
            searching: true,
            lengthChange: true,
            responsive: true,
            stateSave: true,
            regex: true,
                ajax: {
                url: '/get-all-users',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },

            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                // { data: 'profile', name: 'profile' },
                // { data: 'vendor', name: 'vendor' },
                { data: 'action', name: 'action' },
            ],
            columnDefs: [ {
                targets: [ 0 ],
                orderData: [ 0, 1 ]
            } ]
    
        });

        $("button.add_user").on("click", function () {
            $("#add_user_modal").modal("show");
        });

        $(".add_user_form").on("click", ".save_user", function () {

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/add-new-user",
                method: "POST",
                data: $(".add_user_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $(".save_user").removeAttr("disabled");
                        $(".save_user").text("Save");

                        $(".add_user_form")[0].reset();
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(".add_user_form ." + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }
                        $(".save_user").removeAttr("disabled");
                        $(".save_user").text("Save");
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(".save_user").removeAttr("disabled");
                    $(".save_user").text("Save");
                }

            });
        });

        $("#users-table").on("click", ".edit_user", function () {

            var id = $(this).attr("data-id");

            $.ajax({
                url: "/get-data-user",
                method: "POST",
                data: {
                    id : id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        $("#add_user_modal").modal("show");

                        $.each(resp.message, function(index, data) {
                            if (index == 'profile_id') {
                                $(".add_user_form #profile").val(data);
                            }
                            $(".add_user_form #" + index).val(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        });
        
    });
</script>

@endsection