<style>
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
    
</style>    
    
    <input id="modal_sam_id" type="hidden" value="{{ $site[0]->sam_id }}">

    <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card ">

                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <div>
                                            <h5 class="menu-header-title">
                                                {{ $site[0]->site_name }}
                                                @if($site[0]->site_category != null)
                                                    <span class="mr-3 badge badge-secondary"><small>{{ $site[0]->site_category }}</small></span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="btn-actions-pane-right">
                                            @php
                                                if($site[0]->end_date > now()){
                                                    $badge_color = "success";
                                                } else {
                                                    $badge_color = "danger";
                                                }

                                            @endphp

                                            @if($main_activity == "")
                                                <span class="ml-1 badge badge-light text-sm mb-0 p-2">{{ $site[0]->stage_name }}</span>
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
                                            @else
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $main_activity }}</span>
                                            @endif
                                        </div>                                            
                                    </div>
                                </div>
                            </div> 

                            <div class="card-body">
                                @php
                                    $site_details_view ="";
                                    $site_action_view = "";
                                    $show_view = "";

                                    $globe_actions = array(
                                                        "RTB Declaration Approval", 
                                                        "RTB Declaration",
                                                        "RTB Docs Approval",
                                                        "RTB Docs Validation"
                                                    );  
                                    
                                    $forced_actions = array(
                                                        "Document Validation",
                                                    );

                                    if(in_array($site[0]->activity_name, $globe_actions) && $main_activity == ""){
                                        $show_view = "site_action_view";
                                        $site_details_view = 'd-none';
                                    }
                                    else {

                                        if(in_array($main_activity, $forced_actions)){

                                            $show_view = "site_action_view";
                                            $site_details_view = 'd-none';

                                        } 
                                        else {

                                            $show_view = "site_details_view";
                                            $site_action_view = 'd-none';

                                        }

                                    }


                                @endphp

                                <div id="site_action_view" class="{{ $site_action_view }}">
                                    <div id="site_action_box">

                                        @if($site[0]->activity_name == "RTB Declaration Approval" && $main_activity == "")

                                            <x-site-rtb-declaration-approval :rtbdeclaration="$rtbdeclaration" />

                                        @elseif($site[0]->activity_name == "RTB Declaration" && $main_activity == "")

                                            <x-site-rtb-declaration />

                                        @elseif($site[0]->activity_name == "RTB Docs Approval" && $main_activity == "")

                                            <x-site-rtb-docs-approval :site="$site" />

                                        @elseif($site[0]->activity_name == "RTB Docs Validation" && $main_activity == "")

                                            <x-site-rtb-docs-validation  :site="$site"/>

                                        @else

                                            @if($main_activity == "Document Validation")
    
                                                <x-site-rtb-docs-validation  :site="$site" />

                                            @endif

                                        @endif

                                    </div>
                                    <div class="row pt-3 border-top"> 
                                        <div class="col-12 text-center">
                                            <button class="btn-icon btn-pill btn btn-focus" id="site_action_view_switch">
                                                <i class="pe-7s-angle-down-circle pe-2x btn-icon-wrapper"></i>Show Site Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="site_details_view"  class="{{ $site_details_view }}">
                                    <div class="row">                    
                                        <div class="col-12 text-center">
                                            <button class="btn-icon btn-pill btn btn-focus d-none" id="site_details_view_switch">
                                                <i class="pe-7s-angle-up-circle pe-2x btn-icon-wrapper"></i>
                                                @if($main_activity == "")
                                                    {{ $site[0]->activity_name }}
                                                @else
                                                    {{ $main_activity }}
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row  border-bottom mb-3">
                                        <div class="col-12">
                                            <ul class="tabs-animated body-tabs-animated nav">
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link active" id="tab-details" data-toggle="tab" href="#tab-content-details">
                                                        <span>Details</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" id="tab-files" data-toggle="tab" href="#tab-content-activities">
                                                        <span>Forecast</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" id="tab-files" data-toggle="tab" href="#tab-content-files">
                                                        <span>Files</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" id="tab-issues" data-toggle="tab" href="#tab-content-issues">
                                                        <span>Issues</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" id="tab-site_chat" data-toggle="tab" href="#tab-content-site_chat">
                                                        <span>Site Chat</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane tabs-animation fade show active" id="tab-content-details" role="tabpanel">
                                            <x-site-details :site="$site" :sitefields="$site_fields" />
                                        </div>
                                        <div class="tab-pane tabs-animation fade" id="tab-content-activities" role="tabpanel">
                                            {{-- <x-site-activities :site="$site" /> --}}
                                        </div>
                                        <div class="tab-pane tabs-animation fade" id="tab-content-issues" role="tabpanel">
                                            <x-site-issues :site="$site" />
                                        </div>
                                        <div class="tab-pane tabs-animation fade" id="tab-content-files" role="tabpanel">
                                            {{-- <x-site-files :site="$site" /> --}}
                                        </div>
                                        <div class="tab-pane tabs-animation fade" id="tab-content-site_chat" role="tabpanel">
                                            <x-site-chat  :site="$site" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                
                    <div class="col-lg-4 col-md-12 col-sm-12" id="modal_site_right">
                        {{-- <x-site-status :completed="35" :samid="$site[0]->sam_id"/> --}}
                    </div>                
                </div>
            </div>
        </div>
    </div>


    <script>
$(document).ready(() => {

    var sam_id = $('#modal_sam_id').val();

    $.ajax({
        url: "/modal-view-site-component/" + sam_id + "/site-status",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){
            $('#modal_site_right').html("");   
            $('#modal_site_right').html(resp);
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    $.ajax({
        url: "/modal-view-site-component/" + sam_id + "/tab-content-activities",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){
            $('#tab-content-activities').html("");   
            $('#tab-content-activities').html(resp);
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    
    $.ajax({
        url: "/modal-view-site-component/" + sam_id + "/tab-content-files",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){
            $('#tab-content-files').html("");   
            $('#tab-content-files').html(resp);
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    $.ajax({
        url: "/modal-view-site-component/" + sam_id + "/site-modal-site_fields",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){
            $('#site-modal-site_fields').html("");   
            $('#site-modal-site_fields').html(resp);
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    

    
});



        $("#site_action_view_switch").on("click", function(){
            $("#site_action_view").addClass('d-none');
            $("#site_details_view").removeClass('d-none');
            $("#site_details_view_switch").removeClass('d-none');             
        });

        $("#site_details_view_switch").on("click", function(){
            $("#site_action_view").removeClass('d-none');
            $("#site_details_view").addClass('d-none');
            $("#site_details_view_switch").addClass('d-none');             
        });

        $( "#datepicker" ).datepicker();
    

    </script>