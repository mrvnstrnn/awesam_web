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
                <a role="tab" class="nav-link {{ $i == 0 ? 'active' : '' }}" id="tab-{{$i}}" data-toggle="tab" href="#{{ array_keys($table_list)[$i] }}">
                    <span>{{ ucfirst(array_keys($table_list)[$i]) }}</span>
                </a>
            </li>
        @endfor
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
    <script src="{{ asset('js/supervisor-request.js') }}"></script>
@endsection

@section('modals')
    <div class="modal fade" id="modalRequest" tabindex="-1" role="dialog" aria-labelledby="modalRequest" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                          <label for="request_typ">Request Type</label>
                          <input type="text" name="request_typ" id="request_typ" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary reject_request" data-action="denied" data-href="{{ route('approvereject_agent_request') }}">Reject</button>
                    <button type="button" class="btn btn-primary approvereject_request_final"  data-href="{{ route('approvereject_agent_request') }}" data-action="approved">Approve</button>
                </div>
            </div>
        </div>
    </div>
@endsection