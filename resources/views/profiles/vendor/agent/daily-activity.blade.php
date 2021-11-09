@extends('layouts.main')

@section('content')

<style>
    .work_plan_view{
        cursor: pointer;
    }
</style>


<div id="workplan-list" class='mt-5'>
    <div class="row">
        <div class="col-12">
            <div class="mb-3 card">
                <div class="dropdown-menu-header py-3 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                    <div class="row px-4">
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title text-dark">
                                <i class="header-icon pe-7s-date pe-lg font-weight-bold mr-1"></i>
                                 My Activities
                            </h5>
                        </div>
                        <div class="btn-actions-pane-right py-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3 border-bottom pb-3">
                        <div class="col-sm-4">
                            <label>Start Date</label>
                            <input class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label>End Date</label>
                            <input class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label>Site</label>
                            <input class="form-control" />
                        </div>
                    </div>
                    @php 
                                        
                        $Date = date('Y-m-d', strtotime('today'));

                        date_default_timezone_set('Asia/Manila');
                        $Date = date('l F d, Y', strtotime($Date. ' - 0 days'));

                    @endphp
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $xdate =  date('l F d, Y', strtotime($Date. ' - ' . $i . ' days'));
                            $zdate =  date('Y-m-d', strtotime($Date. ' - ' . $i . ' days'));
                            $wp_ctr = 0;
                        @endphp
                        <div class="row">
                            <div id="daily_activity" class="col-12 table-responsive   py-3 bg-light border-bottom">
                                <strong>{{ $xdate }}</strong>
                            </div>
                        </div>

                    @endfor                    

                </div>
            </div>            
        </div>
    </div>

</div>

@endsection

@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')

<script src="\js\modal-loader.js"> </script>

@endsection

