


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

    {{-- <input id="modal_vendor_id" type="hidden" value="{{ $site[0]->vendor_id }}">
    <input id="modal_program_id" type="hidden" value="{{ $site[0]->program_id }}"> --}}
    <input id="sub_activity_id" type="hidden" value="{{ $site[0]->activity_id }}">

    <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card ">

                            <div class="dropdown-menu-header" style="paddng:0px !important;">
                                <div class="dropdown-menu-header-inner bg-dark">
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
                                                    <span class="ml-1 badge badge-dark text-sm mb-0 p-2">{{ isset($site[0]->stage_name) ? $site[0]->stage_name : "" }}</span>
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


                                @if($main_activity != null)

                                    <x-work-plan-modal />

                                @else

                                    

                                    @php
                                        // dd($site);

                                        $activity = \DB::connection('mysql2')
                                                ->table('stage_activities')
                                                ->where("program_id", $site[0]->program_id)        
                                                ->where("category", $site[0]->site_category)        
                                                ->where("activity_id", $site[0]->activity_id)
                                                ->first();

                                        $subactivity_type = $activity->subactivities_type;

                                        $sub_activities = \DB::connection('mysql2')
                                                ->table('sub_activity')
                                                ->where('program_id', $site[0]->program_id)
                                                ->where('activity_id', $site[0]->activity_id)
                                                ->where('category', $site[0]->site_category)
                                                ->orderBy('sequential_step')
                                                ->orderBy('requires_validation', 'desc')
                                                ->get();

                                    @endphp
                                    <div id="actions_list" class="action_box">
                                        <div class="row">
                                            <div class="col-12">
                                                @if($subactivity_type == "parallel")
                                                    <ul class="tabs-animated body-tabs-animated nav mb-4">
                                                        <li class="nav-item">
                                                            <a role="tab" class="nav-link active" id="tab-action-to-complete" data-toggle="tab" href="#tab-content-action-to-complete">
                                                                <span>Activity Actions</span>
                                                                <span class="badge badge-pill badge-success">{{ count($sub_activities) }}</span>
                                                            </a>
                                                        </li>
                                                        
                                                        <li class="nav-item">
                                                            <a role="tab" class="nav-link" id="tab-file" data-toggle="tab" href="#tab-content-file">
                                                                <span>Old Files From Google Drive</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane tabs-animation fade active show" id="tab-content-action-to-complete" role="tabpanel">
                                                            <div class="row border-bottom">
                                                                <div class="col-12">
                                                                    <H5>Actions to Complete</H5>
                                                                </div>
                                                                {{-- <div class="col-4">
                                                                    <button class="float-right p-2 pt-1 -mt-4 btn btn-outline btn-outline-dark btn-xs "><small>MARK AS COMPLETED</small></button>                                            
                                                                </div> --}}
                                                            </div>
                                                            <div class="row p-2 pt-3 action_to_complete_parent">
                                                                @foreach ($sub_activities as $sub_activity)
                                                                    @if($sub_activity->activity_id == $site[0]->activity_id)
                                                                    {{-- <div class="col-md-6 btn_switch_show_action pt-3 action_to_complete_child{{ $sub_activity->sub_activity_id }}" data-sam_id="{{$site[0]->sam_id}}" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-document_type="{{ $sub_activity->document_type}}" data-required=""
                                                                        data-substep_same="{{ \Auth::user()->substep_all($site[0]->sam_id, $sub_activity->sub_activity_id) }}"
                                                                        > --}}
                                                                        <div class="col-md-6 btn_switch_show_action pt-3 action_to_complete_child{{ $sub_activity->sub_activity_id }}" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-document_type="{{ $sub_activity->document_type}}" data-required=""
                                                                            data-substep_same="{{ \Auth::user()->substep_all($site[0]->sam_id, $sub_activity->sub_activity_id) }}"
                                                                            >
                                                                            <h6 class="action_to_complete_child_{{$sub_activity->sub_activity_id}}" style="display: unset; {{ $sub_activity->requirements == "required" ? "font-weight: 700" : "" }}"><i class="pe-7s-cloud-upload pe-lg pt-2 mr-2"></i>{{ $sub_activity->sub_activity_name }} {{ $sub_activity->requirements == "required" ? "*" : "" }}</h6>
                                                                            
                                                                            @if (!is_null(\Auth::user()->checkIfSubActUploaded($sub_activity->sub_activity_id, $site[0]->sam_id)))
                                                                            <i class="fa fa-check-circle fa-lg text-success" style="top:10px;"></i>
                                                                            @endif
                                                                        </div>
                                                                    @endif                               
                                                                @endforeach
                                                                <div class="col-12 mt-5">
                                                                <small>* Required actions are in bold letters</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane tabs-animation fade" id="tab-content-file" role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    @if ($site[0]->program_id == 8)
                                                                        @php
                                                                            $sub_activity_value_file_id = \DB::connection('mysql2')
                                                                                            ->table('sub_activity_value')
                                                                                            ->select('value')
                                                                                            ->where('sam_id', $site[0]->sam_id)
                                                                                            ->where('type', 'folder_url')
                                                                                            ->first();
                                                                        @endphp

                                                                        @if ( is_null($sub_activity_value_file_id) )
                                                                            <h5 class="text-center">Nothing to see here.</h5>
                                                                        @else
                                                                        @php
                                                                            $file_data = json_decode($sub_activity_value_file_id->value);
                                                                        @endphp

                                                                        @if (isset($file_data->file_url_id))
                                                                        <iframe src="https://drive.google.com/embeddedfolderview?id={{ $file_data->file_url_id }}#list" style="width:100%; height:600px; border:0;"></iframe>
                                                                        @else
                                                                        <h5 class="text-center">Nothing to see here.</h5>
                                                                        @endif
                                                                        @endif
                                                                    @else
                                                                        <img src="/images/construction.gif" width="100%"/>
                                                                        <h5>activity_source: File</h5>
                                                                        <div class="text-danger">Missing or incorrect component defintion in stage_activities_profiles tables or the source link doesnt have the correct activity_source attribute</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="tab-pane tabs-animation fade" id="tab-content-lessor-engagement" role="tabpanel">
                                                            <div id="action_lessor_engagement" class=''>
                                                                <div class="row py-5 px-4" id="control_box_log">
                                                                    <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor_log" data-value="Call">
                                                                        <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
                                                                        <div class="pt-3"><small>Call</small></div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor_log" data-value="Text">
                                                                        <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
                                                                        <div class="pt-3"><small>Text</small></div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6 my-3 text-center contact-lessor_log" data-value="Email">
                                                                        <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
                                                                        <div class="pt-3"><small>Email</small></div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor_log" data-value="Site Visit">
                                                                        <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
                                                                        <div class="pt-3"><small>Site Visit</small></div>
                                                            
                                                                    </div>
                                                                </div>
                                                                <div class="row py-3 px-5 d-none" id="control_form_log">
                                                                    <div class="col-12 py-3">
                                                                    <form class="engagement_form">
                                                                        <div class="position-relative row form-group">
                                                                            <label for="lessor_method_log" class="col-sm-3 col-form-label">Method</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" class="form-control" id="lessor_method_log" name="lessor_method_log" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="position-relative row form-group">
                                                                            <label for="lessor_date_log" class="col-sm-3 col-form-label">Date</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="lessor_date_log" name="lessor_date_log" class="form-control flatpicker">
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
                                                                                    <option value="engagement" selected>Approval not yet secured</option>
                                                                                    <option value="active">Approval not yet secured</option>
                                                                                    <option value="approved">Approval Secured</option>
                                                                                    <option value="denied">Rejected</option>
                                                                                </select>
                                                                                <small class="text-danger lessor_approval-errors"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="position-relative row form-group ">
                                                                            <div class="col-sm-3"></div>
                                                                            <div class="col-sm-9 offset-sm-3 text-right">
                                                                                <button class="btn btn-secondary cancel_engagement_log" type="button">Back to Engagement</button>
                                                                                <button class="btn btn-primary save_engagement_log" data-log="true" type="button">Save Engagement</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                            
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 table-responsive table_lessor_parent_log">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                @elseif($subactivity_type == "sequential")
                                                <ul class="tabs-animated body-tabs-animated nav mb-4">
                                                    <li class="nav-item">
                                                        <a role="tab" class="nav-link active" id="tab-action-to-complete" data-toggle="tab" href="#tab-content-action-to-complete">
                                                            <span>Activity Steps</span>
                                                            <span class="badge badge-pill badge-success">{{ count($sub_activities) }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane tabs-animation fade active show" id="tab-content-action-to-complete" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <H5>Steps to Complete</H5>
                                                            </div>
                                                        </div>
                                                        <div class="p-2 pt-0 action_to_complete_parent">
                                                            @php
                                                                $prev_step = 0;
                                                                $ctr = 0;
                                                            @endphp
                                                            @foreach ($sub_activities as $sub_activity)
                                                                @if($sub_activity->activity_id == $site[0]->activity_id)
                                                                    @if($prev_step == $sub_activity->sequential_step)
                                                                    {{-- <div class="row btn_switch_show_action pb-3  action_to_complete_child{{ $sub_activity->sub_activity_id }}" data-sam_id="{{$site[0]->sam_id}}" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-document_type="{{ $sub_activity->document_type}}" data-required="" data-substep_same="{{ \Auth::user()->substep_all($site[0]->sam_id, $sub_activity->sub_activity_id) }}"> --}}
                                                                        <div class="row btn_switch_show_action pb-3  action_to_complete_child{{ $sub_activity->sub_activity_id }}" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-document_type="{{ $sub_activity->document_type}}" data-required="" data-substep_same="{{ \Auth::user()->substep_all($site[0]->sam_id, $sub_activity->sub_activity_id) }}">
                                                                            <div class="col-2">                                                                        
                                                                            </div>
                                                                            <div class="col-10">
                                                                                <h6 class="action_to_complete_child_{{$sub_activity->sub_activity_id}}" style="display: unset; {{ $sub_activity->requirements == "required" ? "font-weight: 700" : "" }}">
                                                                                @if (!is_null(\Auth::user()->checkIfSubActUploaded($sub_activity->sub_activity_id, $site[0]->sam_id)))
                                                                                <i class="fa fa-check-circle fa-lg text-success" style="top:10px;"></i>
                                                                                @endif
                                                                                {{ $sub_activity->sub_activity_name }} {{ $sub_activity->requirements == "required" ? "*" : "" }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <hr>
                                                                        {{-- <div class="row btn_switch_show_action  action_to_complete_child{{ $sub_activity->sub_activity_id }}" data-sam_id="{{$site[0]->sam_id}}" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-document_type="{{ $sub_activity->document_type}}" data-required="" data-substep_same="{{ \Auth::user()->substep_all($site[0]->sam_id, $sub_activity->sub_activity_id) }}"> --}}
                                                                            <div class="row btn_switch_show_action  action_to_complete_child{{ $sub_activity->sub_activity_id }}" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-document_type="{{ $sub_activity->document_type}}" data-required="" data-substep_same="{{ \Auth::user()->substep_all($site[0]->sam_id, $sub_activity->sub_activity_id) }}">
                                                                            <div class="col-2">                                                                        
                                                                                <div class="numberCircle">{{ $sub_activity->sequential_step }}</div>                   
                                                                            </div>
                                                                            <div class="col-10">
                                                                                <h6 class="action_to_complete_child_{{$sub_activity->sub_activity_id}}" style="display: unset; {{ $sub_activity->requirements == "required" ? "font-weight: 700" : "" }}">
                                                                                @if (!is_null(\Auth::user()->checkIfSubActUploaded($sub_activity->sub_activity_id, $site[0]->sam_id)))
                                                                                <i class="fa fa-check-circle fa-lg text-success" style="top:10px;"></i>
                                                                                @endif
                                                                                {{ $sub_activity->sub_activity_name }} {{ $sub_activity->requirements == "required" ? "*" : "" }}</h6>
                                                                            </div>
                                                                        </div>

                                                                    @endif
                                                                    @php
                                                                        $prev_step = $sub_activity->sequential_step;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <div class="col-12 mt-5">
                                                            <small>* Required actions are in bold letters</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                    Incorrect Stage Activity Settings
                                                    {{ $subactivity_type }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row loading_div"></div>
                                    <div id="actions_box" class="d-none">

                                    </div>
                                    <x-btn-show-site-details />
                                @endif
                            </div>
            
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    
    

    <script>
    $(document).ready(function(){

        $(".flatpicker").flatpickr({
                minDate: "today"
            });

        $(".btn_switch_show_action").on("click", function(){

            $("#actions_box").removeClass('d-none');
            $("#actions_list").addClass('d-none');

            var active_subactivity = $(this).attr('data-sub_activity').replace("/", " ");
            var active_sam_id = "{{ $site[0]->sam_id }}";
            var sub_activity_id = $(this).attr('data-sub_activity_id');
            var document_type = $(this).attr('data-document_type');
            var substep_same = $(this).attr('data-substep_same');

            var site_category = "{{ $site[0]->site_category }}";
            var activity_id = "{{ $site[0]->activity_id }}";

            $("#sub_activity_id").val(sub_activity_id);

            var program_id = "{{ $site[0]->program_id }}";

            var loader =    '<div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">' +
                                '<div class="loader">' +
                                    '<div class="ball-scale-multiple">' +
                                    '<div></div>' +
                                    '<div></div>' +
                                    '<div></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

            $(".loading_div").html(loader);
            $('#actions_box').html("");

            if (document_type == "permit") {
                if (substep_same == "same") {
                    ajax_action_box (active_sam_id, active_subactivity, sub_activity_id, program_id, site_category, activity_id);
                } else {
                    $.ajax({
                        url: "/subactivity-step/" + sub_activity_id + "/" + active_sam_id + "/" + active_subactivity + "/" + site_category + "/" + activity_id,
                        method: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (resp){
                            if (!resp.error) {

                                $(".loading_div").html("");

                                $('#actions_box').html(resp);
                                
                            } else {

                                $(".loading_div").html("");
                                Swal.fire(
                                    'Error',
                                    resp.message,
                                    'error'
                                )


                            }
                        },
                        error: function (resp){
                            $(".loading_div").html("");
                            Swal.fire(
                                'Error',
                                resp,
                                'error'
                            )

                        }
                    });
                }
            } else {
                ajax_action_box (active_sam_id, active_subactivity, sub_activity_id, program_id, site_category, activity_id) 
            }
            

        });

        function ajax_action_box (active_sam_id, active_subactivity, sub_activity_id, program_id, site_category, activity_id) 
        {

            $.ajax({
                url: "/subactivity-view/" + active_sam_id + "/" + active_subactivity + "/" + sub_activity_id + "/" + program_id + "/" + site_category + "/" + activity_id,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {

                        $(".loading_div").html("");

                        $('#actions_box').html(resp);

                        if (active_subactivity == "LESSOR ENGAGEMENT") {
                            $(".table_lessor_parent").html(
                                '<table class="table_lessor align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                                    '<thead>' +
                                        '<tr>' +
                                            '<th>Date</th>' +
                                            '<th>Method</th>' +
                                            '<th>Remarks</th>' +
                                            '<th>Approved</th>' +
                                        '</tr>' +
                                    '</thead>' +
                                '</table>'
                            );

                            $(".table_lessor").attr("id", "table_lessor_"+sub_activity_id);

                            if (! $.fn.DataTable.isDataTable('#table_lessor_'+sub_activity_id) ){
                                $('#table_lessor_'+sub_activity_id).DataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: {
                                        url: "/get-my-uploaded-file-data/"+sub_activity_id+"/"+$(".ajax_content_box").attr("data-sam_id"),
                                        type: 'GET',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                    },
                                    dataSrc: function(json){
                                        return json.data;
                                    },
                                    // 'createdRow': function( row, data, dataIndex ) {
                                    //     $(row).attr('data-value', data.value);
                                    //     $(row).attr('style', 'cursor: pointer');
                                    // },
                                    columns: [
                                        { data: "date_created" },
                                        { data: "value" },
                                        { data: "status" },
                                        { data: "date_created" },
                                    ],
                                });
                            } 
                        }
                        
                    } else {

                        $(".loading_div").html("");
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )


                    }
                },
                error: function (resp){
                    $(".loading_div").html("");
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                }
            });
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = mm + '/' + dd + '/' + yyyy;


        var sub_activity_id = $("#sub_activity_id").val();
        var sam_id = "{{ $site[0]->sam_id }}";
        
        htmllist = '<div class="table-responsive table_uploaded_parent_log">' +
                '<table class="table_uploaded_log align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%">#</th>' +
                            '<th>Method</th>' +
                            '<th style="width: 35%">Remarks</th>' +
                            '<th style="width: 35%">Status</th>' +
                            '<th>Date Approved</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>' +
            '</div>';

        $('.table_lessor_parent_log').html(htmllist);
        $(".table_uploaded_log").attr("id", "table_uploaded_files_log_"+sub_activity_id);

        if (! $.fn.DataTable.isDataTable("#table_uploaded_files_log_"+sub_activity_id) ){
            $("#table_uploaded_files_log_"+sub_activity_id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-engagement/"+sub_activity_id+"/"+sam_id,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                dataSrc: function(json){
                    return json.data;
                },
                columns: [
                    { data: "id" },
                    { data: "method" },
                    { data: "value" },
                    { data: "status" },
                    { data: "date_created" },
                ],
            });
        } else {
            $("#table_uploaded_files_log_"+sub_activity_id).DataTable().ajax.reload();
        }

        $(document).on("click", ".cancel_engagement_log", function(){
            $('#control_box_log').removeClass('d-none');
            $('#control_form_log').addClass('d-none');
        });

        $(document).on("click", ".contact-lessor_log", function(){
            $('#control_box_log').addClass('d-none');
            $('#control_form_log').removeClass('d-none');

            $("#lessor_method_log").val($(this).attr("data-value"));
            $("#lessor_date_log").val(today);
        });

        $(".save_engagement_log").on("click",  function (e){
            // e.preventDefault();
            var lessor_method = $("#lessor_method_log").val();
            var lessor_approval = $("#lessor_approval_log").val();
            var lessor_remarks = $("#lessor_remarks_log").val();
            // var vendor_id = $("#modal_vendor_id").val();
            var program_id = "{{ $site[0]->program_id }}";
            var sam_id = "{{ $site[0]->sam_id }}";
            var log = $(this).attr("data-log");
            var sub_activity_id = $("#sub_activity_id").val();
            var site_name = "{{ $site[0]->site_name }}";

            $(this).attr('disabled', 'disabled');
            $(this).text('Processing...');

            $("form.engagement_form_log small").text("");

            $.ajax({
                url: "/add-engagement",
                method: "POST",
                data: {
                    lessor_method : lessor_method,
                    lessor_approval : lessor_approval,
                    lessor_remarks : lessor_remarks,
                    sam_id : sam_id,
                    sub_activity_id : sub_activity_id,
                    site_name : site_name,
                    // vendor_id : vendor_id,
                    program_id : program_id,
                    log : log,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {

                        $('#table_uploaded_files_log_'+sub_activity_id).DataTable().ajax.reload(function (){
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            // $("#viewInfoModal").modal("hide");
                            $("#lessor_remarks_log").val("");
                            $(".save_engagement_log").removeAttr('disabled');
                            $(".save_engagement_log").text('Save Engagement');
                        });
                        
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $("." + index + "-errors").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }
                        $(".save_engagement_log").removeAttr('disabled');
                        $(".save_engagement_log").text('Save Engagement');
                    }
                },
                error: function (resp){
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $(".save_engagement_log").removeAttr('disabled');
                    $(".save_engagement_log").text('Save Engagement');
                }
            });
        });

    });

    </script>





