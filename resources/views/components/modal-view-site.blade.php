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
    <input id="modal_activity_name" type="hidden" value="{{ str_replace(" ", "_", strtolower($site[0]->activity_name)) }}">
    <input id="modal_site_vendor_id" type="hidden" value="{{ $site[0]->site_vendor_id }}">
    <input id="modal_program_id" type="hidden" value="{{ $site[0]->program_id }}">

    <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card ">

                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                            <h5 class="menu-header-title">
                                                {{ $site[0]->site_name }}
                                                @if($site[0]->site_category != 'none')
                                                    <span class="mr-3 badge badge-secondary"><small>{{ $site[0]->site_category }}</small></span>
                                                @endif
                                            </h5>
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
                                                        "RTB Docs Validation",
                                                        "PAC Approval",
                                                        "PAC Director Approval",
                                                        "PAC VP Approval",
                                                        "FAC Approval",
                                                        "FAC Director Approval",
                                                        "FAC VP Approval",
                                                        "Lessor Approval",

                                                        "STS Assessment",
                                                        "STS Head Endorsement to RAM",

                                                        // "Create PR",
                                                        "RAM Head PR Approval",
                                                        "NAM PR Approval",
                                                        "Vendor Awarding",

                                                        // "Advanced Site Hunting",
                                                        "Schedule JTSS",
                                                        "RAM Validation of  Advanced Site Hunting  Documents",
                                                        "RAM Documents Validation",
                                                        "STS RTB Declaration",
                                                        "STS RTB Declaration Approval",
                                                        "Draft Contract Approval",
                                                        "Lease Package",

                                                        "LOI Creation to Renew",

                                                        "Lessor Docs Approval",
                                                        "Permits Approval",
                                                        "Contract Approval",
                                                        "Lease Package Checklist Approval",

                                                        "Precon Docs Approval",
                                                        "Postcon Docs Approval",

                                                        "Lease Renewal Approval",
                                                        "STS Draft Contract Legal Review",
                                                        "STS Head Draft Contract Legal Approval",
                                                        "Finalize Contract Approval",

                                                        //New Sites
                                                        "RAM Head PR Memo Approval",
                                                        "NAM PR Memo Approval",
                                                        "Set Ariba PR Number to Sites",
                                                        "Vendor Awarding of Sites",
                                                        "Approved SSDS / NTP Validation",

                                                        "Advanced Site Hunting Validation",

                                                        "Approved MOC/NTP RAM Validation",

                                                        "eLAS Approved"

                                                    );  
                                    
                                    $forced_actions = array(
                                                        "Document Validation",
                                                        "Issue Validation",
                                                    );

                                    if(in_array($main_activity, $forced_actions)){
                                        $show_view = "site_action_view";
                                        $site_details_view = 'd-none';
                                    } else {
                                        if( $main_activity != ""){
                                            $show_view = "site_details_view";
                                            $site_action_view = 'd-none';
                                        }
                                        elseif(in_array($site[0]->activity_name, $globe_actions) && $main_activity == ""){
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
                                    }

                                @endphp

                                    <div id="site_action_view" class="{{ $site_action_view }}">
                                        <div class="mb-3">
                                            @php
                                            if (isset($site[0]->end_date)) {

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
                                                <span class="badge badge-dark text-sm mb-0 p-2">{{ isset($site[0]->stage_name) ? $site[0]->stage_name : "" }}</span>
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
                                            @else
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $main_activity }}</span>
                                            @endif
                                        </div>
                                        <div id="site_action_box">
                                                    

                                            @if($site[0]->activity_name == "RTB Declaration Approval" && $main_activity == "" || $site[0]->activity_name == "STS RTB Declaration Approval" && $main_activity == "" )

                                                <x-site-rtb-declaration-approval :rtbdeclaration="$rtbdeclaration" :activityid="$site[0]->activity_id" :sitecategory="$site[0]->site_category" />

                                            @elseif($site[0]->activity_name == "RTB Declaration" && $main_activity == "" || $site[0]->activity_name == "STS RTB Declaration" && $main_activity == "")

                                                <x-site-rtb-declaration :activityid="$site[0]->activity_id" :sitecategory="$site[0]->site_category" />

                                            @elseif(

                                                // COLOC APPROVALS 
                                                $site[0]->activity_name == "PAC Approval" && $main_activity == "" || 
                                                $site[0]->activity_name == "PAC Director Approval" && $main_activity == "" || 
                                                $site[0]->activity_name == "PAC VP Approval" && $main_activity == "" || 
                                                $site[0]->activity_name == "FAC Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "FAC Director Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "FAC VP Approval" && $main_activity == "" ||

                                                // MWAN APPROVALS 
                                                $site[0]->activity_name == "Lessor Docs Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "Permits Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "Contract Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "Lease Package Checklist Approval" && $main_activity == "" ||

                                                
                                                $site[0]->activity_name == "Precon Docs Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "Postcon Docs Approval" && $main_activity == "" ||


                                                $site[0]->activity_name == "Lease Renewal Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "STS Draft Contract Legal Review" && $main_activity == "" ||
                                                $site[0]->activity_name == "STS Head Draft Contract Legal Approval" && $main_activity == "" ||
                                                $site[0]->activity_name == "Finalize Contract Approval" && $main_activity == "" ||

                                                $site[0]->activity_name == "Approved SSDS / NTP Validation" && $main_activity == "" ||
                                                $site[0]->activity_name == "Approved MOC/NTP RAM Validation" ||
                                                $site[0]->activity_name == "eLAS Approved"
                                            
                                                
                                            )
                                                
                                                <x-site-p-a-c-approvals :site="$site" :sitecategory="$site[0]->site_category" :activityid="$site[0]->activity_id" :samid="$site[0]->sam_id" />
{{-- 
                                            @elseif(

                                                NEW SITES APPROVALS                                             
                                                $site[0]->activity_name == "Create PR" && $main_activity == "" && \Auth::user()->profile_id == 8
                                                $site[0]->activity_name == "RAM Head PR Approval" && $main_activity == ""  ||
                                                $site[0]->activity_name == "NAM PR Approval" && $main_activity == ""  ||
                                                $site[0]->activity_name == "Vendor Awarding" && $main_activity == ""

                                            )   
                                            
                                                <x-site-create-pr :site="$site" :activity="$site[0]->activity_name" /> --}}

                                            
                                            @elseif(

                                                // NEW SITES APPROVALS                                             
                                                // $site[0]->activity_name == "Create PR" && $main_activity == "" ||
                                                $site[0]->activity_name == "RAM Head PR Approval" && $main_activity == "" && \Auth::user()->profile_id == 9 ||
                                                $site[0]->activity_name == "NAM PR Approval" && $main_activity == "" && \Auth::user()->profile_id == 10 ||
                                                $site[0]->activity_name == "Vendor Awarding" && $main_activity == "" && \Auth::user()->profile_id == 8

                                            )   
                                            
                                                <x-site-p-r-approval :site="$site" :pr="$pr" :activity="$site[0]->activity_name" />

                                            @elseif(
                                                $site[0]->activity_name == "RAM Head PR Memo Approval" && $main_activity == "" && \Auth::user()->profile_id == 9 ||
                                                $site[0]->activity_name == "NAM PR Memo Approval" && $main_activity == "" && \Auth::user()->profile_id == 10 ||

                                                $site[0]->activity_name == "Set Ariba PR Number to Sites" && $main_activity == "" && \Auth::user()->profile_id == 8 ||

                                                $site[0]->activity_name == "Vendor Awarding of Sites" && $main_activity == "" && \Auth::user()->profile_id == 8 ||
                                                
                                                $site[0]->activity_name == "RAM Head PR Memo Approval" && $main_activity == "" && \Auth::user()->profile_id == 8
                                                
                                            )

                                                <x-pr-memo-approval :site="$site" :samid="$site[0]->sam_id" :prmemo="$pr_memo" :activity="$site[0]->activity_name" :sitecategory="$site[0]->site_category" :activityid="$site[0]->activity_id"  />

                                            @elseif($site[0]->activity_name == "RTB Docs Approval" && $main_activity == "")

                                                <x-site-rtb-docs-approval :site="$site" />

                                            {{-- @elseif($site[0]->activity_name == "Lessor Approval" && $main_activity == "")

                                                <x-site-subactivity-lessor-engagement :site="$site" /> --}}

                                            @elseif($site[0]->activity_name == "RTB Docs Validation" && $main_activity == "")

                                                <x-site-rtb-docs-validation  :site="$site"/>

                                            @elseif($site[0]->activity_name == "Schedule JTSS" && $main_activity == "")

                                                <x-site-schedule-jtss :activityid="$site[0]->activity_id" :samid="$site[0]->sam_id" :sitecategory="$site[0]->site_category" />

                                            @elseif($main_activity == "Issue Validation")

                                                <x-site-issue-validation :site="$site"/>

                                            {{-- @elseif($site[0]->activity_name == "SSDS RAM Validation")

                                                <x-s-s-d-s-ram-ranking :samid="$sam_id" :site="$site" /> --}}

                                            @else
                                                @if($main_activity == "Document Validation" || $site[0]->activity_name == "RAM Documents Validation" || $site[0]->activity_name == "Draft Contract Approval" || $site[0]->activity_name == "Lease Package" || $site[0]->activity_name == "RAM Validation of  Advanced Site Hunting  Documents" || $site[0]->activity_name == "Advanced Site Hunting Validation")

                                                    <x-site-rtb-docs-validation  :site="$site" />

                                                @endif

                                            @endif

                                        </div>
                                        <div class="row pt-3 border-top"> 
                                            <div class="col-12 text-center">
                                                <button class="btn-icon btn-pill btn btn-lg btn-focus" id="site_action_view_switch">
                                                    <i class="pe-7s-angle-down-circle pe-3x pe-va btn-icon-wrapper"></i>Show Site Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- @php
                                    if($main_activity == ""){
                                        $details_show = "";
                                    }
                                    else {
                                        $details_show = "d-none";
                                    }
                                    @endphp --}}

                                    {{-- <div class="{{$site_action_view}}">
                                        <x-site-detail-view :site="$site" :main_activity="$main_activity" :sitefields="$site[0]->site_fields" />
                                    </div> --}}

                                    <div id="site_details_view" class="{{ $site_details_view }}">


                                        <div class="row">      
                                            <div class="col-12 text-center">
                                                <button class="btn-icon btn-pill btn btn-lg btn-focus d-none" id="site_details_view_switch">
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
                                                    <li class="nav-item">
                                                        <a role="tab" class="nav-link" id="tab-site_approval" data-toggle="tab" href="#tab-content-site_approval">
                                                            <span>Site Approvals</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class='mb-3'>
                                            @php

                                            if (isset($site[0]->end_date)) {
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
                                                <span class="badge badge-dark text-sm mb-0 p-2">{{ isset($site[0]->stage_name) ? $site[0]->stage_name : "" }}</span>
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
                                            @else
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $main_activity }}</span>
                                            @endif
                                    
                                        </div>  
                                        <div class="tab-content">
                                    
                                            <div class="tab-pane tabs-animation fade show active" id="tab-content-details" role="tabpanel">
                                                <div id="">
                                    
                                                </div>
                                                <div id="">
                                    
                                                </div>
                                                <x-site-details :site="$site" :sitefields="$site[0]->site_fields" />
                                            </div>
                                            <div class="tab-pane tabs-animation fade" id="tab-content-activities" role="tabpanel">
                                                {{-- <x-site-activities :site="$site" /> --}}
                                                <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                                                    <div class="loader">
                                                        <div class="ball-scale-multiple">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="tab-pane tabs-animation fade" id="tab-content-issues" role="tabpanel">
                                                <x-site-issues :site="$site" />
                                            </div>
                                            <div class="tab-pane tabs-animation fade" id="tab-content-files" role="tabpanel">
                                                {{-- <x-site-files :site="$site" /> --}}
                                                <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                                                    <div class="loader">
                                                        <div class="ball-scale-multiple">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="tab-pane tabs-animation fade" id="tab-content-site_chat" role="tabpanel">
                                                <x-site-chat  :site="$site" />
                                            </div>
        
                                            <div class="tab-pane tabs-animation fade" id="tab-content-site_approval" role="tabpanel">
                                                <x-site-approval-details :site="$site" />
                                            </div>
                                        </div>
                                    </div>

                                {{-- @if (in_array($site[0]->activity_name, $globe_actions) && $main_activity == "")
                                    <x-site-action-view :site="$site" :main_activity="$main_activity" :rtbdeclaration="$rtbdeclaration" :pr="$pr" />
                                @else
                                    @if(!in_array($main_activity, $forced_actions))
                                        <x-site-action-view :site="$site" :main_activity="$main_activity" :rtbdeclaration="$rtbdeclaration" :pr="$pr" />
                                    @else 
                                        <x-site-detail-view :site="$site" :main_activity="$main_activity" :sitefields="$site_fields" />
                                    @endif
                                @endif --}}
                            </div>
                        </div> 
                    </div>
                
                    {{-- <div class="col-lg-4 col-md-12 col-sm-12">

                        <div class="mb-3 profile-responsive card">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg'); background-size: cover;"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <div>
                                            <h5 class="menu-header-title">Site Status</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-0 card-body align-center text-center py-5" style="position: relative;">                        
                                <div id="modal_site_right">
                                    <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                                        <div class="loader">
                                            <div class="ball-scale-multiple">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>                         
                    </div>                 --}}
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
                    console.log(resp);
                    $('#site-modal-site_fields').html("");   
                    $('#site-modal-site_fields').html(resp);
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
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
            

            
        });

    

    </script>