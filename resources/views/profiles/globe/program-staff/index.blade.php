@extends('layouts.main')

@section('content')

<ul class="tabs-animated body-tabs-animated nav">

  @php
      // if (\Request::path() == 'endorsements') {
      //     $programs = \Auth::user()->getUserProgramEndorsement(\Request::path());
      // } else {
      // }
      if (\Auth::user()->profile_id == 1) {
          $user_details = \Auth::user()->getUserDetail()->first();
          $programs = \Auth::user()->getUserProgram($user_details->vendor_id);
      } else {
          $programs = \Auth::user()->getUserProgram();
      }
  @endphp
  <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">

  @foreach ($programs as $program)
      <li class="nav-item">
          @if ($loop->first)
              @php
                  $active = "active";
              @endphp
          @else
              @php
                  $active = "";
              @endphp                
          @endif
          
          <a role="tab" class="nav-link {{ $active }}" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
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
            <div class="mb-3 card">
                <div class="tabs-lg-alternate card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-{{ $program->program_id  }}-milestones" class="active nav-link">
                                <div class="widget-number"><i class="fa fa-fw fa-md" aria-hidden="true"></i> Milestones</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-{{ $program->program_id  }}-productivity" class="nav-link">
                                <div class="widget-number"><i class="fa fa-fw fa-md" aria-hidden="true"></i> Productivity</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-{{ $program->program_id  }}-milestones" role="tabpanel">
                        <div class="card-body">
                            @if($program->program_id == 6)
                                <!-- <x-towerco-dashboard /> -->
                            @elseif($program->program_id == 1)
                                <!-- @include('profiles.globe.dashboards.newsites-milestones') -->
                            @else
                                
                            <p class="mb-0">
                                STILL UNDER CONSTRUCTION
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-{{ $program->program_id  }}-productivity" role="tabpanel">
                        <div class="card-body">
                            <ul class="nav">
                                <a href="javascript:void(0);" class="nav-link active">Dashboard</a>
                                <a href="javascript:void(0);" class="nav-link text-secondary">Agent Activity</a>
                                <a href="javascript:void(0);" class="nav-link text-secondary">Weekly Achievements</a>
                                <a href="javascript:void(0);" class="nav-link text-secondary">Admin Works</a>
                                <a href="javascript:void(0);" class="nav-link text-secondary">Travels</a>
                            </ul>            
                            <hr>                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    @endforeach    
</div>


@endsection

@section('js_script')


<!-- PR PO Counter -->
<script type="text/javascript" src="/js/newsites_ajax_counter.js"></script>  

    <script>
        // $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        //     drawBasic();
        // })    

    </script>

<!-- @include('profiles.dar_js'); -->

    
@endsection