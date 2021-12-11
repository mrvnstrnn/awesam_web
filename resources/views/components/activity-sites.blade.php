@php
    $stats = $scheduleStatus($mode);

    if($stats <> null){
        $color = $stats['color'];
        $message = $stats['message'];

    } else {
        $color = "";
        $message = "";
    }

@endphp
<li class="list-group-item agent_card agent_card_{{ $agentid }}">
    <div class="todo-indicator bg-{{ $color }}"></div>
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left mr-2">
            </div>
            <div class="widget-content-left">
                <div class="widget-heading">
                    <a href="{{ route('view_assigned_site', [ $samid ]) }}">{{ $sitename }}</a>
                </div>
                <div class="widget-subheading">
                    {{ $samid }}
                </div>
                <div class="badge badge-{{ $color }}">
                    {{ $activityname }}
                </div>
            </div>
            <div class="widget-content-right widget-content-actions">
                {{-- <button class="border-0 btn-transition btn btn-outline-success">
                    <i class="fa fa-check"></i>
                </button>
                <button class="border-0 btn-transition btn btn-outline-danger">
                    <i class="fa fa-trash-alt"></i>
                </button> --}}
            </div>
        </div>
    </div>
    
</li>
