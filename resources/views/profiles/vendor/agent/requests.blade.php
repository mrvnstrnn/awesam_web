@extends('layouts.main')

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        @php
            $table_list = array(
                'active' => 'lnr-select',
                'approved' => 'lnr-thumbs-up',
                'denied' => 'lnr-thumbs-down',
            );
        @endphp
        
        @for ($i = 0; $i < count($table_list); $i++)
            <li class="nav-item">
                <a role="tab" class="nav-link {{ $i == 0 ? 'active' : '' }}" id="tab-0" data-toggle="tab" href="#{{ array_keys($table_list)[$i] }}">
                    <span>{{ ucfirst(array_keys($table_list)[$i]) }}</span>
                </a>
            </li>
        @endfor
        {{-- <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>Approved</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                <span>Denied</span>
            </a>
        </li> --}}
    </ul>
    <div class="tab-content">
        @for ($i = 0; $i < count($table_list); $i++)
        <div class="tab-pane tabs-animation fade show {{ $i == 0 ? 'active' : '' }}" id="{{ array_keys($table_list)[$i] }}" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal d-flex justify-content-between">
                                <i class="header-icon {{$table_list[array_keys($table_list)[$i]]}} icon-gradient bg-ripe-malin"></i>
                                {{ ucfirst(array_keys($table_list)[$i]) }} Requests 
                            </div>
                            <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                <button class="add_request_button mb-2 mr-2 btn-icon btn-pill btn btn-outline-primary mt-2">
                                    <i class="pe-7s-plus btn-icon-wrapper"></i>Request
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table data-href="{{ route('get.requestDate', array_keys($table_list)[$i]) }}" id="{{ array_keys($table_list)[$i] }}-request-table" class="align-middle mb-0 table table-borderless table-striped table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>Type</th>
                                            <th style="width: 35%">Reason</th>
                                            <th>Start-End Date</th>
                                            <th>Date Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>

@endsection

@section('js_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('js/agent.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    

@endsection

@section('modals')

    <div class="modal fade" id="modal_request" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule Change Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="form-row content-data row">
                        <div id="loader" class="d-none  w-100">
                            <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                                <div class="loader">
                                    <div class="ball-scale-ripple-multiple">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
        
                        <form id="request_form" class="w-100">
                            <div class="form-row" >
                                <div class="col-12">
                                    <div class="position-relative form-group">
                                        <label for="request_type" class="">Request Type</label>
                                        <select name="request_type" id="request_type" class="form-control" required>
                                            <option></option>
                                            <option>Absent</option>
                                            <option>Leave</option>
                                            <option>Resign</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" >
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="position-relative form-group">
                                        <label for="start_date_requested" class="">Start Date</label>
                                        <input name="start_date_requested" id="start_date_requested" placeholder="Start Date" type="text" class="form-control text-lowercase flatpicker bg-white" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="position-relative form-group">
                                        <label for="end_date_requested" class="">End Date</label>
                                        <input name="end_date_requested" id="end_date_requested" placeholder="End Date" type="text" class="form-control text-lowercase flatpicker bg-white" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" >
                                <div class="col-12">    
                                    <div class="position-relative form-group">
                                        <label for="reason" class="">Reason</label>
                                        <textarea name="reason" id="reason" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-outline-danger"  data-dismiss="modal"  id="btn_modal_cancel" >Cancel</button>
                    <button type="button" class="btn btn-primary" id="add_request" data-href="{{ route('add_agent_request') }}">Request</button>
                </div>
            </div>
        </div>
    </div>

@endsection