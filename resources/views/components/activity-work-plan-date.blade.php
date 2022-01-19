


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


if($activity_source == 'work_plan_view'){


    // $wp_db = \DB::table('sub_activity_value')->where('id', $json->work_plan_id)->first();
    $wp_db = \DB::table('sub_activity_value')
                ->join('view_site', 'view_site.sam_id', 'sub_activity_value.sam_id')
                ->where('sub_activity_value.id', $json->work_plan_id)
                ->where('view_site.activity_type', "!=", "complete")
                ->first();

    $wp_db_value = json_decode($wp_db->value);

    $sam_id = $wp_db_value->sam_id;
    $site_name = $wp_db_value->site_name;

    $activity_id = $wp_db_value->activity_id;
    $activity_name = $wp_db_value->activity_name;

    $sub_activity_id = $wp_db_value->sub_activity_id;
    $sub_activity_name = $wp_db_value->sub_activity_name;

    $method = $wp_db_value->method;
    $planned_date = $wp_db_value->planned_date;
    $saq_objective = $wp_db_value->saq_objective;
    $remarks = $wp_db_value->remarks;

}
elseif($activity_source == 'work_plan_add'){

    // $sites = \DB::table('view_assigned_sites')->where('agent_id', \Auth::user()->id)->get();
    $sites = \DB::table('view_assigned_sites')
                ->join('view_site', 'view_site.sam_id', 'view_assigned_sites.sam_id')
                ->select('view_assigned_sites.*')
                ->where('view_assigned_sites.agent_id', \Auth::user()->id)
                ->where('view_site.activity_type', "!=", "complete")
                ->get();

    if(!isset($json->planned_date)){
        $planned_date = "";
    } else {
        $planned_date = $json->planned_date;
    }


}

elseif($activity_source == 'work_plan_activity_add'){

    $sub_activities = \DB::table('sub_activity')
                        ->where('program_id', $json->program_id)
                        ->where('category', $json->category)
                        ->where('activity_id', $json->activity_id)
                        ->get();

    if(!isset($json->sam_id)){
        $sam_id = "";
    } else {
        $sam_id = $json->sam_id;
    }

    if(!isset($json->activity_id)){
        $activity_id = "";
    } else {
        $activity_id = $json->activity_id;
    }

    if(!isset($json->site_name)){
        $site_name = "";
    } else {
        $site_name = $json->site_name;
    }

    if(!isset($json->planned_date)){
        $planned_date = "";
    } else {
        $planned_date = $json->planned_date;
    }

    if(!isset($json->site_name)){
        $site_name = "";
    } else {
        $site_name = $json->site_name;
    }

    if(!isset($json->activity_name)){
        $activity_name = "";
    } else {
        $activity_name = $json->activity_name;
    }

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
                                            @if($activity_source == "work_plan_view")
                                                View Work Plan
                                            @elseif($activity_source == "work_plan_add")
                                                Add Work Plan
                                            @elseif($activity_source == "work_plan_activity_add")
                                                Add Activity Work Plan
                                            @endif
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

                                            <input type="hidden" id="sub_activity_name" name="sub_activity_name">

                                            <div class="position-relative row form-group">
                                                <label for="sam_id" class="col-sm-3 col-form-label">Site</label>
                                                <div class="col-sm-9">
                                                    @if($activity_source == "work_plan_view")

                                                        <input type="text" class="form-control" value="{{ $site_name }}" readonly> 

                                                    @elseif($activity_source == "work_plan_activity_add")

                                                        <input type="text" class="form-control" value="{{ $site_name }}" name="site_name" readonly>
                                                        <input type="hidden" id="sam_id" name="sam_id" value="{{ $sam_id }}">
                                                        
                                                    @elseif($activity_source == "work_plan_add")

                                                        <input type="hidden" id="site_name" name="site_name">
                                                        <select class="form-control" name="sam_id" id="sam_id">
                                                            <option value="">Select Site</option>
                                                            @foreach ($sites as $site)
                                                                <option value="{{$site->sam_id}}">{{$site->site_name}}</option>                                                        
                                                            @endforeach
                                                        </select>
                                                        <small class="text-danger sam_id-errors"></small>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="activity_id" class="col-sm-3 col-form-label">Activity</label>
                                                <div class="col-sm-9">
                                                    @if($activity_source == "work_plan_view")
                                                    
                                                        <input type="text" class="form-control" value="{{ $activity_name }}" readonly>
                                                    
                                                    @elseif($activity_source == "work_plan_activity_add")
                                                    
                                                        <input type="text" class="form-control" value="{{ $activity_name }}" name="activity_name" readonly>
                                                        <input type="hidden" id="activity_id" name="activity_id" value="{{ $activity_id }}">

                                                    
                                                    @elseif($activity_source == "work_plan_add")

                                                        <input type="hidden" id="activity_name" name="activity_name">
                                                        <select class="form-control" name="activity_id" id="activity_id">
                                                            <option value="">Select Activity</option>
                                                        </select>
                                                        <small class="text-danger activity_id-errors"></small>
                                                    
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="sub_activity_id" class="col-sm-3 col-form-label">Sub Activity</label>
                                                <div class="col-sm-9">
                                                    @if($activity_source == "work_plan_view")

                                                        <input type="text" class="form-control" value="{{ $sub_activity_name }}" readonly>
    
                                                    @elseif($activity_source == "work_plan_activity_add")
    
                                                        <select class="form-control" name="sub_activity_id" id="sub_activity_id">
                                                            <option value="">Select Sub Activity</option>
                                                            @foreach ($sub_activities as $sub_activity)
                                                            <option value="{{ $sub_activity->sub_activity_id}}">{{ $sub_activity->sub_activity_name}}</option>                                                                
                                                            @endforeach
                                                        </select>
                                                        <small class="text-danger sub_activity_id-errors"></small>

                                                    @elseif($activity_source == "work_plan_add")

                                                        <select class="form-control" name="sub_activity_id" id="sub_activity_id">
                                                            <option value="">Select Sub Activity</option>
                                                        </select>
                                                        <small class="text-danger sub_activity_id-errors"></small>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="method" class="col-sm-3 col-form-label">Method</label>
                                                <div class="col-sm-9">
                                                    @if($activity_source == "work_plan_view")
                                                    
                                                        <input type="text" class="form-control" value="{{ $method }}" readonly>
                                                    
                                                    @elseif($activity_source == "work_plan_add" || $activity_source == "work_plan_activity_add")

                                                        <select class="form-control" name="method">
                                                            <option value="">Select Method</option>
                                                            <option value="Call">Call</option>
                                                            <option value="Text">Text</option>
                                                            <option value="Email">Email</option>
                                                            <option value="Site Visit">Site Visit</option>
                                                            {{-- <option value="Upload Document">Upload Document</option> --}}
                                                        </select>
                                                        <small class="text-danger method-errors"></small>

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="planned_date" class="col-sm-3 col-form-label">Planned Date</label>
                                                <div class="col-sm-9">
                                                    @if($activity_source == "work_plan_view")

                                                        <input type="text" class="form-control" value="{{ $planned_date }}" readonly>

                                                    @elseif($activity_source == "work_plan_add" || $activity_source == "work_plan_activity_add")
                                                        
                                                        <input type="text" id="planned_date" name="planned_date" class="form-control datepicker flatpicker bg-white" value="{{ $planned_date }}">
                                                        <small class="text-danger planned_date-errors"></small>
                                                    
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="saq_objective" class="col-sm-3 col-form-label">SAQ Objective</label>
                                                <div class="col-sm-9">
                                                    @if($activity_source == "work_plan_view")

                                                        <input type="text" class="form-control" value="{{ $saq_objective }}" readonly>

                                                    @elseif($activity_source == "work_plan_add" || $activity_source == "work_plan_activity_add")
    
                                                        <input type="text" id="saq_objective" name="saq_objective" class="form-control">
                                                        <small class="text-danger saq_objective-errors"></small>
        
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="position-relative row form-group">
                                                <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                                <div class="col-sm-9">
                                                    @if($activity_source == "work_plan_view")

                                                        <textarea name="remarks" id="remarks" class="form-control" readonly>{{ $remarks }}</textarea>
                                                    
                                                    @elseif($activity_source == "work_plan_add" || $activity_source == "work_plan_activity_add")
                                                    
                                                        <textarea name="remarks" id="remarks" class="form-control"></textarea>
                                                        <small class="text-danger remarks-errors"></small>
                                                    
                                                    @endif
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
                                @if($activity_source == "work_plan_view")
                                    <button class="btn btn-primary btn-lg add_activity_work_plan" data-log="true" type="button">Log Engagement</button>
                                @elseif($activity_source == "work_plan_add" || $activity_source == "work_plan_activity_add")
                                    <button class="btn btn-primary btn-lg save_activity_work_plan add_activity_work_plan" data-log="true" type="button">Save Work Plan</button>
                                @endif
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

    $(".flatpicker").flatpickr({minDate: "{{$planned_date}}" });
    
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

    $('#sam_id').on('change', function(e){

        e.preventDefault();

        var sam_id = $(this).val();   
        
        $.ajax({

            url: '/site-ajax',
            method: 'POST',
            data: {
                sam_id : sam_id,
                type: 'work_plan_stage_activities'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){

                    $('#activity_id')
                        .find('option')
                        .remove()
                        .end()
                    ;
                    
                    $('#sub_activity_id')
                        .find('option')
                        .remove()
                        .end()
                    ;

                    $('#site_name').val($('#sam_id').children("option:selected").text());    


                    $("#activity_id").append(new Option("Select  Activity",  ""));

                    $.each(resp.message, function(k, v) 
                    {
                        $("#activity_id").append(new Option(v.activity_name,  v.activity_id));
                    });                    

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
                }
            },
            error: function(resp){

                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });



    });

    $('#activity_id').on('change', function(e){

        e.preventDefault();

        var sam_id = $("#sam_id").val();       
        var activity_id = $(this).val();       
        
        $.ajax({

            url: '/site-ajax',
            method: 'POST',
            data: {
                sam_id : sam_id,
                activity_id : activity_id,
                type: 'work_plan_sub_activities'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){


                    $('#sub_activity_id')
                        .find('option')
                        .remove()
                        .end()
                    ;

                    $('#activity_name').val($('#activity_id').children("option:selected").text());    


                    $("#sub_activity_id").append(new Option("Select Sub Activity",  ""));

                    $.each(resp.message, function(k, v) 
                    {
                        $("#sub_activity_id").append(new Option(v.sub_activity_name,  v.sub_activity_id));
                        console.log(v.sub_activity_name);
                    });                    

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
                }
            },
            error: function(resp){

                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });



    });

    $('#sub_activity_id').on('change', function(e){


        $('#sub_activity_name').val($('#sub_activity_id').children("option:selected").text());    


    });


});
</script>


