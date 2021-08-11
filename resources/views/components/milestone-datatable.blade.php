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

            $route = Route::current();
            $slug = $route->parameters['slug'];
            $slugs = \Auth::user()->getAllNavigation()->where('slug', $slug)->get();

            $prog = \DB::connection('mysql2')->table('profile_permissions')
                ->select('program_id')
                ->distinct()
                ->where('permission_id', $slugs[0]->permission_id)
                ->where('profile_id', \Auth::user()->profile_id)
                ->get();

            $allowed_programs = array();

            foreach($prog as $pg){
                array_push($allowed_programs, $pg->program_id);
            }

            $li_ctr = 0;

        }
    @endphp
    <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">

    @foreach ($programs as $program)
        @if(in_array($program->program_id, $allowed_programs))
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
            
            <a role="tab" class="nav-link {{ $active }}" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
                <span>{{ $program->program }}</span>
            </a>
        </li>
        @endif
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
                        @if ($tableheader == "PR / PO" && \Auth::user()->profile_id == 8)
                        <button class="btn btn-warning btn-shadow btn-sm btn_create_pr">Create PR Memo</button>
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

                        @if(in_array($program->program_id, $allowed_programs))
                        @php
                            $li_ctr++;
                        @endphp
        
                        @if (\Auth::user()->profile_id == 6 && $program->program_id == 3)
                                                   
                            <button class="mb-3 btn btn-dark show-filters"><i class="fa fa-fw fa-lg" aria-hidden="true"></i> Filters</button>

                            <div class="filter_text d-none">
                                <label>Filtering: </label>

                            </div>

                            <div id="filters-box" class="d-none bg-light rounded border p-3 mb-3">
                                <form id="coloc-filters-form">
                                    <div class="row">
                                        <div class="col-sm-4 col-md-4 col-12">
                                            <div class="form-group">
                                                <label>Site Type</label>
                                                {{-- <input type="text" class="form-control" name="site_type" /> --}}
                                                <select name="site_type" id="site_type" class="form-control">
                                                    <option value="">-</option>
                                                    <option value="GREENFIELD">GREENFIELD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-12">
                                            <div class="form-group">
                                                <label>Program</label>
                                                <select name="program" id="program" class="form-control">
                                                    <option value="">-</option>
                                                    <option value="ENABLER">ENABLER</option>
                                                    <option value="WTTX">WTTX</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-12">
                                            <div class="form-group">
                                                <label>Technology</label>
                                                <select name="technology" id="technology" class="form-control">
                                                    <option value="">-</option>
                                                    <option value="CARRIER UPGRADE">CARRIER UPGRADE</option>
                                                    <option value="L21">L21</option>
                                                    <option value="FE TO GE">FE TO GE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <p>Note 1: By clicking 'Clear Filter' will remove the filter on the table.</p> --}}
                                </form>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="button" class="pull-right btn btn-primary filter-records">Filter Records</button>
                                        <button type="button" class="pull-right btn btn-success mr-1 clear-records">Clear Filter</button>
                                        <button type="button" class="pull-right btn btn-secondary mr-1 close-filters">Close</button>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                    {{-- @if (\Auth::user()->profile_id != 8 && $program->program_id == 5) --}}
                                        <div class="text-right mt-2 pt-2 button_endorsement_area">
                                            <button type="button" class="btn btn-primary btn-sm btn-bulk-acceptreject-endorsement btn-shadow" data-activity_name="endorse_site" data-program="{{ strtolower($program->program) }}" data-id="{{ $program->program_id }}" data-complete="true" id="accept{{ strtolower(str_replace(" ", "-", $program->program))  }}" data-href="{{ route('accept-reject.endorsement') }}"  data-activity_name="endorse_site">
                                                @if (\Auth::user()->profile_id == 12)
                                                    Endorse New Sites
                                                @else
                                                    Accept Endorsement
                                                @endif
                                            </button>
                                        </div>
                                    {{-- @endif --}}
                                @endif
                           </div>
                        @endif
                    @endforeach
                </div>                
            </div>
        </div>
    </div>
</div>

