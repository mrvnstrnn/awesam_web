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
            $programs = \Auth::user()->getUserProgram();
        @endphp

<input type="hidden" name="program_lists" id="program_lists" value="{{ json_encode($programs) }}">

        @foreach ($programs as $program)
            <li class="nav-item">
                <a role="tab" class="nav-link agent {{ $loop->first ? 'active' : '' }}" id="tab-{{ $program->program_id  }}" data-toggle="tab" href="#tab-content-{{ $program->program_id  }}" data-program="{{ strtolower(str_replace(" ", "-", $program->program))  }}">
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
                            {{-- <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{ strtoupper($program->program)  }} Agents
                                </div>      
                            </div> --}}
                            
                            <div class="card-header py-3 bg-warning border-bottom" style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{ strtoupper($program->program)  }} Agents
                            </div> 
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="agent-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" class="align-middle mb-0 table table-borderless table-striped table-hover unasigned-table new-endorsement-table" data-href="{{ route('all.agent', $program->program_id) }}" data-program_id="{{$program->program_id}}">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">Photo</th>
                                                <th>Firstname</th>
                                                <th>Lastname</th>
                                                <th>Email</th>
                                                <th>Areas</th>
                                                <th></th>
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

    <script>
        $("table").on("click", ".update-data", function () {
            $("#update-agent-modal").modal("show");

            var user_id = $(this).attr("data-value");

            $("#assign-agent-site-form #user_id").val(user_id);

            $.ajax({
                url: "/get-user-details",
                method: "POST",
                data: {
                    user_id : user_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        $.each(resp.message, function(index, data) {
                            $("#assign-agent-site-form #"+index).val(data);
                        });

                        resp.user_areas.forEach(element => {
                            $("#assign-agent-site-form #region"+element.region).attr("checked", "checkek");
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        });
    </script>
@endsection

@section('modals')
<div class="modal fade" id="update-agent-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agent Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assign-agent-site-form">
                    <div class="container-fluid assign-agent-div">
                        <input type="hidden" class="form-control" name="user_id" id="user_id">
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="firstname">Firstname</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <input type="text" class="form-control" name="firstname" id="firstname">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="lastname">Lastname</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <input type="text" class="form-control" name="lastname" id="lastname">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="email">Email</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <input type="text" class="form-control" name="email" id="email" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="region">Region</label>
                                {{-- <select name="region" id="region" class="form-control"><select> --}}
                                <div class="row" id="region_div">
                                    @php
                                        $user_detail = \DB::table('user_details')
                                                        ->select('vendor_id')
                                                        ->where('user_id', \Auth::user()->id)
                                                        ->first();

                                                            
                                        $user_programs = \DB::table('user_programs')
                                                            ->select('program_id')
                                                            ->where('user_id', \Auth::user()->id)
                                                            ->get()
                                                            ->pluck('program_id');   

                                        if( count($user_programs) > 0){
                                            $sites = \DB::table('view_site')
                                                        ->select('sam_region_id')
                                                        ->where('vendor_id', $user_detail->vendor_id)
                                                        ->whereIn('program_id', $user_programs)
                                                        ->get()
                                                        ->groupBy('sam_region_id');

                                            if( !is_null($sites) ){
                                                $location_sam_regions = \DB::table('location_sam_regions')
                                                            ->whereIn('sam_region_id', $sites->keys())
                                                            ->get();
                                            } else {
                                                echo '<p>No region found.</p>';
                                            }
                                        } else {
                                            echo '<p>No user programs available.</p>';
                                        }
                                    @endphp

                                    @foreach ($location_sam_regions as $location_sam_region)
                                        <div class="col-4">
                                            <input name="region[]" class="regionInput" id="region{{ $location_sam_region->sam_region_id }}" type="checkbox" class="" value="{{ $location_sam_region->sam_region_id }}" >
                                            <label style="margin-left: 20px;" for="region{{ $location_sam_region->sam_region_id }}">{{ $location_sam_region->sam_region_name }}</label>
                                            </div>
                                    @endforeach
                                </div>
                            </div>
                            <small class="text-danger" id="region-error"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="udpate-agent-btn">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection