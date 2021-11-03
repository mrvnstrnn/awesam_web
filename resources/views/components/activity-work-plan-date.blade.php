


{{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> --}}

<style>
    .numberCircle {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 8px;

        background:white;
        border: 2px solid #666;
        color: #666;
        text-align: center;

        font: 20px Arial, sans-serif;
    }
.modal-dialog{
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
    box-shadow: 0 5px 15px rgba(0,0,0,0);
}   

.dropzone {
    min-height: 20px !important;
    border: 2px dashed #3f6ad8 !important;
    border-radius: 10px;
    padding: unset !important;
}

.ui-datepicker.ui-datepicker-inline {
   width: 100% !important;
}

.ui-datepicker table {
    font-size: 1.3em;
}


.btn_switch_show_action:hover {
    cursor: pointer;
    color: blue;
}

.contact-lessor:hover, .contact-lessor_log:hover {
    color: blue;
    cursor: pointer;
}

</style>    

@php
$json = json_decode($json);

$planned_date = $json->planned_date;

if(!isset($json->sam_id)){
    $sites = \DB::table('view_assigned_sites')->where('agent_id', \Auth::user()->id)->get();
}




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
                                            Add Work Plan
                                        </h5>
                                        <div class="mb-0 mt-2">
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body">
                            <div id="add_activity_work_plan" class="add_activity_work_plan">
                                <div class="row px-0" id="control_form_log">
                                    <div class="col-12">                                
                                        <form id="add_worplan_form" class="add_worplan_form">

                                            {{-- <input type="hidden" class="form-control" id="sam_id" name="sam_id" value="{{ $site[0]->sam_id }}"> --}}
                                            <input type="hidden" class="form-control" id="activity_id" name="activity_id" value="">

                                            <div class="position-relative row form-group">
                                                <label for="lessor_method_log" class="col-sm-3 col-form-label">Site</label>
                                                <div class="col-sm-9">
                                                    @if(!isset($json->sam_id))
                                                    <select class="form-control" name="sub_activity_id">
                                                        <option value="">Select Site</option>
                                                        @foreach ($sites as $site)
                                                        <option value="{{$site->sam_id}}" data-program_id="{{$site->program_id}}" data-category="{{$site->site_category}}" data-activity_id="{{$site->activity_id}}">{{$site->site_name}}</option>                                                        
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="lessor_method_log" class="col-sm-3 col-form-label">Activity</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="sub_activity_id">
                                                        <option value="">Select Activity</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="lessor_method_log" class="col-sm-3 col-form-label">Sub Activity</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="sub_activity_id">
                                                        <option value="">Select Sub Activity</option>
                                                    </select>
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
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="planned_date" class="col-sm-3 col-form-label">Planned Date</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="planned_date" name="planned_date" class="form-control datepicker flatpicker bg-white">
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="saq_objective" class="col-sm-3 col-form-label">SAQ Objective</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="saq_objective" name="saq_objective" class="form-control">
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                                <div class="col-sm-9">
                                                    <textarea name="remarks" id="remarks" class="form-control"></textarea>
                                                    <small class="text-danger remarks-errors"></small>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="modal_saving" class="d-none">
                                Saving Activity Work Plan....
                            </div>                                                                                
                        </div>                 
                        <div class="card-footer">
                            <div class="col-12  text-right p-0">
                                <button class="btn btn-primary btn-lg save_activity_work_plan add_activity_work_plan" data-log="true" type="button">Save Work Plan</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(() => {

    $(".flatpicker").flatpickr({minDate: "today"});
    
    $('.save_activity_work_plan').on('click', function(e){
        e.preventDefault();

        $('.add_activity_work_plan').addClass('d-none');
        $('#modal_saving').removeClass('d-none');
        
        $.ajax({

            url: '/work-plan/add',
            method: 'POST',
            data: $("#add_worplan_form").serialize(),
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
                } else {            

                    $('.add_activity_work_plan').removeClass('d-none');
                    $('#modal_saving').addClass('d-none');

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
                }
            },
            error: function(resp){

                $('.add_activity_work_plan').removeClass('d-none');
                $('#modal_saving').addClass('d-none');

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


