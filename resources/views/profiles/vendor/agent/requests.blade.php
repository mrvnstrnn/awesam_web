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
                                <button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-primary mt-2">
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
@endsection

@section('modal')
    
@endsection