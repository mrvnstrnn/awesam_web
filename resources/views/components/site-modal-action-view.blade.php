<div id="site_action_view" class="">
    <div id="site_action_box">

                
        {{-- <span class="badge badge-danger text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span> --}}

        @if($site[0]->activity_name == "RTB Declaration Approval" && $mainactivity == "" || $site[0]->activity_name == "STS RTB Declaration Approval" && $mainactivity == "" )        

            <x-site-rtb-declaration-approval :site="$site" />


        @elseif($site[0]->activity_name == "RTB Declaration" && $mainactivity == "" || $site[0]->activity_name == "STS RTB Declaration" && $mainactivity == "")

            <x-site-rtb-declaration :activityid="$site[0]->activity_id" :samid="$site[0]->sam_id" :sitecategory="$site[0]->site_category" />

        @elseif(

            // COLOC APPROVALS 
            $site[0]->activity_name == "PAC Approval" && $mainactivity == "" || 
            $site[0]->activity_name == "PAC Director Approval" && $mainactivity == "" || 
            $site[0]->activity_name == "PAC VP Approval" && $mainactivity == "" || 
            $site[0]->activity_name == "FAC Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "FAC Director Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "FAC VP Approval" && $mainactivity == "" ||

            // MWAN APPROVALS 
            $site[0]->activity_name == "Lessor Docs Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "Permits Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "Contract Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "Lease Package Checklist Approval" && $mainactivity == "" ||

            
            $site[0]->activity_name == "Precon Docs Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "Postcon Docs Approval" && $mainactivity == "" ||


            $site[0]->activity_name == "Lease Renewal Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "STS Draft Contract Legal Review" && $mainactivity == "" ||
            $site[0]->activity_name == "STS Head Draft Contract Legal Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "Finalize Contract Approval" && $mainactivity == "" ||

            // $site[0]->activity_name == "Approved SSDS / SSDS NTP Validation" && $mainactivity == "" ||
            $site[0]->activity_name == "Approved MOC/NTP RAM Validation" ||
            $site[0]->activity_name == "Approval MS Lead"
            // $site[0]->activity_name == "Lease Contract Validation"
            
        )
            
            <x-site-p-a-c-approvals :site="$site" :sitecategory="$site[0]->site_category" :activityid="$site[0]->activity_id" :samid="$site[0]->sam_id" />
        
        @elseif(

            // NEW SITES APPROVALS                                             
            // $site[0]->activity_name == "Create PR" && $mainactivity == "" ||
            $site[0]->activity_name == "RAM Head PR Approval" && $mainactivity == "" && \Auth::user()->profile_id == 9 ||
            $site[0]->activity_name == "NAM PR Approval" && $mainactivity == "" && \Auth::user()->profile_id == 10 ||
            $site[0]->activity_name == "Vendor Awarding" && $mainactivity == "" && \Auth::user()->profile_id == 8

        )   
        
            <x-site-p-r-approval :site="$site" :pr="$pr" :activity="$site[0]->activity_name" />

        @elseif(
            $site[0]->activity_name == "RAM Head PR Memo Approval" && $mainactivity == "" && \Auth::user()->profile_id == 9 ||
            $site[0]->activity_name == "NAM PR Memo Approval" && $mainactivity == "" && \Auth::user()->profile_id == 10 ||

            $site[0]->activity_name == "Set Ariba PR Number to Sites" && $mainactivity == "" && \Auth::user()->profile_id == 8 ||

            $site[0]->activity_name == "Vendor Awarding of Sites" && $mainactivity == "" && \Auth::user()->profile_id == 8 ||
            
            $site[0]->activity_name == "RAM Head PR Memo Approval" && $mainactivity == "" && \Auth::user()->profile_id == 8
            
        )

            <x-pr-memo-approval :site="$site" :samid="$site[0]->sam_id" :prmemo="$pr_memo" :activity="$site[0]->activity_name" :sitecategory="$site[0]->site_category" :activityid="$site[0]->activity_id"  />

        @elseif($site[0]->activity_name == "RTB Docs Approval" && $mainactivity == "")

            <x-site-rtb-docs-approval :site="$site" />

        @elseif($site[0]->activity_name == "eLAS Details")

            <x-elas-approved  :site="$site"/>

        @elseif($site[0]->activity_name == "eLAS Approval Details")

            <x-elas-approval-docs :site="$site"/>


        @elseif($site[0]->activity_name == "AEPM Validation and Scheduling"  && \Auth::user()->profile_id == 26)

            <x-aepm-schedule-validation  :site="$site"/>

        @elseif($site[0]->activity_name == "Approved SSDS / SSDS NTP Validation")

            <x-site-approved-ssds-ntp-validation  :site="$site"/>

        @elseif($site[0]->activity_name == "Schedule JTSS" && $mainactivity == "")

            <x-site-schedule-jtss :activityid="$site[0]->activity_id" :samid="$site[0]->sam_id" :sitecategory="$site[0]->site_category" />

        @elseif($mainactivity == "Issue Validation")

            <x-site-issue-validation :site="$site"/>

        @else

            @if($mainactivity == "Document Validation" || $site[0]->activity_name == "RAM Documents Validation" || $site[0]->activity_name == "Draft Contract Approval" || $site[0]->activity_name == "Lease Package" || $site[0]->activity_name == "RAM Validation of Advanced Site Hunting  Documents" || $site[0]->activity_name == "Advanced Site Hunting Validation")
                
                <x-site-rtb-docs-validation  :site="$site" />
            @else 
            <div class="text-center col-12 pb-5">
                <img src="/images/construction.gif"/>
                <H1 class="">Action Component Not Yet Configured</H1>
                <div>Activity Name: {{ $site[0]->activity_name }} | 
                Program ID: {{ $site[0]->program_id }} |
                SAM ID: {{ $site[0]->sam_id }}</div>
                <button class="btn btn-lg mt-5 btn-shadow btn-primary mark_as_complete" type="button">Move To Next Activity</button>
            </div>
            @endif

        @endif

    </div>
    <x-btn-show-site-details />
</div>
<div id="site_details_view" class="d-none">
    <x-site-modal-details-view :site="$site" :mainactivity="$mainactivity"/>
</div>

<script>


    $(document).ready(function() {

        $(".mark_as_complete").on("click", function() {
            $(".mark_as_complete").attr("disabled", "disabled");
            $(".mark_as_complete").text("Processing...");

            var sam_id = ["{{ $site[0]->sam_id }}"];
            var activity_name = "mark_as_complete";
            var site_category = ["{{ $site[0]->site_category }}"];
            var activity_id = ["{{ $site[0]->activity_id }}"];
            var program_id = "{{ $site[0]->program_id }}";

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    activity_name : activity_name,
                    site_category : site_category,
                    activity_id : activity_id,
                    program_id : program_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Mark as Complete");

                        $("#viewInfoModal").modal("hide");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Mark as Complete");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".mark_as_complete").removeAttr("disabled");
                    $(".mark_as_complete").text("Mark as Complete");
                }
            });

        });
        
    });
</script>