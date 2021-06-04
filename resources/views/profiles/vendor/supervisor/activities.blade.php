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

</style>


<ul class="tabs-animated body-tabs-animated nav">
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
</ul>
<div class="tab-content">
    @php
        $activities = \DB::connection('mysql2')->select('call `supervisor_team_activities`('.\Auth::id().')');
        // dd($activities);

        function date_sort($a, $b) {
            return strtotime($a->start_date) - strtotime($b->start_date);
        }
        usort($activities, "date_sort");
        
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

        // dd($activities);

    @endphp

    <x-activities-tab :activities="$activities" mode="today" profile="supervisor"/>
    <x-activities-tab :activities="$activities" mode="week" profile="supervisor" />
    <x-activities-tab :activities="$activities" mode="month" profile="supervisor" />

</div>

@endsection

@section('modals')
<div class="modal fade" id="modal-sub_activity" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Site Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-outline-danger" data-dismiss="modal" aria-label="Close">
                    Close
                </button>
                <button type="button" class="btn btn btn-success" data-complete="false" id="" data-href="">Save</button>
            </div>
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
<script src="js/vendor.activities.js"></script>

@endsection