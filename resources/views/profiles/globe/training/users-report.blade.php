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
                            
                            <div class="card-header py-3 bg-warning border-bottom" style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{ strtoupper($program->program)  }} Agents
                            </div> 
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="users-report-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" class="align-middle mb-0 table table-borderless table-striped table-hover unasigned-table new-endorsement-table" data-href="{{ route('all.agent', $program->program_id) }}" data-program_id="{{$program->program_id}}">
                                        <thead>
                                            <tr>
                                                <th>Vendor</th>
                                                <th>Status</th>
                                                <th>Email</th>
                                                <th>User</th>
                                                <th>Mode</th>
                                                <th>Profle</th>
                                                <th>Program</th>
                                                <th>Upload Count</th>
                                                <th>Invited Date</th>
                                                <th>Last Login</th>
                                                <th>Login Count</th>
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

    <script>
        $('.new-endorsement-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],

            dom: 'Bfrtip',
            buttons: [
                'pageLength', 
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],

            ajax: {
                url: "/get-users-report",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            columns: [
                { data: "Vendor" },
                { data: "Status" },
                { data: "email" },
                { data: "User" },
                { data: "mode" },
                { data: "Profile" },
                { data: "Program" },
                { data: "upload_count" },
                { data: "Invite_date" },
                { data: "last_login" },
                { data: "login_count" },
            ],
        });
    </script>
@endsection