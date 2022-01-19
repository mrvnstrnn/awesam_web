
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
                        // $vendor = \App\Models\Vendor::where('vendor_admin_email', \Auth::user()->email)
                        //                             ->first();

                        $vendor = \App\Models\UserDetail::select('user_details.vendor_id')
                                                            ->where('user_id', \Auth::id())
                                                            ->first();

                                                    

                        // $supervisors_per_program = \DB::table('view_supervisors_per_vendor_per_program')
                        //                     ->where('program_id', $program->program_id)
                        //                     ->where('vendor_id', 1)
                        //                     ->get();

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

