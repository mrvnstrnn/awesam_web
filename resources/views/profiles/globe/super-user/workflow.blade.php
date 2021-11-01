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
            $programs = \DB::connection('mysql2')->table('program')->orderBy('program')->get();
            // dd($programs);
        @endphp

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
                @if($program->program_id == 3)
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{ strtoupper($program->program)  }} Workflow
                                </div>      
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="workflow-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" class="table-sm align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('all.getDataWorkflow', $program->program_id) }}">
                                        <thead>
                                            <tr>
                                                <th width="150px">Category</th>
                                                <th width="80px">ID</th>
                                                <th width="80px">Profile</th>
                                                <th>Activity Name</th>
                                                <th width="80px">SEQ</th>
                                                <th width="80px">Next</th>
                                                <th width="80px">Return</th>
                                                <th width="80px">Days</th>
                                                <th width="80px">Action</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $activities = \DB::table('stage_activities')
                                                        ->where('program_id', ($program->program_id))
                                                        ->get();
                                        @endphp  
                                        <tbody>
                                            @foreach ($activities as $activity)
                                                <tr data-stage_activity_id="{{$activity->id}}">
                                                    <form>

                                                    <td><input type="text" class="form-control" value="{{ $activity->category }}" /></td>
                                                    <td><input type="text" class="form-control" value="{{ $activity->activity_id }}" /></td>
                                                    <td><input type="text" class="form-control" value="{{ $activity->profile_id }}" /></td>
                                                    <td><input type="text" class="form-control" value="{{ $activity->activity_name }}" /></td>
                                                    <td><input type="text" class="form-control" value="{{ $activity->activity_sequence }}" /></td>
                                                    <td><input type="text" class="form-control" value="{{ $activity->next_activity }}" /></td>
                                                    <td><input type="text" class="form-control" value="{{ $activity->return_activity }}" /></td>
                                                    <td><input type="text" class="form-control" value="{{ $activity->activity_duration_days }}" /></td>
                                                    <td><input type="submit" class="form-control btn-primary" value="Save" /></td>
                                                    
                                                    </form>
                                                </tr>
                                                <tr class="border-bottom">                                                    
                                                    <td colspan="9">
                                                        @php
                                                            $activity_profiles = \DB::table('stage_activities_profiles')
                                                                                    ->where('stage_activity_id', $activity->id)
                                                                                    ->get();
                                                        @endphp     
                                                        <div class="p-2 border">
                                                            <table class="table table-xs">
                                                                <thead>
                                                                    <th>Action</th>
                                                                    <th>Profile</th>
                                                                    <th>Activity Component</th>
                                                                    <th>Activity Source</th>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($activity_profiles as $activity_profile)                                                                
                                                                    <tr>
                                                                        <form>
                                                                        <td><input type="submit" class="btn-secondary btn-sm form-control" value="Update" /></td>
                                                                        <td><input type="text" class="form-control" value="{{ $activity_profile->profile_id }}" /></td>
                                                                        <td><input type="text" class="form-control" value="{{ $activity_profile->activity_component }}" /></td>
                                                                        <td><input type="text" class="form-control" value="{{ $activity_profile->activity_source }}" /></td>
                                                                        </form>
                                                                    </tr>                                                                    
                                                                    @endforeach
                                                                    <tr>
                                                                        <form>
                                                                        <td><input type="submit" class="btn-danger btn-sm form-control" value="Add" /></td>
                                                                        <td><input type="text" class="form-control" value="" /></td>
                                                                        <td><input type="text" class="form-control" value="" /></td>
                                                                        <td><input type="text" class="form-control" value="" /></td>
                                                                        </form>
                                                                    </tr>                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection

@section('js_script')
    {{-- <script src="{{ asset('js/super-user.js') }}"></script> --}}
@endsection

{{-- @section('modals')

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
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-outline-danger btn-accept-endorsement" data-complete="false" id="" data-href="{{ route('accept-reject.endorsement') }}">Reject</button>
                    <button type="button" class="btn btn-primary btn-accept-endorsement" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}">Accept Endorsement</button>
                </div>
            </div>
        </div>
    </div>

@endsection --}}