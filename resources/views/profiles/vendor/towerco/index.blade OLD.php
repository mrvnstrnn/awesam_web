@extends('layouts.main')

@section('content')

<style>
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: rgb(255, 0, 0);
}    
</style>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header"> 
                <div class="dropdown-menu-header-inner bg-primary">
                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                    <div class="menu-header-content btn-pane-right d-flex justify-content-between">
                        <h5 class="menu-header-title">
                            <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                            TowerCo
                        </h5>
                        <button class="btn btn-primary btn-sm btn_create_pr">Create PR / PO</button>
                    </div>
                </div>
            </div> 
            <div class="card-body">

                <table id="towerco-table" 
                    class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table"
                    data-href="{{ route('get_towerco') }}"
                    data-program_id="6" data-table_loaded="false">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Region</th>
                            <th>Search Ring</th>
                            <th>TOWERCO</th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>                

@endsection


@section('modals')
<style>
    #issues_table tbody tr:hover {
        cursor: pointer;
        background-color: rgb(221, 221, 221);
    }
    .table_issues_child tbody tr td:nth-child(4), .table_history_child tbody tr td:nth-child(3), .table_engagements_child tbody tr td:nth-child(4) {
        overflow: hidden !important;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>

<div id="towerco_details" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark">Coop Details</h5>
            <button type="button" class="close modal_close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pb-0" >
            <form id="towerco_form">
                <div class="card mb-0" style="box-shadow: none;">
                    <div class="card-header">
                        <ul class="nav nav-justified">
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-towerco-details" class="nav-link active">Details</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a data-toggle="tab" href="#tab-towerco-sts" class="nav-link">STS</a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-towerco-ram" class="nav-link">RAM</a>
                            </li> --}}
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-towerco-towerco" class="nav-link">TowerCo</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a data-toggle="tab" href="#tab-towerco-agile" class="nav-link">Agile</a>
                            </li> --}}
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-towerco-logs" class="nav-link">Logs</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-towerco-details" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                                @php
                                    $towerco = DB::table('towerco')->first();                                
                                @endphp

                                @foreach ($towerco as $col => $value)
                                    <div class="row border-bottom mb-1 pb-1">
                                        <div class="col-sm-4  text-lg">
                                            {{ $col }}
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" value="{{ $value }}" class="form-control" readonly>
                                        </div>
                                    </div>                                
                                @endforeach
                            </div>
                            <div class="tab-pane" id="tab-towerco-sts" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                                @php
                                    $sts = [
                                        'Serial Number',	
                                        'Search Ring',
                                        'REGION',
                                        'TOWERCO',
                                        'PROVINCE',
                                        'TOWN',
                                        '[NP] Latitude',
                                        '[NP]Longitude',
                                        'SITE TYPE',
                                        'Tower Height',
                                        'FOC/ MW TAGGING',
                                        'Wind Speed',
                                        'OFF-GRID/GOOD GRID',
                                        'PRIO',	
                                        'BATCH'
                                    ];
                                @endphp
                                @foreach ($towerco as $col => $value)
                                    @if (in_array($col, $sts))
                                        <div class="row border-bottom mb-1 pb-1">
                                            <div class="col-md-4">
                                                {{ $col }}
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" value="{{ $value }}" class="form-control">
                                            </div>
                                        </div>                                    
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="tab-towerco-ram" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                                @php
                                    $ram = [
                                        'DATE ENDORSED BY RAM',	
                                        'LOT SIZE (sq-m)',
                                        'ACCESS',	
                                        'LINK TO DOCS FOR GLOBE-ACQUIRED SITES',
                                        'LANDLORD INFO',	
                                        'LEASE AMOUNT',	
                                        'LEASE ESCALATION'
                                    ];
                                @endphp
                                @foreach ($towerco as $col => $value)
                                    @if (in_array($col, $ram))
                                        <div class="row border-bottom mb-1 pb-1">
                                            <div class="col-md-4">
                                                {{ $col }}
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" value="{{ $value }}" class="form-control">
                                            </div>
                                        </div>                                    
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="tab-towerco-towerco" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                                @php
                                    $tower = [
                                        'MLA COMPLETION DATE',	
                                        'DATE ACCEPTED BY TOWERCO',	
                                        'PROJECT TAG',	
                                        'MILESTONE STATUS',	
                                        'ESTIMATED RFI DATE',	
                                        'TSSR SUBMIT DATE',	
                                        'TSSR APPROVED DATE',	
                                        'SITE DATE ACQUIRED',	
                                        'CW START DATE',	
                                        'CW COMPLETED DATE',	
                                        'RFI DATE SUBMITTED',	
                                        'RFI DATE APPROVED (TEMPO POWER)',
                                        'RFI DATE APPROVED (PERMANENT POWER)'
                                    ];
                                @endphp
                                @foreach ($towerco as $col => $value)
                                    @if (in_array($col, $tower))
                                        <div class="row border-bottom mb-1 pb-1">
                                            <div class="col-md-4">
                                                {{ $col }}
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" value="{{ $value }}" class="form-control">
                                            </div>
                                        </div>
                                
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="tab-towerco-agile" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                                @php
                                    $agile = [
                                        'TSSR STATUS',	
                                        'Tower Co TSSR Submission Date to GT',	
                                        'Full Approval Date (TSSR Approved Date)',
                                        ''
                                    ];
                                @endphp
                                @foreach ($towerco as $col => $value)
                                    @if (in_array($col, $agile)==true)
                                        <div class="row border-bottom mb-1 pb-1">
                                            <div class="col-md-4">
                                                {{ $col }}
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" value="{{ $value }}" class="form-control">
                                            </div>
                                        </div>                                    
                                    @endif
                                @endforeach
                            </div>
                            <div class="tab-pane" id="tab-towerco-logs" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal_close"  data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary modal_close">Update</button>
        </div>
        </div>
    </div>
</div>

<div id="add_issue" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark"><i class="pe-7s-gleam pe-lg mr-2"></i>Add Issue</h5>
            <button type="button" class="close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form class="issue_form">
            <input type="hidden" name="action" id="action" value="issues">
            <div class="position-relative row form-group">
                <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                <div class="col-sm-9">
                    <select name="coop" id="coop" class="form-control">
                        @php
                            $coops = \DB::table("local_coop")
                                ->get();
                        @endphp
                        <option value="">Select COOP</option>
                        @foreach ($coops as $coop)
                            <option value="{{$coop->coop_name}}">{{$coop->coop_name}}</option>
                        @endforeach
                    </select>
                    <small class="text-danger coop-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="dependency" class="col-sm-3 col-form-label">Dependency</label>
                <div class="col-sm-9">
                    <select name="dependency" id="dependency" class="form-control">
                        <option value="Dependency">Dependency</option>
                        <option value="COOP">COOP</option>
                        <option value="Globe">Globe</option>
                        <option value="LGU">LGU</option>
                        <option value="Others">Others</option>
                    </select>
                    <small class="text-danger dependency-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="nature_of_issue" class="col-sm-3 col-form-label">Nature of Issue </label>
                <div class="col-sm-9">
                    <select name="nature_of_issue" id="nature_of_issue" class="form-control">
                        <option value="Nature of Issue">Nature of Issue</option>
                        <option value="Bills Payment">Bills Payment</option>
                        <option value="Power Upgrade">Power Upgrade</option>
                        <option value="Power Application">Power Application</option>
                        <option value="Cable Regrooming">Cable Regrooming</option>
                        <option value="Pole Related Concern">Pole Related Concern</option>
                        <option value="JPA">JPA</option>
                        <option value="RTA">RTA</option>
                        <option value="Business Related Concerns">Business Related Concerns</option>
                        <option value="Others">Others</option>
                    </select>
                    <small class="text-danger nature_of_issue-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control"></textarea>
                    <small class="text-danger description-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="issue_raised_by" class="col-sm-3 col-form-label">Issue Raised By</label>
                <div class="col-sm-9">
                    <select name="issue_raised_by" id="issue_raised_by" class="form-control">
                        <option>Issue Raised By</option>
                        <option value="COOP">COOP</option>
                        <option value="Globe">Globe</option>
                        <option value="HOA">HOA</option>
                    </select>
                    <small class="text-danger issue_raised_by-error"></small>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="issue_raised_by_name" class="col-sm-3 col-form-label">Issue Raised By (Name)</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="issue_raised_by_name" name="issue_raised_by_name" placeholder="Issue Raised By (Name)">
                    <small class="text-danger issue_raised_by_name-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="date_of_issue" class="col-sm-3 col-form-label">Date of Issue</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control flatpicker" name="date_of_issue" id="date_of_issue" placeholder="Date of Issue">
                    <small class="text-danger date_of_issue-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="issue_assigned_to" class="col-sm-3 col-form-label">Issue Assigned To</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="issue_assigned_to" name="issue_assigned_to" placeholder="Issue Assigned To">
                    <small class="text-danger issue_assigned_to-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="status_of_issue" class="col-sm-3 col-form-label">Status of Issue</label>
                <div class="col-sm-9">
                    <select name="status_of_issue" id="status_of_issue" class="form-control">
                        <option value="">Status of Issue</option>
                        <option value="Not Started">Not Started</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                    <small class="text-danger status_of_issue-error"></small>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add_engagement" id="add_issue_btn" data-type="issues">Add Issue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="add_engagement" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark"><i class="pe-7s-star pe-lg mr-2"></i>Add Engagement</h5>
            <button type="button" class="close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form class="engagement_form">
            <input type="hidden" name="action" id="action" value="engagements">
            <div class="position-relative row form-group">
                <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                <div class="col-sm-9">
                    <select name="coop" id="coop" class="form-control">
                        @php
                            $coops = \DB::table("local_coop")
                                ->get();
                        @endphp
                        <option value="">Select COOP</option>
                        @foreach ($coops as $coop)
                            <option value="{{$coop->coop_name}}">{{$coop->coop_name}}</option>
                        @endforeach
                    </select>
                    <small class="text-danger coop-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="engagement_type" class="col-sm-3 col-form-label">Engagement Type</label>
                <div class="col-sm-9">
                    <select name="engagement_type" id="engagement_type" class="form-control">
                        <option value="">Select Engagement Type</option>
                        <option value="Power Upgrade">Power Upgrade</option>
                        <option value="New Sites">New Sites</option>
                        <option value="Sites for Permanent Power">Sites for Permanent Power</option>
                        <option value="RTA">RTA</option>
                        <option value="JPA">JPA</option>
                        <option value="Bills Payment">Bills Payment</option>
                    </select>
                    <small class="text-danger engagement_type-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="result_of_engagement" class="col-sm-3 col-form-label">Result of Engagement</label>
                <div class="col-sm-9">
                    <select name="result_of_engagement" id="result_of_engagement" class="form-control">
                        <option value="">Select Engagement Result</option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Engaged">Engaged</option>
                    </select>
                    <small class="text-danger result_of_engagement-error"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" class="form-control"></textarea>
                    <small class="text-danger remarks-error"></small>
                </div>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add_engagement" id="add_engagement_btn" data-type="engagements">Add Engagement</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="add_contact" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark"><i class="pe-7s-user pe-lg mr-2"></i>Add Contact</h5>
            <button type="button" class="close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="contact_form">
                <input type="hidden" name="action" id="action" value="contacts">
                <div class="position-relative row form-group">
                    <label for="coop" class="col-sm-3 col-form-label">COOP</label>
                    <div class="col-sm-9">
                        <select name="coop" id="coop" class="form-control">
                            @php
                                $coops = \DB::table("local_coop")
                                    ->get();
                            @endphp
                            <option value="">Select COOP</option>
                            @foreach ($coops as $coop)
                                <option value="{{$coop->coop_name}}">{{$coop->coop_name}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger coop-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="contact_type" class="col-sm-3 col-form-label">Contact Type</label>
                    <div class="col-sm-9">
                        <select id="contact_type" name="contact_type" class="form-control">
                            <option value="">Select Contact Type</option>
                            <option value="Engineering">Engineering</option>
                            <option value="COOP Contact">COOP Contact</option>
                        </select>
                        <small class="text-danger contact_type-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="firstname" class="col-sm-3 col-form-label">Firstname</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Firstname" name="firstname" id="firstname" class="form-control" />
                        <small class="text-danger firstname-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="lastname" class="col-sm-3 col-form-label">Lastname</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Lastname" name="lastname" id="lastname" class="form-control"/>
                        <small class="text-danger lastname-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="contact_number" class="col-sm-3 col-form-label">Cellphone</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Cellphone" name="contact_number" id="contact_number" class="form-control"/>
                        <small class="text-danger contact_number-error"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" placeholder="Email" name="email" id="email" class="form-control"/>
                        <small class="text-danger email-error"></small>
                    </div>
                </div>
            </form>
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary add_engagement" id="add_contact_btn" data-type="contacts">Add Contact</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 21;
    var table_to_load = 'towerco';
    //////////////////////////////////////
</script>

{{-- <script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>   --}}
{{-- <script type="text/javascript" src="/js/modal-loader.js"></script>   --}}

<script>

        var whatTable = $('#towerco-table');

        $(whatTable).DataTable({
            processing: true,
            serverSide: false,
            filter: true,
            searching: true,
            lengthChange: true,
            regex: true,
            ajax: {
                url: $(whatTable).attr('data-href'),
                type: 'GET',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            
            language: {
                "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Loading...</strong></div>",
            },
            
            dataSrc: function(json){
                return json.data;
            },

            createdRow: function (row, data, dataIndex) {
            },
            
            columns: [
                {data: 'Serial Number'},
                {data: 'REGION'},
                {data: 'Search Ring'},
                {data: 'TOWERCO'},

            ],    

        }); 

    
        $('.assigned-sites-table').on('click', 'tbody tr', function(e){
            e.preventDefault();

            $('#towerco_details').modal('show');
            $('#towerco_details').find('.modal-title').html('<i class="pe-7s-gleam pe-lg mr-2"></i>' + $(this).find('td:first').text());

        });

</script>

@endsection
