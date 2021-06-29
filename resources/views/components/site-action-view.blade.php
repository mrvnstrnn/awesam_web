<div id="site_action_view">
    <div class="mb-3">
        @php
        if($site[0]->end_date > now()){
            $badge_color = "success";
        } else {
            $badge_color = "danger";
        }

        @endphp

        @if($mainactivity == "")
            <span class="badge badge-dark text-sm mb-0 p-2">{{ $site[0]->stage_name }}</span>
            <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
        @else
            <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $mainactivity }}</span>
        @endif
    </div>
    <div id="site_action_box">
                

        @if($site[0]->activity_name == "RTB Declaration Approval" && $mainactivity == "" || $site[0]->activity_name == "STS RTB Declaration Approval" && $mainactivity == "")

            <x-site-rtb-declaration-approval :rtbdeclaration="$rtbdeclaration" />

        @elseif($site[0]->activity_name == "RTB Declaration" && $mainactivity == "" || $site[0]->activity_name == "STS RTB Declaration" && $mainactivity == "")

            <x-site-rtb-declaration />

        @elseif(

            // COLOC APPROVALS 
            $site[0]->activity_name == "PAC Approval" && $mainactivity == "" || 
            $site[0]->activity_name == "PAC Director Approval" && $mainactivity == "" || 
            $site[0]->activity_name == "PAC VP Approval" && $mainactivity == "" || 
            $site[0]->activity_name == "FAC Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "FAC Director Approval" && $mainactivity == "" ||
            $site[0]->activity_name == "FAC VP Approval" && $mainactivity == ""
            
        )
            
            <x-site-p-a-c-approvals :site="$site" />

        @elseif(

            // NEW SITES APPROVALS                                             
            $site[0]->activity_name == "Create PR" && $mainactivity == "" && \Auth::user()->profile_id == 8
            // $site[0]->activity_name == "RAM Head PR Approval" && $main_activity == ""  ||
            // $site[0]->activity_name == "NAM PR Approval" && $main_activity == ""  ||
            // $site[0]->activity_name == "Vendor Awarding" && $main_activity == ""

        )   
        
            <x-site-create-pr :site="$site" :activity="$site[0]->activity_name" />

        
        @elseif(

            // NEW SITES APPROVALS                                             
            // $site[0]->activity_name == "Create PR" && $main_activity == "" ||
            $site[0]->activity_name == "RAM Head PR Approval" && $mainactivity == "" && \Auth::user()->profile_id == 9 ||
            $site[0]->activity_name == "NAM PR Approval" && $mainactivity == "" && \Auth::user()->profile_id == 10 ||
            $site[0]->activity_name == "Vendor Awarding" && $mainactivity == "" && \Auth::user()->profile_id == 8

        )   
        
            <x-site-p-r-approval :site="$site" :pr="$pr" :activity="$site[0]->activity_name" />


        @elseif($site[0]->activity_name == "RTB Docs Approval" && $mainactivity == "")

            <x-site-rtb-docs-approval :site="$site" />

        @elseif($site[0]->activity_name == "RTB Docs Validation" && $mainactivity == "")

            <x-site-rtb-docs-validation  :site="$site"/>

        @elseif($site[0]->activity_name == "Schedule JTSS" && $mainactivity == "")

            <x-site-schedule-jtss />

        @elseif($mainactivity == "Issue Validation")

            <x-site-issue-validation  :site="$site"/>

        @else

            @if($mainactivity == "Document Validation" || $site[0]->activity_name == "RAM Documents Validation" || $site[0]->activity_name == "Draft Contract Approval" || $site[0]->activity_name == "Lease Package" || $site[0]->activity_name == "RAM Validation of  Advanced Site Hunting  Documents")

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
<x-site-detail-view :site="$site" :mainactivity="$mainactivity" :sitefields="$site[0]->site_fields" />
