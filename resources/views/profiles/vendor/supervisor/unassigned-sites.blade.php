@extends('layouts.main')

@section('content')

    {{-- <x-assigned-sites mode="vendor"/> --}}
    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Unassigned Sites" activitytype="unassigned sites"/>

@endsection


@section('modals')

<div class="modal fade" id="modal-assign-sites" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Sites</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="agent_form">
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="form-row">
                    <input type="hidden" id="sam_id" name="sam_id">
                        {{-- @php
                            $agents = \DB::connection('mysql2')
                                    ->table('users')
                                    ->join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('user_details.IS_id', \Auth::user()->id)
                                    ->get();
                        @endphp --}}
                        <select name="agent_id" id="agent_id" class="form-control">
                        {{-- @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-assign-sites" data-href="{{ route('assign.agent') }}" data-activity_name="site_assign">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'unassigned_site';
    var main_activity = 'Unassigned Sites';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script src="{{ asset('js/supervisor.js') }}"></script>

{{-- <script type="text/javascript" src="/js/modal-loader.js"></script>   --}}



@endsection