@extends('layouts.main')

@section('content')



<style>
    /* .list-group-item {
        cursor: pointer;
    } */
    .sub_activity {
        font-size: 11px;
        padding:3px 10px;
    }
    .sub_activity:hover {
        cursor: pointer;
        font-weight: bold;
    }

    .sub_activity::before {
        font-family: "Linearicons-Free";
        content: ">";
        margin-right: 3px;
    }

    .show_subs_btn {
        cursor: pointer;
        font-size: 20px;
    }
    .show_subs_btn:hover {
        cursor: pointer;
        font-weight: bold;
        color: blue;
    }

    .dropzone {
        min-height: 20px !important;
        border: 1px dashed #3f6ad8 !important;
        padding: unset !important;
    }

</style>


{{-- <ul class="tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-today" data-toggle="tab" href="#tab-content-today">
            <span>Today</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-week" data-toggle="tab" href="#tab-content-week">
            <span>This Week</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-this-month" data-toggle="tab" href="#tab-content-month">
            <span>This Month</span>
        </a>
    </li>
</ul> --}}
<div class="tab-content">
    @php
        $activities = \DB::connection('mysql2')->select('call `agent_activities`('.\Auth::id().')');
        // dd($activities);

        function date_sort($a, $b) {
            return strtotime($a->start_date) - strtotime($b->start_date);
        }
        usort($activities, "date_sort");

        // dd($activities);
        
        function group_by($key, $data) {
            $result = array();

            for ($i=0; $i < count($data); $i++) { 
                // if(array_key_exists($key, $data[$i])){
                if(isset($key) == $data[$i]) {
                    $result[$data[$i]->$key][] = $data[$i];
                } else {
                    $result[""][] = $data[$i];
                }
            }
            return $result;
        }
    @endphp

    @php
        $sites = \DB::connection('mysql2')
            ->table('site_milestone')
            ->select('sam_id', 'site_name', 'site_category', 'program_id')
            ->distinct()
            ->where('site_agent_id', "=", \Auth::id())
            ->orderBy('sam_id') 
            ->get();
        
        $activities = \DB::connection('mysql2')
            ->table('site_milestone')
            ->select('sam_id', 'site_name', 'site_category', 'stage_id', 'stage_name', 'activity_id', 'activity_name', 'activity_type', 'activity_duration_days', 'activity_complete', 'profile_id', 'start_date', 'end_date')
            ->distinct()
            ->where('site_agent_id', "=", \Auth::id())
            ->get();

        // dd($sites);
    @endphp

        <div class="tab-pane tabs-animation fade" id="tab-content-today" role="tabpanel">
            <div class="row">
                <div class="col-md-7">
                    <div class="card-header">
                        <i class="header-icon lnr-location icon-gradient bg-mixed-hopes"></i>
                        Site Activities
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <a data-toggle="tab" href="#tab-eg2-0" class="btn-pill pl-3 active btn btn-focus">Today</a>
                                <a data-toggle="tab" href="#tab-eg2-1" class="btn btn-focus">This Week</a>
                                <a data-toggle="tab" href="#tab-eg2-2" class="btn-pill pr-3  btn btn-focus">This Month</a>
                            </div>
                        </div>
                    </div>
                    <div id="accordion" class="accordion-wrapper mb-3">
                        @foreach ($sites as $site)

                        <div class="card">
                            <div id="headingOne" class="card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapse-{{ $site->sam_id }}" aria-expanded="true" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link text-dark btn-block">
                                        
                                        <h5 class="m-0 p-0"><i class="fa fa-map-marker fa-xl mb-2 mr-2" aria-hidden="true"></i>{{ $site->site_name }}</h5>
                                        <div class='pl-4    '><small>{{ $site->sam_id }} {{ $site->site_category }}</small></div>
                                </button>
                            </div>
                            <div data-parent="#accordion" id="collapse-{{ $site->sam_id }}" aria-labelledby="heading-{{ $site->sam_id }}" class="collapse" style="">
                                <ul class="todo-list-wrapper list-group list-group-flush">

                                     @foreach($activities as $activity)

                                        @if($site->sam_id == $activity->sam_id  && $activity->start_date <=  Carbon::today() && ($activity->activity_complete == 'false' ||  $activity->activity_complete == null ) )

                                        @php
                                            if($activity->activity_complete == 'true'){
                                                $activity_color = 'success';
                                                $activity_badge = "done";
                                            } 
                                            else {

                                                if($activity->end_date <=  Carbon::today()){
                                                    $activity_color = 'danger';
                                                    $activity_badge = "delayed";
                                                } 
                                                else {
                                                    $activity_color = 'warning';
                                                    $activity_badge = "On Schedule";
                                                }
                                            }

                                        @endphp

                                        <li class="list-group-item">
                                            <div class="todo-indicator bg-{{ $activity_color }}"></div>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3 ml-2">
                                                        <i class="pe-7s-note2 pe-2x"></i>
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">
                                                            {{ $activity->activity_name }}
                                                            <div class="badge badge-{{ $activity_color }} ml-2">{{ $activity_badge }}</div>
                                                            @if ($activity->activity_complete == 'false')
                                                            <div class="badge badge-primary ml-0">Active</div>                                                                
                                                            @endif
                                                        </div>
                                                        <div class="widget-subheading">
                                                            <i>{{ $activity->start_date }} to {{ $activity->end_date }}</i>
                                                        </div>
                                                    </div>
                                                    @if(in_array($activity->profile_id, array("2", "3")))
                                                    <div class="widget-content-right widget-content-actions">
                                                        <button class="border-0 btn-transition btn btn-outline-success show_activity_modal" data-sam_id='{{ $site->sam_id }}' data-site='{{ $site->site_name}}' data-activity='{{ $activity->activity_name}}' data-main_activity='{{ $activity->activity_name}}' data-activity_id='{{ $activity->activity_id}}'>
                                                            <i class="fa fa-angle-double-right fa-xl"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>

                                        @endif

                                     @endforeach
                                    
                                </ul>                            
                            </div>
                        </div>
                        @endforeach
                    </div>                    

                </div>
            </div>
        </div>

</div>

@endsection
@section('modals')

    <x-milestone-modal />

@endsection


@section('modals')
<div class="modal fade" id="modal-sub_activity" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Site Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/download-pdf" method="POST" target="_blank">@csrf
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                </div>
                <input type="hidden" name="sam_id" id="sam_id">
                <input type="hidden" name="sub_activity_id" id="sub_activity_id">
                {{-- <textarea name="template" id="template" class="d-none" cols="30" rows="10"></textarea> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                    <button type="submit" class="btn btn btn-success print_to_pdf">Print to PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<DIV id="preview-template" style="display: none;">
    <DIV class="dz-preview dz-file-preview">
        <DIV class="dz-image"><IMG data-dz-thumbnail=""></DIV>
        <DIV class="dz-details">
            <DIV class="dz-size"><SPAN data-dz-size=""></SPAN></DIV>
            <DIV class="dz-filename"><SPAN data-dz-name=""></SPAN></DIV>
        </DIV>
        <DIV class="dz-progress"><SPAN class="dz-upload" data-dz-uploadprogress=""></SPAN></DIV>
        <DIV class="dz-error-message"><SPAN data-dz-errormessage=""></SPAN></DIV>
    </DIV>
</DIV>
@endsection


@section('js_script')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="js/vendor.activities.js"></script>
<script src="js/modal-loader.js"></script>

<script>
    Dropzone.autoDiscover = false;
    $(".dropzone").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        maxFilesize: 5,
        paramName: "file",
        url: "/upload-file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            $("#form-upload  #file_name").val(resp.file);
            console.log(resp.message);
        },
        error: function (file, resp) {
            toastr.error(resp.message, "Error");
        }
    });
</script>


@endsection