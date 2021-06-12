@extends('layouts.main')

@section('style')

<style>
.tab-content > .tab-pane:not(.active) {
    display: block;
    height: 0;
    overflow-y: hidden;
}
.subactivity_switch:hover {
    cursor: pointer;
    color: royalblue;
}
.subactivity_action_switch:hover {
    cursor: pointer;
    color: royalblue;
}

.dropzone {
    min-height: 20px !important;
    border: 1px dashed #3f6ad8 !important;
    padding: unset !important;
}

</style>

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div id="example4.2" style="height: 150px;"></div>
    </div>
</div>                        

<div class="row">
    <div class="col-12">
        <ul class="tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-4" data-toggle="tab" href="#tab-content-4">
                    <span>Activities</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-0" data-toggle="tab" href="#tab-content-0">
                    <span>Forecast</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                    <span>Details</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-3" data-toggle="tab" href="#tab-content-3">
                    <span>Files</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                    <span>Issues</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-5" data-toggle="tab" href="#tab-content-5">
                    <span>Site Chat</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    <i class="header-icon lnr-question-circle icon-gradient bg-ripe-malin"></i>
                    {{ $title }}
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane tabs-animation fade show active" id="tab-content-4" role="tabpanel">
                        <x-view-site-activities :activities="$activities" samid="$title_subheading"/>
                    </div>
                    <div class="tab-pane tabs-animation fade " id="tab-content-0" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                        <x-site-fields :sitefields="$site_fields" />
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                        <x-site-issues />
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                        <x-site-files />
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
                        <x-site-chat />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 col-sm-12">
        <x-agent-sites :agentsites="$agent_sites" :agentname="$agent_name" />
    </div>

    <input id="timeline" type="hidden" value="{{ $timeline }}" />

</div>

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
@endsection

@section('js_script')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="{{ asset('js/supervisor-view-sites.js') }}"></script>
<script src="{{ asset('js/view_site.js') }}"></script>



@endsection