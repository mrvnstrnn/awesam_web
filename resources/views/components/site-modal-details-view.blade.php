

<div id="site_details_view" class="">
    <div class="row">      
        <div class="col-12 text-center">
            <button class="btn-icon btn-pill btn btn-lg btn-focus d-none" id="site_details_view_switch">
                <i class="pe-7s-angle-up-circle pe-2x btn-icon-wrapper"></i>
                @if($mainactivity == "")
                    {{ $site[0]->activity_name }}
                @else
                    {{ $mainactivity }}
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
    <div class="tab-content">

        <div class="tab-pane tabs-animation fade show active" id="tab-content-details" role="tabpanel">
            {{-- <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                <div class="loader">
                    <div class="ball-scale-multiple">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>         --}}
            <x-site-details :site="$site" :sitefields="[]" />
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
            {{-- <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                <div class="loader">
                    <div class="ball-scale-multiple">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>         --}}
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
            {{-- <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                <div class="loader">
                    <div class="ball-scale-multiple">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>         --}}
            <x-site-chat  :site="$site" />
        </div>

        <div class="tab-pane tabs-animation fade" id="tab-content-site_approval" role="tabpanel">
            <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                <div class="loader">
                    <div class="ball-scale-multiple">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>        
            {{-- <x-site-approval-details :site="$site" /> --}}
        </div>
    </div>
</div>

<script>

    $(document).ready(() => {

        var sam_id = "{{ $site[0]->sam_id }}";

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