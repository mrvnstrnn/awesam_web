@extends('layouts.main')

@section('content')

    <x-assigned-sites />

    <ul class="tabs-animated body-tabs-animated nav">

        @php
            $programs = \Auth::user()->getUserProgram();
        @endphp
        <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">

        @foreach ($programs as $program)
            <li class="nav-item">
                @if ($loop->first)
                    <a role="tab" class="nav-link active" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
                @else
                    <a role="tab" class="nav-link" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
                @endif
                    <span>{{ $program->program }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">

        @foreach ($programs as $program)
            @if ($loop->first)
            <div class="tab-pane tabs-animation fade active show" id="tab-content-{{ $program->program_id  }}" role="tabpanel">            
            @else
            <div class="tab-pane tabs-animation fade" id="tab-content-{{ $program->program_id  }}" role="tabpanel">
            @endif
                <div class="row">
                    <div class="col-md-9">
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                Assigned Sites
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="assigned-sites-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" 
                                    class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table"
                                    data-href="{{ route('agent_assigned_sites.list', [$program->program_id]) }}"
                                    data-program_id="{{ $program->program_id  }}"
                                    >
                                    <thead>
                                        <tr></tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>                        
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                 Sites Stages
                                </div>
                            </div>

                            @php
                                $program_stages = App\Models\ProgramStage::where("program_id", $program->program_id)
                                                                        ->orderBy("stage_sequence")
                                                                        ->get();
                            @endphp
                            <ul class="list-group list-group-flush">
                            @foreach ($program_stages as $stage)
                                <li class="list-group-item" style="border: 1px solid rgba(0, 0, 0, 0.125);">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">{{ $stage->stage_name }}</div>
                                                <div class="widget-subheading">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper mt-1">
                                            <div class="progress-bar-xs progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
                                                </div>
                                            </div>
                                        </div>                                                    
                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@section('js_script')

    <script type="text/javascript" src="/js/assigned-sites.js"></script>  

@endsection