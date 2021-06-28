<div id="site_action_view">
    <div id="site_action_box">

        @if($site[0]->activity_name == "RTB Declaration Approval" && $main_activity == "")

            <x-site-rtb-declaration-approval :rtbdeclaration="$rtbdeclaration" />

        @elseif($site[0]->activity_name == "RTB Declaration" && $main_activity == "")

            <x-site-rtb-declaration />

        @elseif(

            // COLOC APPROVALS 
            $site[0]->activity_name == "PAC Approval" && $main_activity == "" || 
            $site[0]->activity_name == "PAC Director Approval" && $main_activity == "" || 
            $site[0]->activity_name == "PAC VP Approval" && $main_activity == "" || 
            $site[0]->activity_name == "FAC Approval" && $main_activity == "" ||
            $site[0]->activity_name == "FAC Director Approval" && $main_activity == "" ||
            $site[0]->activity_name == "FAC VP Approval" && $main_activity == ""
            
        )
            
            <x-site-p-a-c-approvals :site="$site" />

        @elseif(

            // NEW SITES APPROVALS                                             
            $site[0]->activity_name == "Create PR" && $main_activity == "" && \Auth::user()->profile_id == 8
            // $site[0]->activity_name == "RAM Head PR Approval" && $main_activity == ""  ||
            // $site[0]->activity_name == "NAM PR Approval" && $main_activity == ""  ||
            // $site[0]->activity_name == "Vendor Awarding" && $main_activity == ""

        )   
        
            <x-site-create-pr :site="$site" :activity="$site[0]->activity_name" />

        
        @elseif(

            // NEW SITES APPROVALS                                             
            // $site[0]->activity_name == "Create PR" && $main_activity == "" ||
            $site[0]->activity_name == "RAM Head PR Approval" && $main_activity == "" && \Auth::user()->profile_id == 9 ||
            $site[0]->activity_name == "NAM PR Approval" && $main_activity == "" && \Auth::user()->profile_id == 10 ||
            $site[0]->activity_name == "Vendor Awarding" && $main_activity == "" && \Auth::user()->profile_id == 8

        )   
        
            <x-site-p-r-approval :site="$site" :pr="$pr" :activity="$site[0]->activity_name" />


        @elseif($site[0]->activity_name == "RTB Docs Approval" && $main_activity == "")

            <x-site-rtb-docs-approval :site="$site" />

        @elseif($site[0]->activity_name == "RTB Docs Validation" && $main_activity == "")

            <x-site-rtb-docs-validation  :site="$site"/>

        @elseif($main_activity == "Issue Validation")

            <x-site-issue-validation  :site="$site"/>

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