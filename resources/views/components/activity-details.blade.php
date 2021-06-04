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
<li class="list-group-item" data-profile="{{ $profile }}" data-agent_id="{{ $agentid }}" data-agent_name="{{ $agentname }}">
    <div class="todo-indicator bg-{{ $color }}"></div>
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left mr-2">
                <i class="fa-2x pe-7s-note2"></i>
            </div>
            <div class="widget-content-left">
                <div class="widget-content-left">
                    <div class="widget-heading">
                        {{ $activityname }}
                        <div class="badge badge-{{ $color }} ml-2">
                            {{ $message }}
                        </div>
                    </div>
                    <div class="widget-subheading">
                        {{ $sitename }} 
                        - 
                        {{ $samid }}
                    </div>
                    <div class="widget-subheading">
                        {{ date('M d, Y', strtotime($startdate)) }} 
                        to 
                        {{ date('M d, Y', strtotime($enddate)) }}
                    </div>
                    <small>{{ $agentname }}</small>
                </div>
            </div>
            <div class="widget-content-right show_subs_btn"  data-show_li="sub_activity_{{ $samid }}_{{ $activityid }}_li_{{ $mode }}" data-chevron="down">
                <i class="lnr-chevron-down-circle"></i>
            </div>
        </div>
    </div>
</li>

<li id="sub_activity_{{ $samid }}_{{ $activityid }}_li_{{ $mode }}" class="list-group-item d-none sub_activity_li">
    <div id="sub_activity_{{ $samid }}_{{ $activityid }}" class="card-shadow-primary border mb-0 card card-body border-{{ $color }}" >
        <div class="row lister">
            @php
                $json = json_decode($subactivities, 1);
                if ($json != null) {
                    foreach ($json as $sub_activity){
                        if ($sub_activity['activity_id'] == $activityid){

                            // $show_sub_activity[] = $sub_activitiy;
                            echo "<div class='col-md-6 sub_activity' data-sam_id='" . $samid ."'  data-activity_id='" . $activityid ."' data-sub_activity_name='" . $sub_activity['sub_activity_name'] . "' data-action='" . $sub_activity['action'] . "'>" . $sub_activity['sub_activity_name'] . "</div>";
                        }
                    }
                }   
            @endphp
        </div>
        <div class="row action_box d-none">
            <x-action-box/>
        </div>
    </div>
</li>

