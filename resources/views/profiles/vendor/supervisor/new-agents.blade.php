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
            // if (\Auth::user()->profile_id == 3) {
            //     $user_detail = \Auth::user()->getUserDetail()->first();
            //     $programs = \Auth::user()->getUserProgram($user_detail->vendor_id);
            // } else {
            //     $programs = \Auth::user()->getUserProgram();
            // }

            $programs = \Auth::user()->getUserProgram();

            // dd($user_detail->IS_id);
        @endphp

    <input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">
    @foreach ($programs as $program)
        <li class="nav-item">
            <a role="tab" class="nav-link newagent {{ $loop->first ? 'active' : '' }}" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}" data-program="{{ strtolower(str_replace(" ", "-", $program->program))  }}">
                <span>{{ $program->program }}</span>
            </a>
        </li>
    @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($programs as $program)
            <div class="tab-pane tabs-animation fade {{ $loop->first ? 'active show' : '' }}" id="tab-content-{{ $program->program_id  }}" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-header py-3 bg-warning border-bottom" style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{ strtoupper($program->program)  }} New Agents without Areas
                            </div> 
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="newagent-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" class="align-middle mb-0 table table-borderless table-striped table-hover assign-agent-site-table" data-href="{{ route('all.newagent', $program->program_id) }}" data-page="new-agent">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">Photo</th>
                                                <th>Firstname</th>
                                                <th>Lastname</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('js_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/supervisor.js') }}"></script>
@endsection

@section('modals')
<div class="modal fade" id="assign-agent-site-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Agent Areas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assign-agent-site-form">
                    <div class="container-fluid assign-agent-div">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="region">Region</label>
                                {{-- <select name="region" id="region" class="form-control"><select> --}}
                                <div class="row" id="region_div"></div>
                            </div>
                            <small class="text-danger" id="region-error"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="assign-agent-site-btn" data-href="{{ route('assign.agent_site') }}">Assign site</button>
            </div>
        </div>
    </div>
</div>
@endsection