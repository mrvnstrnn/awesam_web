
    @php
        // if (\Auth::user()->profile_id == 1) {
        //     $user_details = \Auth::user()->getUserDetail()->first();
        //     $programs = \Auth::user()->getUserProgram($user_details->vendor_id);
        // } else {
            $programs = \Auth::user()->getUserProgram();
        // }
            $get_user_program_active = \Auth::user()->get_user_program_active()->program_id;
    @endphp
    <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">
  
    @foreach ($programs as $program)

        @if( \Auth::user()->profile_id == 1)

            <div class="row" style="margin-top: 20px;">
                <div class="col-12">
                    <h3 class="mb-3">Teams</h3>
                    @php

                        $vendor = \App\Models\UserDetail::select('user_details.vendor_id')
                                                            ->where('user_id', \Auth::id())
                                                            ->first();

                        $supervisors = \App\Models\UserDetail::select('profiles.profile', 'users.name', 'users.id', 'user_details.image')
                                                        ->join('users', 'users.id', 'user_details.user_id')
                                                        ->join('profiles', 'profiles.id', 'users.profile_id')

                                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                                        ->where('user_programs.program_id', $get_user_program_active)

                                                        ->where('users.profile_id', 3)
                                                        ->where('user_details.vendor_id', $vendor->vendor_id)
                                                        ->where('users.is_test', 0)
                                                        ->get();
                    @endphp
                    <div class="card mb-3">
                        <div class="card-body">
                            @if (count($supervisors) > 0)
                                @foreach ($supervisors as $supervisor)
                                    @php
                                        $agents = \App\Models\UserDetail::select('profiles.profile', 'users.name', 'user_details.image')
                                                            ->join('users', 'users.id', 'user_details.user_id')
                                                            ->join('profiles', 'profiles.id', 'users.profile_id')
                                                            

                                                            ->join('user_programs', 'user_programs.user_id', 'users.id')
                                                            ->where('user_programs.program_id', $get_user_program_active)
                                                        
                                                            ->where('user_details.IS_id', $supervisor->id)
                                                            ->where('users.is_test', 0)
                                                            ->get(); 
                                    @endphp
                                    <div class="row">
                                        <div class="col-3 mb-2 mt-1  border-right" style="text-align: center;">
                                            <div>
                                                @if (!is_null($supervisor->image))
                                                    <img width="70" height="70" class="rounded-circle border border-dark" src="{{ asset('files/'.$supervisor->image) }}" alt="">
                                                @else
                                                    <img width="70" height="70" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">
                                                @endif
                                            </div>
                                            <div style="text-align: center;">
                                                <div><small>{{ $supervisor->name }}</small></div>
                                                <div><small>{{ $supervisor->profile }}</small></div>
                                            </div>
                                        </div>
                                        <div class="col-9 mb-2 mt-1" style="text-align: center;">
                                            <div class="row">
                                                @if (count($agents) > 0)
                                                    @foreach ($agents as $agent)
                                                        <div class="col mb-4" style="min-width: 150px; max-width: 150px;">
                                                            <div>
                                                                @if (!is_null($agent->image))
                                                                    <img width="70" height="70" class="rounded-circle border border-dark" src="{{ asset('files/'.$agent->image) }}" alt="">
                                                                @else
                                                                    <img width="70" height="70" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">
                                                                @endif

                                                                {{-- <img class="rounded-circle" src="images/avatars/2.jpg" alt="" width="70"> --}}
                                                            </div>
                                                            <div style="text-align: center;">
                                                                <div><small>{{ $agent->name }}</small></div>
                                                                <div><small>{{ $agent->profile }}</small></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-12 mb-2 mt-1" style="text-align: center;">
                                                        <h6>No available agent/s.</h6>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            @else
                                <div class="row">
                                    <div class="col-12 mb-2 mt-1" style="text-align: center;">
                                        <h6>No available supervisor/s.</h6>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        
        @else

            @if( \Auth::user()->getUserDetail()->first()->mode == "globe")
                @php
                    $user_program = $program->program_id;
                    if ( $user_program == 3 ) {
                        $categories_array = ["none"];
                        $activity_id_range = ['11', '17'];
                    } else if ( $user_program == 4 ) {
                        $activity_id_range = ['12', '17'];
                        $categories_array = ["BAU", "RETROFIT", "REFARM"];
                    } else {
                        $activity_id_range = ['1', '10'];
                        $categories_array = [""];
                    }
                @endphp

                <div class="row">
                    <div class="col-12">
                        <h3>RTB Tracker</h3>
                    </div>
                </div>
            
                @if ( $user_program == 3 || $user_program == 4)
            
                    @for ($j = 0; $j < count($categories_array); $j++)
                        @php
                        
                        $i = 0;
                        
                        $stage_activities = \DB::table('stage_activities')
                                ->where('program_id', $user_program)
                                ->where('category', $categories_array[$j])
                                ->whereBetween('activity_id', $activity_id_range)
                                ->orderBy('activity_id')
                                ->get();
                        @endphp
                        @if ( $categories_array[$j] != "none" )
                            <h4>{{ $categories_array[$j] }}</h4>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">            
                                    <div class="no-gutters row border">
                                        @foreach ($stage_activities as $stage_activity)
                                            @php
                                                $i ++;
                                            @endphp
                                            <div class="col-sm-3 col-12 border">
                                                <div class="milestone-bg bg_img_{{ $i }}"></div>
            
                                                <div class="widget-chart widget-chart-hover milestone_sites" data-activity_id="{{ $stage_activity->activity_id }}" data-category="{{ $stage_activity->category }}">
                                                    <div class="widget-numbers" id="stage_counter_{{ $stage_activity->id }}">
                                                        {{ \Auth::user()->activities_count($stage_activity->program_id, $stage_activity->activity_id, $categories_array[$j]); }}
                                                    </div>
                                                    <div class="widget-subheading" id="stage_counter_label_{{ $stage_activity->id }}">{{ $stage_activity->activity_name }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-sm-3 col-12 border">
                                            <div class="milestone-bg bg_img_2"></div>
            
                                            <div class="widget-chart widget-chart-hover milestone_sites" data-activity_id="{{ $stage_activity->activity_id }}" data-category="{{ $stage_activity->category }}">
                                                <div class="widget-numbers" id="stage_counter_0">
                                                    {{ \Auth::user()->activities_count($user_program, 0, $categories_array[$j]); }}
                                                </div>
                                                <div class="widget-subheading" id="stage_counter_label_0">RTBd</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                @else
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="main-card card p-5">            
                                <h3 class="text-center">Nothing to see here.</h3>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if($program->program_id == 6)
                <x-towerco-dashboard />
    
            @elseif($program->program_id == 1)

                <x-newsites-dashboard />

            @elseif($program->program_id == 3)

                <x-coloc-dashboard :programid="$get_user_program_active" />

            @elseif($program->program_id == 4)

                <x-ibs-dashboard />

            @elseif($program->program_id == 7)
    
                <x-localcoop-dashboard />

            @elseif($program->program_id == 8)

                <x-coloc-dashboard :programid="$get_user_program_active" />
          
            @endif
        @endif    
      @if ($loop->first)
          @php
              $active_show = "active show";
          @endphp
      @else
          @php
              $active_show = "";
          @endphp
      @endif
  
      <div class="tab-pane tabs-animation fade {{ $active_show }}" id="tab-content-{{ $program->program_id  }}" role="tabpanel"> 



      </div>
    @endforeach    

