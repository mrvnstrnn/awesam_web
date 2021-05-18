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
            // $programs = App\Models\VendorProgram::orderBy('vendor_program')->get();
            $programs = \DB::connection('mysql2')->table('program')->orderBy('program')->get();
        @endphp

        @foreach ($programs as $program)
            <li class="nav-item">
                @if ($loop->first)
                    <a role="tab" class="nav-link active" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
                @else
                    <a role="tab" class="nav-link" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}">
                @endif
                    <span>{{ $program->program }}</span>
                </a>
            </li>
        @endforeach
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
                                {{ strtoupper($program->program)  }} Endorsements
                                </div>
                                <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                    <button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-success mt-2">
                                        <i class="pe-7s-cloud-upload btn-icon-wrapper"></i>Upload New Sites
                                    </button>
                                    {{-- <button type="button" class="btn btn-primary btn-bulk-acceptreject-endorsement" data-program="" data-complete="true" id="" data-href="">Upload Sites</button> --}}
                                </div>       
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @php
                                        $activity = \Auth::user()->profile_id;

                                        $activity_id = \DB::connection('mysql2')->table('page_route')->where('profile_id', $activity)->where('activity_id', 1)->first();
                                    @endphp
                                    <table id="new-endoresement-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('all.getDataNewEndorsement', [\Auth::user()->profile_id, $program->program_id, 1, $activity_id->what_to_load]) }}">
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
                                <button type="button" class="btn btn-primary btn-bulk-acceptreject-endorsement" data-program="{{ strtolower($program->program) }}" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}">Endorse New Sites</button>
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
                    {{-- <button type="button" class="btn btn btn-outline-danger btn-accept-endorsement" data-complete="false" id="" data-href="{{ route('accept-reject.endorsement') }}">Reject</button> --}}
                    <button type="button" class="btn btn-primary btn-accept-endorsement" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}">Endorse New Site</button>
                </div>
            </div>
        </div>
    </div>

@endsection