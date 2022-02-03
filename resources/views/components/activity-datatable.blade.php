<style>
    .assigned-sites-table {
        cursor: pointer;
    }

    table {
        width: 100% !important;
    }
</style> 
<style>

    .bg_img_1 {
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.20; 
        height: 100%; 
        width:100%; 
        background-image: url('/images/milestone-gray.jpeg');   
        background-repeat: no-repeat; background-size: 200%;        
    }

    .bg_img_2 {
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.20; 
        height: 100%; 
        width:100%; 
        background-image: url('/images/milestone-orange.jpeg');   
        background-repeat: no-repeat; background-size: 200%;        
    }
    .bg_img_3 {
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.20; 
        height: 100%; 
        width:100%; 
        background-image: url('/images/milestone-blue.jpeg');   
        background-repeat: no-repeat; background-size: 200%;        
    }
    .bg_img_4 {
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.20; 
        height: 100%; 
        width:100%; 
        background-image: url('/images/milestone-green.jpeg');   
        background-repeat: no-repeat; background-size: 200%;        
    }
    .bg_img_5 {
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.20; 
        height: 100%; 
        width:100%; 
        background-image: url('/images/milestone-red.jpeg');   
        background-repeat: no-repeat; background-size: 200%;        
    }
    .bg_img_6 {
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.20; 
        height: 100%; 
        width:100%; 
        background-image: url('/images/milestone-orange-2.jpeg');   
        background-repeat: no-repeat; background-size: 200%;        
    }
    .bg_img_7 {
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.20; 
        height: 100%; 
        width:100%; 
        background-image: url('/images/milestone-blue-2.jpeg');   
        background-repeat: no-repeat; background-size: 200%;        
    }

</style>
<ul class="tabs-animated body-tabs-animated nav">

    @php
        $programs = \Auth::user()->getUserProgram();
        $li_ctr = 0;
    @endphp

    @foreach ($programs as $program)
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
            <div class="dropdown-menu-header py-3 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                <div class="row px-4">
                    <div class="menu-header-content btn-pane-right">
                        <h5 class="menu-header-title text-dark">
                            <i class="header-icon lnr-layers text-dark "></i>
                            {{ $tableheader }}
                        </h5>
                    </div>
                    <div class="btn-actions-pane-right actions-icon-btn">
                        {{-- <button id="show-admin-tasks" type="button" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                            <i class="fa fa-fw fa-lg" aria-hidden="true"></i>
                        </button> --}}
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

                                {{-- @php
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
                                @endif --}}

                                <table id="assigned-sites-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" 
                                    class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table"
                                    data-href="/{{ $ajaxdatatablesource }}/{{ $program->program_id }}/{{ \Auth::user()->profile_id }}/{{ $activitytype }}"
                                    data-program_id="{{ $program->program_id  }}" data-table_loaded="false" data-type="{{ $activitytype }}">
                                    <thead>
                                        <tr></tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table> 

                           </div>
                    @endforeach
                </div>                
            </div>
        </div>

    </div>
</div>

