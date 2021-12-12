@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="main-card p-3 mb-3 card">
                <div class="form-row mb-3">
                    <div class="col-12">
                        @php
                            $user = \Auth::user()->getUserDetail()->first();   
                        @endphp
                        <div class="text-center">
                            @if (!is_null($user->image))
                                <img width="150" height="150" class="border border-dark rounded-circle offline" src="{{ asset('files/'.$user->image) }}" alt="">
                            @else
                                <img width="150" height="150" class="border border-dark rounded-circle offline" src="images/no-image.jpg" alt="">
                            @endif
                        </div>

                        <div>
                            <h5 class="menu-header-title text-center">{{ $user->name }}</h5>
                            <h6 class="menu-header-subtitle text-center">Short profile description</h6>
                        </div>

                    </div>
                </div>

                <ul class="tabs-animated body-tabs-animated nav">
                    <li class="nav-item">
                        <a role="tab" class="nav-link active" id="tab-personal" data-toggle="tab" href="#tab-content-personal">
                            <span>Personal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-address" data-toggle="tab" href="#tab-content-address">
                            <span>Address</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-security" data-toggle="tab" href="#tab-content-security">
                            <span>Security</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane tabs-animation fade active show" id="tab-content-personal" role="tabpanel">  
                        <form class="personal_form">
                            <input type="hidden" name="form_type" id="form_type" value="personal">
                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="firstname">Firstname</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control" value="{{ $user->firstname }}">
                                        <small class="text-danger firstname-error"></small>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="lastname">Lastname</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname }}">
                                        <small class="text-danger lastname-error"></small>
                                    </div>
                                </div>
                            </div>
            
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly title="You're not allowed to change you email address.">
                                        <small class="text-danger email-error"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="contact_no">Contact No.</label>
                                        <input type="text" name="contact_no" id="contact_no" class="form-control" value="{{ $user->contact_no }}">
                                        <small class="text-danger contact_no-error"></small>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="landline">Landline</label>
                                        <input type="text" name="landline" id="landline" class="form-control" value="{{ $user->landline }}">
                                        <small class="text-danger landline-error"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="hiring_date">Hiring Date</label>
                                        <input type="text" name="hiring_date" id="hiring_date" class="form-control" value="{{ $user->hiring_date }}" readonly>
                                        <small class="text-danger hiring_date-error"></small>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="birthday">Birth Date</label>
                                        <input type="date" name="birthday" id="birthday" class="form-control" value="{{ $user->birthday }}" style="background: transparent;">
                                        <small class="text-danger birthday-error"></small>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-shadow btn-lg pull-right update_button" type="button" id="personal">Update</button>
                        </form>
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-address" role="tabpanel">
                        <form class="personal_form">

                        </form>
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-security" role="tabpanel">
                        <form class="security_form">
                            <div class="form-row">
                                <input type="hidden" name="form_type" id="form_type" value="security">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control">
                                        <small class="text-danger old_password-error"></small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                        <small class="text-danger password-error"></small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                        <small class="text-danger password_confirmation-error"></small>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-shadow btn-lg pull-right update_button" type="button" id="security">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script>
        $(".flatpicker").flatpickr();

        $("input[name=birthday]").flatpickr(
            { 
            maxDate: new Date()
            }
        );

        $("form").on("click", ".update_button", function () {
            var id = $(this).attr("id");

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $("."+id+"_form small").text("");
            $.ajax({
                url: "/update-profile-data",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("."+id+"_form").serialize(),
                success: function (resp) {
                    if ( !resp.error ) {

                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".update_button#"+id).removeAttr("disabled");
                        $(".update_button#"+id).text("Update");

                        if (id == 'security') {
                            $("."+id+"_form")[0].reset();
                        }
                    } else {
                        
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $("."+id+"_form ." + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".update_button#"+id).removeAttr("disabled");
                        $(".update_button#"+id).text("Update");
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".update_button#"+id).removeAttr("disabled");
                    $(".update_button#"+id).text("Update");   
                }
            });
        });
    </script>
@endsection