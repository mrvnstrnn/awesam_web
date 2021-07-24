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
        // if (\Request::path() == 'endorsements') {
        //     $programs = \Auth::user()->getUserProgramEndorsement(\Request::path());
        // } else {
        // }
        if (\Auth::user()->profile_id == 1) {
            $user_details = \Auth::user()->getUserDetail()->first();
            $programs = \Auth::user()->getUserProgram($user_details->vendor_id);
        } else {
            $programs = \Auth::user()->getUserProgram();
        }
    @endphp
    <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">

    @foreach ($programs as $program)
        <li class="nav-item">
            @if ($loop->first)
                @php
                    $active = "active";
                @endphp
            @else
                @php
                    $active = "";
                @endphp                
            @endif
            
            <a role="tab" class="nav-link {{ $active }}" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
                <span>{{ $program->program }}</span>
            </a>
        </li>
    @endforeach
</ul>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header"> 
                <div class="dropdown-menu-header-inner bg-primary">
                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                    <div class="menu-header-content btn-pane-right d-flex justify-content-between">
                        <h5 class="menu-header-title">
                            <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                            {{ $tableheader }}
                        </h5>
                        @if ($tableheader == "PR / PO" && \Auth::user()->profile_id == 8)
                        <button class="btn btn-primary btn-sm btn_create_pr">Create PR / PO</button>
                        @endif
                    </div>
                </div>
            </div> 

            {{-- <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                 {{ $tableheader }}
                </div>
            </div> --}}
            <div class="card-body">
                <div class="tab-content">
                    @foreach ($programs as $program)
                        @php
                            // dd(route('doc_validations.list', [$program->program_id]));
                        @endphp
                        @if ($loop->first)
                            <div class="tab-pane tabs-animation fade active show" id="tab-content-{{ $program->program_id  }}" role="tabpanel">            
                        @else
                            <div class="tab-pane tabs-animation fade" id="tab-content-{{ $program->program_id  }}" role="tabpanel">
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
                                @if($activitytype=='new endorsements globe' || $activitytype=='new endorsements vendor')
                                    @if (\Auth::user()->profile_id != 8 && $program->program_id == 5)
                                        <div class="text-right mt-2 pt-2">
                                            <button type="button" class="btn btn-primary btn-sm btn-bulk-acceptreject-endorsement btn-shadow" data-activity_name="endorse_site" data-program="{{ strtolower($program->program) }}" data-id="{{ $program->program_id }}" data-complete="true" id="accept{{ strtolower(str_replace(" ", "-", $program->program))  }}" data-href="{{ route('accept-reject.endorsement') }}"  data-activity_name="endorse_site">
                                                @if (\Auth::user()->profile_id == 12)
                                                    Endorse New Sites
                                                @else
                                                    Accept Endorsement
                                                @endif
                                            </button>
                                        </div>
                                    @endif
                                @endif
                           </div>
                    @endforeach
                </div>                
            </div>
        </div>
    </div>
</div>

