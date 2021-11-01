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
            $programs = \DB::connection('mysql2')->table('program')->orderBy('program')->get();

            $profiles = \DB::table('profiles')->get();

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
                                                <tr class="bg-dark"  data-stage_activity_id="{{$activity->id}}">
                                                    <form class="stage_activity_update">                                                                        
                                                        
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->category }}" name="category" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_id }}"  name="activity_id" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->profile_id }}"  name="profile_id" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_name }}"  name="activity_name" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_sequence }}"  name="activity_sequence" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->next_activity }}"  name="next_activity" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->return_activity }}"  name="return_activity" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_duration_days }}"  name="activity_duration_days" /></td>
                                                        <td><input type="submit" class="form-control btn-warning" value="Save" /></td>
                                                    
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
                                                                        <form class="stage_activity_profile_update" action="{{ route('save_stage_activities_profiles') }}">     
                                                                            <input type="hidden" value="{{$activity->id}}" name="stage_activity_id">   
                                                                            <input type="hidden" value="{{$activity_profile->id}}" name="id">                                                                                         
                                                                            <td>
                                                                                <input type="submit" class="btn-secondary btn-sm form-control" value="Update" />
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control">
                                                                                    <option value="">Select Profile</option>
                                                                                    @foreach($profiles as $profile)
                                                                                        <option value="{{ $profile->id }}" {{ ( $profile->id == $activity_profile->profile_id) ? "selected" : ""}} >{{ $profile->profile }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                {{-- <input type="text" class="form-control" value="{{ $activity_profile->profile_id }}" name="profile_id" /> --}}
                                                                            </td>
                                                                            <td><input type="text" class="form-control" value="{{ $activity_profile->activity_component }}" name="activity_component"/></td>
                                                                            <td><input type="text" class="form-control" value="{{ $activity_profile->activity_source }}" name="activity_source"/></td>
                                                                        </form>
                                                                    </tr>                                                                    
                                                                    @endforeach
                                                                    <tr>
                                                                        <form id="stage_activity_profile_add{{ $activity->id }}" action="{{ route('save_stage_activities_profiles') }}">                            
                                                                            <input type="hidden" value="{{$activity->id}}" name="stage_activity_id">                                                               
                                                                            <td>
                                                                                <input type="submit" class="btn-primary btn-sm form-control" value="Add" />
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control" name="profile_id">
                                                                                    <option value="">Select Profile</option>
                                                                                    @foreach($profiles as $profile)
                                                                                        <option value="{{ $profile->id }}">{{ $profile->profile }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" class="form-control" value=""  name="activity_component"/></td>
                                                                            <td><input type="text" class="form-control" value="" name="activity_source"/></td>
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

@section('js_scripts')
{{-- <script>
    $(document).on('ready', function () {
        $(document).on("click", ".btn-primary.save_btn", function (e) {
            e.preventDefault();

            console.log("test");
            var id = $(this).attr("id");

            $.ajax({
                url: "/save-stage-activities-profiles",
                method: "POST",
                data: $("#stage_activity_profile_add"+id).serialize(),
                success: function (resp) {
                    if (!resp.error) {
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                },
            });
        });
    });
</script> --}}
@endsection