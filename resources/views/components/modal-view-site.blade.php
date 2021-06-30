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
                                                @if($site[0]->site_category != null)
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

                                                        "STS Assessment",
                                                        "STS Head Endorsement to RAM",

                                                        "Create PR",
                                                        "RAM Head PR Approval",
                                                        "NAM PR Approval",
                                                        "Vendor Awarding",
                                                        "Advanced Site Hunting",
                                                        "Schedule JTSS",
                                                        "Schedule JTSS",
                                                        "RAM Validation of  Advanced Site Hunting  Documents",
                                                        "RAM Documents Validation",
                                                        "STS RTB Declaration",
                                                        "STS RTB Declaration Approval",
                                                        "Draft Contract Approval",
                                                        "Lease Package",

                                                        "LOI Creation to Renew"
                                                    );  
                                    
                                    $forced_actions = array(
                                                        "Document Validation",
                                                        "Issue Validation",
                                                    );

                                @endphp

                                @if (in_array($site[0]->activity_name, $globe_actions) && $main_activity == "")
                                    <x-site-action-view :site="$site" :mainactivity="$main_activity" :rtbdeclaration="$rtbdeclaration" :pr="$pr" />
                                @else
                                    @if(!in_array($main_activity, $forced_actions))
                                        <x-site-action-view :site="$site" :mainactivity="$main_activity" :rtbdeclaration="$rtbdeclaration" :pr="$pr" />
                                    @else 
                                        <x-site-detail-view :site="$site" :mainactivity="$main_activity" :sitefields="$site_fields" />
                                    @endif
                                @endif
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