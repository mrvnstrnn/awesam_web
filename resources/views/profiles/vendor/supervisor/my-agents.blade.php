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

@section('modals')
<div class="modal fade" id="update-agent-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="dropdown-menu-header" style="paddng:0px !important;">
                <div class="dropdown-menu-header-inner bg-dark">
                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                    <div class="menu-header-content btn-pane-right">
                        <div>
                            <h5 class="menu-header-title">
                                Agents Details
                            </h5>                                        
                        </div>
                    </div>
                </div>
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
                                <input type="text" class="form-control" name="firstname" id="firstname" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="lastname">Lastname</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <input type="text" class="form-control" name="lastname" id="lastname" readonly>
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
                                <div class="row" id="region_div">
                                    @php
                                    $location_sam_regions = \DB::table('location_sam_regions')
                                                ->get();
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
                <button type="button" class="btn btn-secondary btn-shadow" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-shadow update-agent-btn">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/supervisor.js') }}"></script>

    <script>
        $("table").on("click", ".update-data", function () {

            var user_id = $(this).attr("data-value");
            $("#assign-agent-site-form input[name='region[]']").attr("checked", false);

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
                        $("#update-agent-modal").modal("show");
                        $.each(resp.message, function(index, data) {
                            $("#assign-agent-site-form #"+index).val(data);
                        });

                        resp.user_areas.forEach(element => {
                            $("#assign-agent-site-form #region"+element.region).attr("checked", "checked");
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

        $(document).on('click', ".update-agent-btn", function(e){
            $(this).text("Assigning...");
            $(this).attr("disabled", "disabled");
            var data_program = $(this).attr('data-program');

            $("#assign-agent-site-form small").text("");

            $.ajax({
                url: '/update-agent-site',
                method: "POST",
                data: $("#assign-agent-site-form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $(".new-endorsement-table").DataTable().ajax.reload(function(){
                            $("#assign-agent-site-form")[0].reset();
                            $("#update-agent-modal").modal("hide");
                                Swal.fire(
                                    'Success',
                                    resp.message,
                                    'success'
                                )
                            $(".update-agent-btn").text("Update");
                            $(".update-agent-btn").removeAttr("disabled");
                        });
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $("#" + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp,
                                'error'
                            )
                        }
                        $(".update-agent-btn").text("Update");
                        $(".update-agent-btn").removeAttr("disabled");
                    }
                },
                error: function(resp){
                    $(".update-agent-btn").text("Update");
                    $(".update-agent-btn").removeAttr("disabled");
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