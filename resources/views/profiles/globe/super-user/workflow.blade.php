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
                @if($program->program_id == 3 || $program->program_id == 4)

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
                                <div class="bg-light py-3 border">
                                    <h4 class="pl-3">Add Activity</h4>
                                    <form class="stage_activity_update" action="{{ route('save_stage_activities') }}">  
                                        <div class="container">
                                            <input type="hidden" class="form-control form-control-sm" name="program_id" value="{{ $program->program_id }}">
                                            <input type="hidden" class="form-control form-control-sm" name="stage_id" value="1">
                                            <div class="row py-2 align-items-end">
                                                <div class="col-3">
                                                    <label for="" class="text-dark">Category</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold" name="category" />
                                                </div>
                                                <div class="col-1">
                                                    <label for="" class="text-dark">Act ID</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="activity_id" />
                                                </div>
                                                <div class="col-1">
                                                    <label for="" class="text-dark">Profile</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="profile_id" />
                                                </div>
                                                <div class="col-7">
                                                    <label for="" class="text-dark">Activity Name</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="activity_name" />
                                                </div>
                                            </div>
                                            <div class="row py-2 align-items-end">
                                                <div class="col-1">
                                                    <label for="" class="text-dark">Next</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="next_activity" />
                                                </div>
                                                <div class="col-1">
                                                    <label for="" class="text-dark">Return</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="return_activity" />
                                                </div>
                                                <div class="col-1">
                                                    <label for="" class="text-dark">Sequence</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="activity_sequence" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="" class="text-dark">Duration Days</label>
                                                    <input type="text" class="form-control form-control-sm  text-white font-weight-bold"  name="activity_duration_days" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="" class="text-dark">Activity Type</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="activity_type" />
                                                </div>
                                                <div class="col-2">
                                                    <label for="" class="text-dark">Subactivity Type</label>
                                                    <input type="text" class="form-control form-control-sm text-white font-weight-bold"  name="subactivities_type" />
                                                </div>
                                                <div class="col-3">
                                                    <td><input type="submit" class="form-control form-control-sm btn-danger" value="Add" /></td>
                                                </div>
                                            </div>
                                        </div>    
                                    </form>
                                </div>
                                <div class="mt-5">
                                    <H3>Workflow</H3>
                                    @php
                                    $activities = \DB::table('stage_activities')
                                                ->where('program_id', ($program->program_id))
                                                ->orderBy('category', 'asc')
                                                ->orderBy('activity_id', 'asc')
                                                ->get();
                                    @endphp  
                                    @foreach ($activities as $activity)
                                        <div class="bg-dark">
                                            <form class="stage_activity_update" action="{{ route('save_stage_activities') }}">                                                                        
                                                <div class="container">
                                                    <input type="hidden" class="form-control form-control-sm" name="id" value="{{ $activity->id }}">
                                                    <input type="hidden" class="form-control form-control-sm" name="program_id" value="{{ $activity->program_id }}">
                                                    <div class="row py-2 align-items-end">
                                                        <div class="col-3">
                                                            <label for="" class="text-light">Category</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->category }}" name="category" />
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="" class="text-light">Act ID</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->activity_id }}"  name="activity_id" />
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="" class="text-light">Profile</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->profile_id }}"  name="profile_id" />
                                                        </div>
                                                        <div class="col-7">
                                                            <label for="" class="text-light">Activity Name</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->activity_name }}"  name="activity_name" />
                                                        </div>
                                                    </div>
                                                    <div class="row py-2 align-items-end">
                                                        <div class="col-1">
                                                            <label for="" class="text-light">Next</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->next_activity }}"  name="next_activity" />
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="" class="text-light">Return</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->return_activity }}"  name="return_activity" />
                                                        </div>
                                                        <div class="col-1">
                                                            <label for="" class="text-light">Sequence</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->activity_sequence }}"  name="activity_sequence" />
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="" class="text-light">Duration Days</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->activity_duration_days }}"  name="activity_duration_days" />
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="" class="text-light">Activity Type</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->activity_type }}"  name="activity_type" />
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="" class="text-light">Subactivity Type</label>
                                                            <input type="text" class="form-control form-control-sm bg-dark text-white font-weight-bold" value="{{ $activity->subactivities_type }}"  name="subactivities_type" />
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="submit" class="form-control form-control-sm btn-warning" value="Save" /></td>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
<<<<<<< HEAD
                                        <div class="p-2 border">
                                            <div class="card">
                                                <div class="card-body">
                                                    <ul class="tabs-animated-shadow nav-justified tabs-animated nav">
                                                        <li class="nav-item">
                                                            <a role="tab" class="nav-link active" id="tab-c1-0{{$activity->id}}" data-toggle="tab" href="#tab-animated1-0{{$activity->id}}" aria-selected="true">
                                                                <span class="nav-text">Components</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a role="tab" class="nav-link" id="tab-c1-1{{$activity->id}}" data-toggle="tab" href="#tab-animated1-1{{$activity->id}}" aria-selected="false">
                                                                <span class="nav-text">Sub Activities</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a role="tab" class="nav-link" id="tab-c1-2{{$activity->id}}" data-toggle="tab" href="#tab-animated1-2{{$activity->id}}" aria-selected="false">
                                                                <span class="nav-text">Notifications</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab-animated1-0{{$activity->id}}" role="tabpanel">
                                                            @php
                                                            $activity_profiles = \DB::table('stage_activities_profiles')
                                                                                    ->where('stage_activity_id', $activity->id)
                                                                                    ->get();
                                                            @endphp     
                    
                                                            <table class="table table-sm">
=======
                                        @php
                                            $activities = \DB::table('stage_activities')
                                                        ->where('program_id', ($program->program_id))
                                                        ->orderBy('activity_id', 'asc')
                                                        ->get();
                                        @endphp  
                                        <tbody>
                                            @foreach ($activities as $activity)
                                                <tr class="bg-dark" data-stage_activity_id="{{$activity->id}}">
                                                    <form class="stage_activity_update" action="{{ route('save_stage_activities') }}" target="_blank">                                                                        
                                                        <input type="hidden" class="form-control" name="id" value="{{ $activity->id }}">
                                                        <input type="hidden" class="form-control" name="program_id" value="{{ $activity->program_id }}">
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->category }}" name="category" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_id }}"  name="activity_id" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->profile_id }}"  name="profile_id" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_name }}"  name="activity_name" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_sequence }}"  name="activity_sequence" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->next_activity }}"  name="next_activity" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->return_activity }}"  name="return_activity" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_duration_days }}"  name="activity_duration_days" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->activity_type }}"  name="activity_type" /></td>
                                                        <td><input type="text" class="form-control bg-dark text-white font-weight-bold" value="{{ $activity->subactivities_type }}"  name="subactivities_type" /></td>
                                                        <td><input type="submit" class="form-control btn-warning" value="Save" /></td>
                                                    
                                                    </form>
                                                </tr>
                                                <tr class="border-bottom">                                                    
                                                    <td colspan="11">
                                                        @php
                                                            $activity_profiles = \DB::table('stage_activities_profiles')
                                                                                    ->where('stage_activity_id', $activity->id)
                                                                                    ->get();
                                                        @endphp     
                                                        <div class="p-2 border">
                                                            <table class="table table-xs">
>>>>>>> 19b2f44cc27b1c6c41c768ab1b7b19cdc58e627a
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
<<<<<<< HEAD
                                                                                <input type="submit" class="btn-secondary btn-sm form-control form-control-sm" value="Update" />
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control form-control-sm">
=======
                                                                                <input type="submit" class="btn-secondary btn-sm form-control" value="Update" />
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control">
>>>>>>> 19b2f44cc27b1c6c41c768ab1b7b19cdc58e627a
                                                                                    <option value="">Select Profile</option>
                                                                                    @foreach($profiles as $profile)
                                                                                        <option value="{{ $profile->id }}" {{ ( $profile->id == $activity_profile->profile_id) ? "selected" : ""}} >{{ $profile->profile }}</option>
                                                                                    @endforeach
                                                                                </select>
<<<<<<< HEAD
                                                                                {{-- <input type="text" class="form-control form-control-sm" value="{{ $activity_profile->profile_id }}" name="profile_id" /> --}}
                                                                            </td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="{{ $activity_profile->activity_component }}" name="activity_component"/></td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="{{ $activity_profile->activity_source }}" name="activity_source"/></td>
=======
                                                                                {{-- <input type="text" class="form-control" value="{{ $activity_profile->profile_id }}" name="profile_id" /> --}}
                                                                            </td>
                                                                            <td><input type="text" class="form-control" value="{{ $activity_profile->activity_component }}" name="activity_component"/></td>
                                                                            <td><input type="text" class="form-control" value="{{ $activity_profile->activity_source }}" name="activity_source"/></td>
                                                                        </form>
                                                                        <form id="stage_activity_profile_delete" action="{{ route('delete_stage_activities_profiles', $activity_profile->id) }}">
                                                                            <td>
                                                                                <input type="submit" class="btn-danger btn-sm form-control" value="Delete" />
                                                                            </td>
>>>>>>> 19b2f44cc27b1c6c41c768ab1b7b19cdc58e627a
                                                                        </form>
                                                                    </tr>                                                                    
                                                                    @endforeach
                                                                    <tr>
<<<<<<< HEAD
                                                                        <form id="stage_activity_profile_add{{ $activity->id }}" action="{{ route('save_stage_activities_profiles') }}">                            
                                                                            <input type="hidden" value="{{$activity->id}}" name="stage_activity_id">                                                               
                                                                            <td>
                                                                                <input type="submit" class="btn-primary btn-sm form-control form-control-sm" value="Add" />
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control form-control-sm" name="profile_id">
=======
                                                                        <form id="stage_activity_profile_add{{ $activity->id }}" action="{{ route('save_stage_activities_profiles') }}" target="_blank">
                                                                            <input type="hidden" value="{{$activity->id}}" name="stage_activity_id">
                                                                            <td>
                                                                                <input type="submit" class="btn-primary btn-sm form-control" value="Add" />
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control" name="profile_id">
>>>>>>> 19b2f44cc27b1c6c41c768ab1b7b19cdc58e627a
                                                                                    <option value="">Select Profile</option>
                                                                                    @foreach($profiles as $profile)
                                                                                        <option value="{{ $profile->id }}">{{ $profile->profile }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
<<<<<<< HEAD
                                                                            <td><input type="text" class="form-control form-control-sm" value=""  name="activity_component"/></td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="" name="activity_source"/></td>
=======
                                                                            <td><input type="text" class="form-control" value=""  name="activity_component"/></td>
                                                                            <td><input type="text" class="form-control" value="" name="activity_source"/></td>
>>>>>>> 19b2f44cc27b1c6c41c768ab1b7b19cdc58e627a
                                                                        </form>
                                                                    </tr>                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
<<<<<<< HEAD
                                                        <div class="tab-pane" id="tab-animated1-1{{$activity->id}}" role="tabpanel">
                                                            @php
                                                            $sub_activities = \DB::table('sub_activity')
                                                                                    ->where('program_id', $program->program_id)
                                                                                    ->where('category', $activity->category)
                                                                                    ->where('activity_id', $activity->activity_id)
                                                                                    ->get();
                                                            // if(count($sub_activities)>0){
                                                            //     dd($sub_activities);
                                                            // }
                                                            @endphp     
                    
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <th>Action</th>
                                                                    <th width="80px;">Seq Step</th>
                                                                    <th>Sub Activity</th>
                                                                    <th>Sub Activity Action</th>
                                                                    <th>Requirements</th>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($sub_activities as $sub_activity)                                                                
                                                                    <tr>
                                                                        <form class="sub_activity_update" action="">     
                                                                            <input type="hidden" value="{{$sub_activity->sub_activity_id}}" name="sub_activity_id">   
                                                                            <td><input type="submit" class="btn-secondary btn-sm form-control form-control-sm" value="Update" /></td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="{{ $sub_activity->sequential_step }}" name="sequential_step"/></td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="{{ $sub_activity->sub_activity_name }}" name="sub_activity_name"/></td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="{{ $sub_activity->action }}" name="action"/></td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="{{ $sub_activity->requirements }}" name="requirements"/></td>
                                                                        </form>
                                                                    </tr>                                                                    
                                                                    @endforeach
                                                                    {{-- <tr>
                                                                        <form id="stage_activity_profile_add{{ $activity->id }}" action="{{ route('save_stage_activities_profiles') }}">                            
                                                                            <input type="hidden" value="{{$activity->id}}" name="stage_activity_id">                                                               
                                                                            <td>
                                                                                <input type="submit" class="btn-primary btn-sm form-control form-control-sm" value="Add" />
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control form-control-sm" name="profile_id">
                                                                                    <option value="">Select Profile</option>
                                                                                    @foreach($profiles as $profile)
                                                                                        <option value="{{ $profile->id }}">{{ $profile->profile }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" class="form-control form-control-sm" value=""  name="activity_component"/></td>
                                                                            <td><input type="text" class="form-control form-control-sm" value="" name="activity_source"/></td>
                                                                        </form>
                                                                    </tr>                                                                     --}}
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class="tab-pane" id="tab-animated1-2{{$activity->id}}" role="tabpanel">
                                                            Notifications
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="divider"></div>
=======
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
>>>>>>> 19b2f44cc27b1c6c41c768ab1b7b19cdc58e627a
                                    @endforeach
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