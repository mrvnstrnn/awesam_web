<style>
    .assigned-sites-table {
        cursor: pointer;
    }

    table {
        width: 100% !important;
    }
</style> 
<ul class="tabs-animated body-tabs-animated nav">

    @php
        if (\Request::path() == 'endorsements') {
            $programs = \Auth::user()->getUserProgramEndorsement(\Request::path());
        }

        if (\Auth::user()->profile_id == 1) {
            $user_details = \Auth::user()->getUserDetail()->first();
            $programs = \Auth::user()->getUserProgram($user_details->vendor_id);
        } else {
            $programs = \Auth::user()->getUserProgram();
        }
    
        $li_ctr = 0;

    @endphp
    <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">

    @foreach ($programs as $program)
        {{-- @if(in_array($program->program_id, $allowed_programs)) --}}
            @php
                $li_ctr++;
            @endphp
        <li class="nav-item">
            @if ($li_ctr === 1)
                @php
                    $active = "active";
                @endphp
            @else
                @php
                    $active = "";
                @endphp                
            @endif
            
            <a role="tab" class="nav-link {{ $active }}" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id }}">
                <span>{{ $program->program }}</span>
            </a>
        </li>
        {{-- @endif --}}
    @endforeach
</ul>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header"> 
                <div class="dropdown-menu-header-inner bg-primary">
                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                    <div class="menu-header-content btn-pane-right d-flex justify-content-between button_header_area">
                        <h5 class="menu-header-title">
                            <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                            {{ $tableheader }}
                        </h5>
                        @if (in_array($tableheader, array("New CLP")) && \Auth::user()->profile_id == 8)
                        <button class="btn btn-warning btn-shadow btn-sm btn_create_pr" data-program="{{ $program->program_id  }}">Create PR Memo</button>
                        @endif
                    </div>
                </div>
            </div> 

            <div class="card-body" style="overflow-x: auto; max-width: 100%;">
                <div class="tab-content">
                    @foreach ($programs as $program)


                        
                        @if ($loop->first)
                            <div class="tab-pane tabs-animation fade active show" id="tab-content-{{ $program->program_id  }}" role="tabpanel">            
                        @else
                            <div class="tab-pane tabs-animation fade" id="tab-content-{{ $program->program_id  }}" role="tabpanel">
                        @endif

                                @php
                                    $li_ctr++;

                                    if($program->program_id == 1){
                                        $MiniDashComponent = "datatable-mini-dashboard-newsites";
                                    }
                                    elseif($program->program_id == 3){
                                        $MiniDashComponent = "datatable-mini-dashboard-coloc";
                                    }
                                    elseif($program->program_id == 4){
                                        $MiniDashComponent = "datatable-mini-dashboard-ibs";
                                    }
                                    else {
                                        $MiniDashComponent = "";
                                    }

                                @endphp

                                @if($MiniDashComponent != "")
                                    <x-dynamic-component :component="$MiniDashComponent" :tableheader="$tableheader"/>
                                @endif

                                <table id="assigned-sites-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" 
                                    class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table"
                                    data-href="/{{ $ajaxdatatablesource }}/{{ $program->program_id }}/{{ \Auth::user()->profile_id }}/{{ $activitytype }}"
                                    data-program_id="{{ $program->program_id  }}" data-table_loaded="false">
                                    <thead>
                                        <tr></tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table> 


                                <hr>

                                @if($activitytype=='new endorsements globe' || $activitytype=='new endorsements vendor' || $activitytype=='new endorsements apmo' || $activitytype == 'new endorsements vendor accept')
                                    <div class="text-right mt-2 pt-2 button_endorsement_area">
                                        <button type="button" class="btn btn-primary btn-sm btn-bulk-acceptreject-endorsement btn-shadow" data-activity_name="endorse_site" data-program="{{ strtolower($program->program) }}" data-id="{{ $program->program_id }}" data-complete="true" id="accept{{ strtolower(str_replace(" ", "-", $program->program))  }}" data-href="{{ route('accept-reject.endorsement') }}">
                                            @if (\Auth::user()->profile_id == 12)
                                                Endorse New Sites
                                            @else
                                                Accept Endorsement
                                            @endif
                                        </button>
                                    </div>
                                @endif


                           </div>
                        {{-- @endif --}}
                    @endforeach
                </div>                
            </div>
        </div>

    </div>
</div>