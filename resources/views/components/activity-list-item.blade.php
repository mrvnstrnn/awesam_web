<li class="list-group-item">
    <div class="todo-indicator bg-warning"></div>
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left mr-2">
                <i class="pe-7s-note2"></i>
            </div>
            <div class="widget-content-left">
                <div class="widget-heading">
                    {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name }}
                </div>
                <div class="widget-subheading">
                    {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name }} 
                    - 
                    {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}</div>
                <div class="widget-subheading">
                    {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date)) }} 
                    to 
                    {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date)) }}</div>
            </div>
            <div class="widget-content-right show_subs_btn"  data-show_li="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}_li" data-chevron="down">
                <i class="lnr-chevron-down-circle"></i>
            </div>
        </div>
    </div>
    
</li>
<li id="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}_li" class="list-group-item sub_activity_li d-none">
    <div id="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}" class="card-shadow-primary border mb-0 card card-body border-warning" >
        <div class="row lister">
            @php
                $json = json_decode($activities_groups[array_keys($activities_groups)[$j]][$k]->sub_activity, 1);
                if ($json != null) {
                    foreach ($json as $sub_activity){
                        if ($sub_activity['activity_id'] == $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id){

                            // $show_sub_activity[] = $sub_activitiy;
                            echo "<div class='col-md-6 sub_activity' data-sam_id='" . $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id ."'  data-activity_id='" . $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id ."' data-sub_activity_name='" . $sub_activity['sub_activity_name'] . "' data-action='" . $sub_activity['action'] . "'>" . $sub_activity['sub_activity_name'] . "</div>";

                        }
                    }
                }   
            @endphp
        </div>
        <div class="row action_box d-none">
            <form class="w-100">                                                          
            <div class="position-relative form-group mb-2 px-2">
                <label id="" for="doc_upload[]" class="doc_upload_label">Email</label>
                <div class="input-group">
                    <input type="file" name="doc_upload[]" class="p-1 form-control">
                </div>
            </div>
            <div class="position-relative form-group w-100 mb-0 px-2">
                <button type="button" class="btn btn-sm btn-primary float-right" data-complete="false" id="" data-href="">Upload</button>                                                    
                <button type="button" class="cancel_uploader btn btn-sm btn-outline-danger float-right mr-1" data-dismiss="modal" aria-label="Close">
                    Cancel
                </button>
            </div>
            </form>
        </div>
    </div>
</li>
