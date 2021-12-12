
    @php
        if (\Auth::user()->profile_id == 1) {
            $user_details = \Auth::user()->getUserDetail()->first();
            $programs = \Auth::user()->getUserProgram($user_details->vendor_id);
        } else {
            $programs = \Auth::user()->getUserProgram();
        }
    @endphp
    <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">
  
    @foreach ($programs as $program)

        @if( \Auth::user()->profile_id == 1)

            @php
                $sites_per_region = \DB::table('view_site_totals_per_vendor_per_region')
                                    ->where('program_id', $program->program_id)
                                    ->where('site_vendor_id', 1)
                                    ->get();
            @endphp


            <h3>Sites</h3>
            <div class="row" style="margin-top: 20px;">
                @foreach ($sites_per_region as $site_count)
                <div class="col">
                    <div class="mb-3 card">
                        <div class="widget-chart widget-chart2 text-left p-0">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                                    <div class="widget-chart-flex">
                                        <div class="widget-title  text-muted text-uppercase">

                                            {{($site_count->sam_region_name <>'') ? $site_count->sam_region_name : "SAM Region Not Set"}}
                                        </div>
                                    </div>
                                    <div class="widget-numbers">
                                        <span class="opacity-10 text-secondary pr-2">
                                            <i class="fa fa-upload"></i>
                                        </span>
                                        <span>{{$site_count->counter}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
                @endforeach
            </div>

            <div class="divider"></div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-12">
                    <h3 class="mb-3">Teams</h3>
                    @php
                        $vendor = \App\Models\Vendor::where('vendor_admin_email', \Auth::user()->email)
                                                    ->first();

                                                    

                        // $supervisors_per_program = \DB::table('view_supervisors_per_vendor_per_program')
                        //                     ->where('program_id', $program->program_id)
                        //                     ->where('vendor_id', 1)
                        //                     ->get();

                        $supervisors = \App\Models\UserDetail::select('profiles.profile', 'users.name', 'users.id', 'user_details.image')
                                                        ->join('users', 'users.id', 'user_details.user_id')
                                                        ->join('profiles', 'profiles.id', 'users.profile_id')
                                                        ->where('users.profile_id', 3)
                                                        ->where('user_details.vendor_id', $vendor->vendor_id)
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
                                                            ->where('user_details.IS_id', $supervisor->id)
                                                            ->get(); 
                                    @endphp
                                    <div class="row">
                                        <div class="col-3 mb-2 mt-1  border-right" style="text-align: center;">
                                            <div>
                                                @if (!is_null($supervisor->image))
                                                    <img width="70" height="70" class="rounded-circle offline" src="{{ asset('files/'.$supervisor->image) }}" alt="">
                                                @else
                                                    <img width="70" height="70" class="rounded-circle offline" src="images/no-image.jpg" alt="">
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
                                                                    <img width="70" height="70" class="rounded-circle offline" src="{{ asset('files/'.$agent->image) }}" alt="">
                                                                @else
                                                                    <img width="70" height="70" class="rounded-circle offline" src="images/no-image.jpg" alt="">
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
          @if($program->program_id == 6)
              <x-towerco-dashboard />
  
          @elseif($program->program_id == 1)

            <x-newsites-dashboard />

          @elseif($program->program_id == 3)

            <x-coloc-dashboard />

          @elseif($program->program_id == 4)

            <x-ibs-dashboard />

          @elseif($program->program_id == 7)
  
              <x-localcoop-dashboard />

            @elseif($program->program_id == 8)

              <x-coloc-dashboard />
          
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

