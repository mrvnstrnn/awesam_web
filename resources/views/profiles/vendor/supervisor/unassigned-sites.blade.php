@extends('layouts.main')

@section('content')
    <style>
        .modalDataEndorsement {
            cursor: pointer;
        }

        table {
            width: 100% !important;
        }
    </style> 

    <ul class="tabs-animated body-tabs-animated nav">

        @php
            // $programs = App\Models\VendorProgram::orderBy('vendor_program')->get();
            $programs = \Auth::user()->getUserProgram();
        @endphp

<input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">

        @foreach ($programs as $program)
            <li class="nav-item">
                <a role="tab" class="nav-link unasigned {{ $loop->first ? 'active' : '' }}" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}" data-program="{{ strtolower(str_replace(" ", "-", $program->program))  }}">
                    <span>{{ $program->program }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($programs as $program)
            <div class="tab-pane tabs-animation fade {{ $loop->first ? 'active show' : '' }}" id="tab-content-{{ $program->program_id  }}" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{ strtoupper($program->program)  }} Unassigned Sites
                                </div>      
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @php
                                        $activity_id = \Auth::user()->getUserProgramAct(6, $program->program_id);
                                    @endphp
                                    <table id="unasigned-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" class="align-middle mb-0 table table-borderless table-striped table-hover unasigned-table new-endorsement-table" 
                                            data-href="{{ route('all.unassignedSites', [\Auth::user()->profile_id, $program->program_id, 6, $activity_id->what_to_load]) }}">
                                        <thead>
                                            <tr>
                                                <th class="d-none d-md-table-cell">Agent</th>
                                                <th class="d-none d-md-table-cell">Date Endorsed</th>
                                                <th class="d-none d-md-table-cell">SAM ID</th>
                                                <th>Site</th>
                                                <th class="text-center">Technology</th>
                                                <th class="text-center  d-none d-sm-table-cell">PLA ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('js_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/supervisor.js') }}"></script>
@endsection

@section('modals')

    <div class="modal fade" id="modal-assign-sites" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Sites</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="agent_form">
                    <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                        <div class="form-row">
                        <input type="hidden" id="sam_id" name="sam_id">
                            @php
                                $agents = \DB::connection('mysql2')
                                        ->table('users')
                                        ->join('user_details', 'user_details.user_id', 'users.id')
                                        ->where('user_details.IS_id', \Auth::user()->id)
                                        ->get();
                            @endphp
                            <select name="agent_id" id="agent_id" class="form-control">
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-assign-sites" data-href="{{ route('assign.agent') }}">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-endorsement" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="form-row content-data">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection