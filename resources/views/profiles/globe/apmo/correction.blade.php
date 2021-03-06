@extends('layouts.main')

@section('content')
    <style>
        .modalDataEndorsement {
            cursor: pointer;
        }

        table {
            width: 100% !important;
        }
    </style> 

    <ul class="tabs-animated body-tabs-animated nav">

        @php
            $programs = \Auth::user()->getUserProgram();
        @endphp

        @foreach ($programs as $program)
            {{-- <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="vendor_program_id{{ $program->vendor_program_id  }}" name="vendor_program_id" value="{{ $program->vendor_program_id  }}">
                <label class="form-check-label" for="vendor_program_id{{ $program->vendor_program_id  }}">{{ $program->vendor_program }}</label>
            </div> --}}
            <li class="nav-item">
                @if ($loop->first)
                    <a role="tab" class="nav-link active" id="tab-{{ $program->program_id  }}" data-togg`le="tab" href="#tab-content-{{ $program->program_id  }}">
                        <span>{{ $program->program }}</span>
                        <span class="badge badge-pill badge-light">1.2K</span>
                    </a>
                @else
                    <a role="tab" class="nav-link" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
                        <span>{{ $program->program }}</span>
                    </a>
                @endif
            </li>
        @endforeach

        {{-- <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>IBS</span>
            </a>
        </li> --}}
    </ul>
    <div class="tab-content">
        @foreach ($programs as $program)
            @if ($loop->first)
            <div class="tab-pane tabs-animation fade active show" id="tab-content-{{ $program->program_id  }}" role="tabpanel">            
            @else
            <div class="tab-pane tabs-animation fade" id="tab-content-{{ $program->program_id  }}" role="tabpanel">
            @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{ $program->program  }} Returned Endorsements
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="new-endoresement-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('all.getDataNewEndorsement', [\Auth::user()->profile_id, $program->program_id, 1, 'New Endorsement - apmo']) }}">
                                        <thead>
                                            <tr>
                                                <th style="width: 15px;">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" id="checkAll" class="custom-control-input">
                                                        <label class="custom-control-label" for="checkAll">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th class="d-none d-md-table-cell">Date Endorsed</th>
                                                <th class="d-none d-md-table-cell">SAM ID</th>
                                                <th>Site</th>
                                                <th class="text-center">Technology</th>
                                                <th class="text-center  d-none d-sm-table-cell">PLA ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-block text-right card-footer">
                                {{-- <button type="button" class="btn btn btn-outline-danger btn-bulk-acceptreject-endorsement" data-program="coloc" data-complete="false" id="" data-href="{{ route('accept-reject.endorsement') }}">Reject</button> --}}
                                <button type="button" class="btn btn-primary btn-bulk-acceptreject-endorsement" data-program="coloc" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}">Re-Endorse New Sites</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                            Endorsements
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="new-endoresement-ibs-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('all.getDataNewEndorsement', [\Auth::user()->profile_id, 4]) }}">
                                    <thead>
                                        <tr>
                                            <th style="width: 15px;">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkAll" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkAll">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th class="d-none d-md-table-cell">Date Endorsed</th>
                                            <th class="d-none d-md-table-cell">SAM ID</th>
                                            <th>Site</th>
                                            <th class="text-center">Technology</th>
                                            <th class="text-center  d-none d-sm-table-cell">PLA ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-block text-right card-footer">
                            <button type="button" class="btn btn btn-outline-danger btn-bulk-acceptreject-endorsement" data-program="ibs" data-complete="false" id="" data-href="{{ route('accept-reject.endorsement') }}">Reject</button>
                            <button type="button" class="btn btn-primary btn-bulk-acceptreject-endorsement" data-program="ibs" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}">Accept Endorsement</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@section('js_script')
    <script src="{{ asset('js/pmo.js') }}"></script>
@endsection

@section('modals')

    <div class="modal fade" id="modal-endorsement" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="form-row content-data">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-outline-danger btn-accept-endorsement" data-complete="false" id="" data-href="{{ route('accept-reject.endorsement') }}">Reject</button>
                    <button type="button" class="btn btn-primary btn-accept-endorsement" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}">Accept Endorsement</button>
                </div>
            </div>
        </div>
    </div>

@endsection