<style>

    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }

</style>

@php
    $new_json = json_decode($json);

    $sub_activities = \DB::table('sub_activity')
                        ->where('program_id', $new_json->program_id)
                        ->where('category', $new_json->category)
                        ->where('activity_id', $new_json->activity_id)
                        ->get();
@endphp

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row">
                <div class="col-12">
                    <div class="main-card card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner  py-3  px-2 bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <div>
                                        <h5 class="menu-header-title">
                                            Add Activity Engagement
                                        </h5>
                                        <div class="mb-0 mt-2">
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <form id="add_engagement_form" class="add_engagement_form">
                            <div class="card-body">
                                <div id="add_engagement" class="add_engagement">
                                    <div class="row px-0" id="control_form_log">
                                        <div class="col-12">
                                                <input type="hidden" id="sub_activity_name" name="sub_activity_name">

                                                <div class="position-relative row form-group">
                                                    <label for="site_name" class="col-sm-3 col-form-label">Site</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{ $new_json->site_name }}" name="site_name" readonly>
                                                        <input type="hidden" id="sam_id" name="sam_id" value="{{ $new_json->sam_id }}">
                                                        <small class="text-danger site_name-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="activity_name" class="col-sm-3 col-form-label">Activity</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{ $new_json->activity_name }}" name="activity_name" readonly>
                                                        <small class="text-danger activity_name-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="sub_activity_id" class="col-sm-3 col-form-label">Sub Activity</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="sub_activity_id" id="sub_activity_id">
                                                            <option value="">Select Sub Activity</option>
                                                                @foreach ($sub_activities as $sub_activity)
                                                                <option value="{{ $sub_activity->sub_activity_id}}">{{ $sub_activity->sub_activity_name}}</option>                                                                
                                                            @endforeach
                                                        </select>
                                                        <small class="text-danger sub_activity_id-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="method" class="col-sm-3 col-form-label">Method</label>
                                                    <div class="col-sm-9">

                                                        <select class="form-control" name="method">
                                                            <option value="">Select Method</option>
                                                            <option value="Call">Call</option>
                                                            <option value="Text">Text</option>
                                                            <option value="Email">Email</option>
                                                            <option value="Site Visit">Site Visit</option>
                                                            <option value="Call">Upload Document</option>
                                                        </select>
                                                        <small class="text-danger method-errors"></small>

                                                    </div>
                                                </div>
                                                {{-- <div class="position-relative row form-group">
                                                    <label for="planned_date" class="col-sm-3 col-form-label">Planned Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="planned_date" name="planned_date" class="form-control datepicker flatpicker bg-white">
                                                        <small class="text-danger planned_date-errors"></small>
                                                    </div>
                                                </div> --}}
                                                <div class="position-relative row form-group">
                                                    <label for="saq_objective" class="col-sm-3 col-form-label">SAQ Objective</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="saq_objective" name="saq_objective" class="form-control">
                                                        <small class="text-danger saq_objective-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="remarks" id="remarks" class="form-control"></textarea>
                                                        <small class="text-danger remarks-errors"></small>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal_saving" class="d-none">
                                    Saving Activity Work Plan....
                                </div>   
                                
                            </div>                 
                            <div class="card-footer">
                                <div class="col-12  text-right p-0">
                                    <button class="btn btn-primary btn-lg add_engagement_btn" type="button">Log Engagement</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    
    $('.add_engagement_btn').on('click', function(e){
        e.preventDefault();
        
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({

            url: '/engagement/add',
            method: 'POST',
            data: $("#add_engagement_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){

                    $('#viewInfoModal').modal('hide');

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                    $(".add_engagement_btn").attr("disabled", "disabled");
                    $(".add_engagement_btn").text("Log Engagement");
                } else {

                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {

                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".add_engagement_btn").attr("disabled", "disabled");
                    $(".add_engagement_btn").text("Log Engagement");
                }
            },
            error: function(resp){


                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".add_engagement_btn").attr("disabled", "disabled");
                $(".add_engagement_btn").text("Log Engagement");
            }
        });
        
    });

    $('#sub_activity_id').on('change', function(e){
        $('#sub_activity_name').val($('#sub_activity_id').children("option:selected").text());    
    });


});
</script>


