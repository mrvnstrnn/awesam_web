
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
                        $supervisors_per_program = \DB::table('view_supervisors_per_vendor_per_program')
                                            ->where('program_id', $program->program_id)
                                            ->where('vendor_id', 1)
                                            ->get();

                    @endphp
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 mb-2 mt-1  border-right" style="text-align: center;">
                                    <div>
                                        <img class="rounded-circle" src="images/avatars/1.jpg" alt="" width="70">
                                    </div>
                                    <div style="text-align: center;">
                                        <div><small>TEST SUPERVISOR</small></div>
                                        <div><small>Supervisor</small></div>
                                    </div>
                                </div>
                                <div class="col-9 mb-2 mt-1" style="text-align: center;">
                                    <div class="row">
                                        <div class="col mb-4" style="min-width: 150px; max-width: 150px;">
                                            <div>
                                                <img class="rounded-circle" src="images/avatars/2.jpg" alt="" width="70">
                                            </div>
                                            <div style="text-align: center;">
                                                <small>Test</small>
                                            </div>
                                        </div>
                                        <div class="col mb-4" style="min-width: 150px; max-width: 150px;">
                                            <div>
                                                <img class="rounded-circle" src="images/avatars/3.jpg" alt="" width="70">
                                            </div>
                                            <div style="text-align: center;">
                                                <small>Test</small>
                                            </div>
                                        </div>
                                        <div class="col mb-4" style="min-width: 150px; max-width: 150px;">
                                            <div>
                                                <img class="rounded-circle" src="images/avatars/4.jpg" alt="" width="70">
                                            </div>
                                            <div style="text-align: center;">
                                                <small>Test</small>
                                            </div>
                                        </div>
                                        <div class="col mb-4" style="min-width: 150px; max-width: 150px;">
                                            <div>
                                                <img class="rounded-circle" src="images/avatars/5.jpg" alt="" width="70">
                                            </div>
                                            <div style="text-align: center;">
                                                <small>Test</small>
                                            </div>
                                        </div>
                                        <div class="col mb-4" style="min-width: 150px; max-width: 150px;">
                                            <div>
                                                <img class="rounded-circle" src="images/avatars/6.jpg" alt="" width="70">
                                            </div>
                                            <div style="text-align: center;">
                                                <small>Test</small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
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

