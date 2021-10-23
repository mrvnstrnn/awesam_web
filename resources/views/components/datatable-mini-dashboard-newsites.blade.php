
{{-- NEWSITES MINI DASHBOARD --}}

@if(in_array(\Auth::user()->profile_id, array(8, 9, 10)))

    {{-- NEW SITES PR/PO COUNTER  --}}
    @if (in_array($tableheader, array("New CLP", "PR Memo for Approval", "PR Issuance", "Vendor Awarding")))
        <div class="row mb-3 pb-3 text-center border-bottom">
            <div class="col-12">
                <div class="row">
                    <div class="col mt-2">
                        <div>
                            <h1 class="menu-header-title pr_memo_creation_count">0</h1>
                            <h6 class="menu-header-subtitle view_site_memo" style="font-size: 12px; cursor: pointer;" data-value="PR Memo Creation">PR Memo Creation</h6>
                        </div>
                    </div>
                    <div class="col mt-2">
                        <div>
                            <h1 class="menu-header-title ram_head_approval_count">0</h1>
                            <h6 class="menu-header-subtitle view_site_memo" style="font-size: 12px; cursor: pointer;" data-value="RAM Head Approval">RAM Head Approval</h6>
                        </div>
                    </div>
                    <div class="col mt-2">
                        <div>
                            <h1 class="menu-header-title nam_approval_count">0</h1>
                            <h6 class="menu-header-subtitle view_site_memo" style="font-size: 12px; cursor: pointer;" data-value="NAM Approval">NAM Approval</h6>
                        </div>
                    </div>
                    <div class="col mt-2">
                        <div>
                            <h1 class="menu-header-title arriba_pr_no_issuance_number">0</h1>
                            <h6 class="menu-header-subtitle view_site_memo" style="font-size: 12px; cursor: pointer;" data-value="Arriba PR No Issuance">Arriba PR # Issuance</h6>
                        </div>
                    </div>
                    <div class="col mt-2">
                        <div>
                            <h1 class="menu-header-title vendor_awarding_count">0</h1>
                            <h6 class="menu-header-subtitle view_site_memo" style="font-size: 12px; cursor: pointer;" data-value="Vendor Awarding">Vendor Awarding</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- NEW SITES  JTSS  COUNTER  --}}
    @elseif (in_array($tableheader, array("Site Hunting", "Joint Technical Site Survey", "SSDS")))
        <div class="row mb-3 pb-3 text-center border-bottom">
            <div class="col-md-2 col-sm-4 col-xs-4 mt-2">
                <div>
                    <h1 class="menu-header-title">0</h1>
                    <h6 class="menu-header-subtitle" style="font-size: 12px;">Pre-SSDS Pending</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-4 mt-2">
                <div>
                    <h1 class="menu-header-title">0</h1>
                    <h6 class="menu-header-subtitle" style="font-size: 12px;">Site Hunting Scheduling</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-4 mt-2">
                <div>
                    <h1 class="menu-header-title">0</h1>
                    <h6 class="menu-header-subtitle" style="font-size: 12px;">Advanced Site Hunting</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-4 mt-2">
                <div>
                    <h1 class="menu-header-title">0</h1>
                    <h6 class="menu-header-subtitle" style="font-size: 12px;">JTSS Scheduling</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-4 mt-2">
                <div>
                    <h1 class="menu-header-title">0</h1>
                    <h6 class="menu-header-subtitle" style="font-size: 12px;">Joint Technical Site Survey</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-4 mt-2">
                <div>
                    <h1 class="menu-header-title">0</h1>
                    <h6 class="menu-header-subtitle" style="font-size: 12px;">Approved SSDS</h6>
                </div>
            </div>
            {{-- <div class="col-md-2 col-sm-4 col-xs-4 mt-2">
                <div>
                    <h1 class="menu-header-title">0</h1>
                    <h6 class="menu-header-subtitle" style="font-size: 12px;">Total Sites</h6>
                </div>
            </div> --}}
        </div>
    @endif

@endif

