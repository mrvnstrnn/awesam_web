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
      
      @if($program->program_id == 6)

        <x-towerco-dashboard />
    
      @endif
      </div>
  @endforeach    
</div>


@endsection

@section('js_script')
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            drawBasic();
        })    
    </script>
    
@endsection