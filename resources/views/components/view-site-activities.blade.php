@php
    // dd($activities);
@endphp

<ul class="todo-list-wrapper list-group list-group-flush">
    @foreach ($activities as $activity )
        <li class="list-group-item" data-start_date="{{ $activity["start_date"] }}" data-end_date="{{ $activity["end_date"] }}">
            <div class="todo-indicator bg-{{ $activity["color"] }}"></div>
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-2">
                        <i class="fa-2x pe-7s-note2"></i>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-content-left">
                            <div class="widget-heading">
                                {{ $activity["activity_name"] }}
                                <div class="badge badge-{{ $activity["color"] }} ml-2">
                                    {{ $activity["badge"] }}
                                </div>
                            </div>
                            <div class="widget-subheading">
                                {{ $activity["start_date"] }} to {{ $activity["end_date"] }}
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-right subactivity_switch" id="subactivity_switch_{{ $activity["activity_id"] }}" data-activity_id="{{ $activity["activity_id"] }}">
                        <i class="lnr-chevron-down-circle" style="font-size: 20px;"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item d-none subactivity" id="subactivity_{{ $activity["activity_id"] }}">
            <div class="card-shadow-primary border mb-0 card card-body border-{{ $activity["color"] }}" >
                <div class="row subactivity_action_list">
                    @php
                        $sub_activities = $activity["sub_activities"];
                    @endphp
                    @foreach ( $sub_activities as $sub_activity)
                        <div class="col-md-6 subactivity_action_switch" data-sam_id="{{ $samid }}" data-activity_id="{{ $activity["activity_id"] }}" data-subactivity_id="{{ $sub_activity->sub_activity_id }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}">{{ $sub_activity->sub_activity_name }}</div>
                    @endforeach
                </div>
                <div class="row subactivity_action d-none">
                    <form class="w-100" id="form-upload" enctype="multipart/form-data">@csrf
                        <div class="list-uploaded"></div>
                        <hr class="hr-border">
                        <div class="dropzone"></div>
                        <input type="hidden" name="sam_id" id="sam_id">
                        <input type="hidden" name="sub_activity_id" id="sub_activity_id">
                        <input type="hidden" name="file_name" id="file_name">
                        <div class="position-relative form-group w-100 mb-0 mt-3">
                            <button type="button" class="btn btn-sm btn-primary float-right upload_file">Upload</button>
                            <button type="button" class="cancel_uploader btn btn-sm btn-outline-danger float-right mr-1" data-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </li>
                
    @endforeach
</ul>