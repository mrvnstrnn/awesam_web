@extends('layouts.main')

@section('content')
<ul class="tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-" data-toggle="tab" href="#tab-content-tasks">
            <span>Tasks</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a role="tab" class="nav-link " id="tab-" data-toggle="tab" href="#tab-content-forecast">
            <span>Forecast</span>
        </a>
    </li> --}}
</ul>
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade active show" id="tab-content-tasks" role="tabpanel">            
                <div id="calendar-bg-activities"></div>
            </div>
            <div class="tab-pane tabs-animation fade" id="tab-content-forecast" role="tabpanel">       
                <div id="calendar-bg-forecast"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_script')
    <script type="text/javascript" src="/js/calendar.js"></script>
@endsection