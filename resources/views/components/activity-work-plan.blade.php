


<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

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
                                                {{ $site[0]->site_name }}
                                                @if(!is_null($site[0]->site_category) && $site[0]->site_category != "none")
                                                    <span class="mr-3 badge badge-secondary"><small class="site_category">{{ $site[0]->site_category }}</small></span>
                                                @endif
                                            </h5>
                                            <div class="mb-0 mt-2">
                                                @php
    
                                                    // dd($site);
                                                    if ( isset($site[0]->end_date) ){
                                                        if($site[0]->end_date > now()){
                                                            $badge_color = "success";
                                                        } else {
                                                            $badge_color = "danger";
                                                        }
                                                    } else {
                                                        $badge_color = "danger";
                                                    }
    
                                                @endphp
    
                                                @if($main_activity == "")
                                                    <span class="ml-1 badge badge-light text-sm mb-0 p-2">WORK PLAN</span>
                                                    <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
                                                @else
                                                    <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $main_activity }}</span>
                                                @endif
                                            </div> 
                
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="card-body">
                                <div id="action_lessor_engagement" class="">
                                    <div class="row">
                                        <div class="col-12">
                                            <H5 class="pb-2">Planned Engagement Details</H5>
                                        </div>
                                    </div>
                                    <div class="row px-0" id="control_form_log">
                                        <div class="col-12">                                
                                            <form class="engagement_form">
                                                <div class="position-relative row form-group">
                                                    <label for="lessor_method_log" class="col-sm-3 col-form-label">Activity</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="lessor_method_log" name="lessor_method_log" value="{{ $site[0]->activity_name }}" readonly="">
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="lessor_method_log" class="col-sm-3 col-form-label">Action</label>
                                                    <div class="col-sm-9">
                                                        @php
                                                            $sub_activities = \DB::table('sub_activity')
                                                                        ->where('program_id', $site[0]->program_id)
                                                                        ->where('category', $site[0]->site_category)
                                                                        ->where('activity_id', $site[0]->activity_id)
                                                                        ->get();
                                                        @endphp 
                                                        <select class="form-control">
                                                            <option value="">Select Action</option>
                                                            @foreach ($sub_activities as $sub_activity)
                                                            <option value="{{ $sub_activity->sub_activity_id }}">{{ $sub_activity->sub_activity_name }}</option>                                                            
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="lessor_method_log" class="col-sm-3 col-form-label">Method</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control">
                                                            <option value="">Select Method</option>
                                                            <option value="Call">Call</option>
                                                            <option value="Text">Text</option>
                                                            <option value="Email">Email</option>
                                                            <option value="Site Visit">Site Visit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="lessor_date_log" class="col-sm-3 col-form-label">Planned Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="lessor_date_log" name="lessor_date_log" class="form-control flatpicker flatpickr-input">
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="lessor_remarks_log" class="col-sm-3 col-form-label">Remarks</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="lessor_remarks_log" id="lessor_remarks_log" class="form-control"></textarea>
                                                        <small class="text-danger lessor_remarks-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group d-none">
                                                    <label for="lessor_approval_log" class="col-sm-3 col-form-label">Approval</label>
                                                    <div class="col-sm-9">
                                                        <select name="lessor_approval_log" id="lessor_approval_log" class="form-control">
                                                            <option value="engagement" selected="">Approval not yet secured</option>
                                                            <option value="active">Approval not yet secured</option>
                                                            <option value="approved">Approval Secured</option>
                                                            <option value="denied">Rejected</option>
                                                        </select>
                                                        <small class="text-danger lessor_approval-errors"></small>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>                                                                                
                            </div>                 
                            <div class="card-footer">
                                <div class="col-12  text-right p-0">
                                    <button class="btn btn-primary save_engagement_log" data-log="true" type="button">Save Engagement</button>
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
    
    




