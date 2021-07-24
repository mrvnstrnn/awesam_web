@extends('layouts.main')

@section('content')

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

<div id="coop_details" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark">Coop Details</h5>
            <button type="button" class="close modal_close text-dark">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="mb-3 card mb-0" style="box-shadow: none;">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-details" class="nav-link active">Details</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-sts" class="nav-link">STS</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-ram" class="nav-link">RAM</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-towerco" class="nav-link">TowerCo</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-agile" class="nav-link">Agile</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-towerco-details" role="tabpanel">
                        </div>
                        <div class="tab-pane" id="tab-towerco-sts" role="tabpanel">
                        </div>
                        <div class="tab-pane" id="tab-towerco-ram" role="tabpanel">
                        </div>
                        <div class="tab-pane" id="tab-towerco-towerco" role="tabpanel">
                        </div>
                        <div class="tab-pane" id="tab-towerco-agile" role="tabpanel">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal_close">Close</button>
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
                            $coops = \DB::connection('mysql2')
                                ->table("local_coop")
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
                            $coops = \DB::connection('mysql2')
                                ->table("local_coop")
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
                                $coops = \DB::connection('mysql2')
                                    ->table("local_coop")
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

    
    // $('.show_activity_modal').on( 'click', function (e) {
    // });
        // $('li').on('click','a', function(e){
        //     e.preventDefault();

        //     if($(this).attr('href')==' /add-issue '){
        //         $('#add_issue').modal('show');
        //     }

        //     else if($(this).attr('href')==' /add-engagement '){
        //         $('#add_engagement').modal('show');
        //     }

        //     else if($(this).attr('href')==' /add-contact '){
        //         $('#add_contact').modal('show');
        //     }

        // });
    
        $('.assigned-sites-table').on('click', 'tbody tr', function(e){
            e.preventDefault();

            $("#btn_back_to_issues").trigger("click");
            $('#coop_details').modal('show');

            $('#coop_details').find('.modal-title').html('<i class="pe-7s-gleam pe-lg mr-2"></i>' + $(this).find('td:first').text());

            $('#tab-coop-details').html('');
            $('#contacts_table tbody').empty();
            $('#engagement_table tbody').empty();
            $('#issues_table tbody').empty();

            var id = JSON.parse($(this).attr('data-site_all')).id;

            $("#contacts_table").addClass("contacts_table"+id);
            $("#engagement_table").addClass("engagement_table"+id);
            $("#issues_table").addClass("issues_table"+id);
            $("#save_history").attr('data-issue_id', id);

            $("#hidden_program_id").val( $(this).parent().parent().attr('data-program_id') );
            
            $(".add_history_form select#user_id option").remove();

            $(".table_contact_parent").html(
                '<table class="table_contact_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>Date</th>' +
                            '<th>Type</th>' +
                            '<th>Firstname</th>' +
                            '<th>Lastname</th>' +
                            '<th>Cellphone</th>' +
                            '<th>Email</th>' +
                            '<th></th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>'
            );

            $(".table_engagements_parent").html(
                '<table class="table_engagements_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>Date</th>' +
                            '<th>Type</th>' +
                            '<th>Result</th>' +
                            '<th>Remarks</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>'
            );

            $(".table_issues_parent").html(
                '<table class="table_issues_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>Date</th>' +
                            '<th>Dependency</th>' +
                            '<th>Nature of Issue</th>' +
                            '<th>Description</th>' +
                            '<th>Issue Raised By</th>' +
                            '<th>Issue Raised By Name</th>' +
                            '<th>Date Of Issue</th>' +
                            '<th>Issue Assigned To</th>' +
                            '<th>Status of Issue</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>'
            );

            $(".table_contact_parent table").attr("id", "table_contact_child_" + id);
            $(".table_engagements_parent table").attr("id", "table_engagements_child_" + id);
            $(".table_issues_parent table").attr("id", "table_issues_child_" + id);
            
            $.ajax({
                    url: "/localcoop-details/" + $(this).find('td:first').text(),
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){

                        // console.log(resp[0]);
                        var columns = resp[0];
                        
                        var html = "";

                        Object.keys(columns).forEach(function (key, index){
                            field_name = key.charAt(0).toUpperCase() + key.slice(1);
                            html = html + "<div class='row'><div class='col-5'>" + field_name.split('_').join(' ') + "</div><div class='col-7'><input class='form-control mb-2' type='text' value='" + columns[key] + "' readonly /></div></div>";
                        });

                        $('#tab-coop-details').html(html);

                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
            });

            if ( ! $.fn.DataTable.isDataTable("#table_contact_child_" + id) || ! $.fn.DataTable.isDataTable("#table_engagements_child_" + id) || ! $.fn.DataTable.isDataTable("#table_issues_child_" + id) ){
                $("#table_contact_child_" + id).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/localcoop-values-data/" + $(this).find('td:first').text() + "/contacts",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    "order": [[ 0, 'desc' ]],
                    columns: [
                        { data: "add_timestamp" },
                        { data: "type" },
                        { data: "firstname" },
                        { data: "lastname" },
                        { data: "cellphone" },
                        { data: "email" },
                        { data: "action" },
                    ],
                });

                $("#table_engagements_child_" + id).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/localcoop-values-data/" + $(this).find('td:first').text() + "/engagements",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    'createdRow': function( row, data, dataIndex ) {
                        $(row).attr('data-value', JSON.stringify(data));
                        $(row).attr('style', 'cursor: pointer');
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    "order": [[ 0, 'desc' ]],
                    columns: [
                        { data: "add_timestamp" },
                        { data: "engagement_type" },
                        { data: "result_of_engagement" },
                        { data: "remarks" },
                    ],
                });

                $("#table_issues_child_" + id).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/localcoop-values-data/" + $(this).find('td:first').text() + "/issues",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    'createdRow': function( row, data, dataIndex ) {
                        $(row).attr('data-value', JSON.stringify(data));
                        $(row).attr('data-id', data.ID);
                        $(row).attr('style', 'cursor: pointer');
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    "order": [[ 0, 'desc' ]],
                    columns: [
                        { data: "add_timestamp" },
                        { data: "dependency" },
                        { data: "nature_of_issue" },
                        { data: "description" },
                        { data: "issue_raised_by" },
                        { data: "issue_raised_by_name" },
                        { data: "date_of_issue" },
                        { data: "issue_assigned_to" },
                        { data: "status_of_issue" },
                    ],
                });
            } else {
                $("#table_contact_child_" + id).DataTable().ajax.reload();
                $("#table_engagements_child_" + id).DataTable().ajax.reload();
                $("#table_issues_child_" + id).DataTable().ajax.reload();
            }

            $.ajax({
                    url: "/agent-based-program/"+$(this).parent().parent().attr('data-program_id'),
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){
                        if (!resp.error) {
                            resp.message.forEach(element => {
                                $(".add_history_form select#user_id").append(
                                    '<option value="'+element.id+'">'+element.name+'</option>'
                                );
                            });
                        } else {
                            toastr.error(resp.message, "Error");
                        }
                    },
                    error: function (resp){
                        toastr.error(resp, "Error");
                    }
            });

        });

        $(document).on('click', '.table_issues_child tbody tr', function(e){
            e.preventDefault();

            if ($('.table_issues_parent tbody tr td').attr("colspan") != 9) {

                var value_data = JSON.parse($(this).attr('data-value'));

                $(".issue_form_view #coop").val(value_data.coop);
                $(".issue_form_view #dependency").val(value_data.dependency);
                $(".issue_form_view #nature_of_issue").val(value_data.nature_of_issue);
                $(".issue_form_view #description").text(value_data.description);
                $(".issue_form_view #issue_raised_by").val(value_data.issue_raised_by);
                $(".issue_form_view #issue_raised_by_name").val(value_data.issue_raised_by_name);
                $(".issue_form_view #date_of_issue").val(value_data.date_of_issue);
                $(".issue_form_view #issue_assigned_to").val(value_data.issue_assigned_to);
                $(".issue_form_view #status_of_issue").val(value_data.status_of_issue);

                $('#issue_table_box').addClass('d-none');
                $('#issue_history_box').removeClass('d-none');
                $('.issue_form_view').removeClass('d-none');

                $("#issue_id").val( $(this).attr("data-id") );

                var id = $(this).attr("data-id");

                $(".table_history_parent").html(
                    '<table class="table_history_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>Date</th>' +
                                '<th>Staff</th>' +
                                '<th>Remarks</th>' +
                                '<th>Status</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>'
                );
                
                $(".table_history_parent table").attr("id", "table_history_child_" + id);

                if (! $.fn.DataTable.isDataTable("#table_history_child_" + id) ){
                    $("#table_history_child_" + id).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '/issue-history-data/'+ id,
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        dataSrc: function(json){
                            return json.data;
                        },
                        "order": [[ 0, 'desc' ]],
                        columns: [
                            { data: "add_timestamp" },
                            { data: "staff" },
                            { data: "remarks" },
                            { data: "status" },
                        ],
                    });
                } else {
                    $("#table_history_child_" + id).DataTable().ajax.reload();
                }
            }

        });

        $(document).on('click', '.table_engagements_child tbody tr', function(e){
            e.preventDefault();

            if ($('.table_engagements_child tbody tr td').attr("colspan") != 4) {
                var value_data = JSON.parse($(this).attr('data-value'));

                $(".engagement_form_view #coop").val(value_data.coop);
                $(".engagement_form_view #engagement_type").val(value_data.engagement_type);
                $(".engagement_form_view #result_of_engagement").val(value_data.result_of_engagement);
                $(".engagement_form_view #remarks").text(value_data.remarks);


                $('.engagement_form_view').removeClass('d-none');
                $('.table_engagements_parent').addClass('d-none');
            }

        });

        
        $(document).on('click', '.back_to_engagement_list', function(e){ 
            $('.engagement_form_view').addClass('d-none');
            $('.table_engagements_parent').removeClass('d-none');
        });

        $(document).on('click', '#btn_back_to_issues', function(e){

            $('#issue_table_box').removeClass('d-none');
            $('#issue_history_box').addClass('d-none');
            $('.issue_form_view').addClass('d-none');

        });

        $(document).on('click', '#btn_add_issue', function(e){

            $('#issue_history_box').addClass('d-none');
            $('#issue_add_box').removeClass('d-none');
            $('.issue_form_view').addClass('d-none');

        });
        
        $(document).on('click', '#btn_cancel_add_issues', function(e){

            $('#issue_history_box').removeClass('d-none');
            $('#issue_add_box').addClass('d-none');
            $('.issue_form_view').removeClass('d-none');

        });
        
        $(document).on("click", ".add_engagement", function () {
            var type = $(this).attr("data-type");
            var table_id = $(this).attr("data-issue_id");
            
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            if (type == "engagements") {
                $(".engagement_form small").text("");
                var form_id = ".engagement_form";
                var data_serialize = $(form_id).serialize();
                var modal_id = "#add_engagement";
                var button_id = "#add_engagement_btn";
                var button_text = "Add Engagement";
            } else if (type == "contacts") {
                if ($('.contact_form_update #ID').val() != "") {
                    $(".contact_form_update small").text("");
                    var form_id = ".contact_form_update";
                    var data_serialize = $(form_id).serialize();
                    var button_id = "#btn_update_contact";
                    var button_text = "Update";
                } else {
                    $(".contact_form small").text("");
                    var form_id = ".contact_form";
                    var data_serialize = $(form_id).serialize();
                    var modal_id = "#add_contact";
                    var button_id = "#add_contact_btn";
                    var button_text = "Add Contact";
                }
            } else if (type == "issues") {
                $(".issue_form small").text("");
                var form_id = ".issue_form";
                var data_serialize = $(form_id).serialize();
                var modal_id = "#add_issue";
                var button_id = "#add_issue_btn";
                var button_text = "Add Issue";
            } else if (type == "issue_history") {
                var id = $("#hidden_program_id").val();
                var issue_id = $("#issue_id").val();
                $(".add_history_form small").text("");
                var form_id = ".add_history_form";
                var data_serialize = $(form_id).serialize();
                var modal_id = "#add_issue";
                var button_id = "#save_history";
                var button_text = "Save History";
            }
            
            $.ajax({
                url: "/add-coop-value",
                method: "POST",
                data: data_serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        if ($('.contact_form_update #ID').val() == "") {
                            $(modal_id).modal("hide");
                        }
                        $(form_id)[0].reset();
                        $(button_id).removeAttr("disabled");
                        $(button_id).text(button_text);

                        if ($(".add_engagement").attr("data-type") == "issue_history") {
                            $("#btn_cancel_add_issues").trigger("click");
                            $("#table_history_child_" + issue_id).DataTable().ajax.reload();
                            $("#table_issues_child_" + table_id).DataTable().ajax.reload();
                        } else if ($('.contact_form_update #ID').val() != "") {
                            $(".table_contact_child").DataTable().ajax.reload();
                            $(".cancel_update").trigger("click");
                        }

                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $(button_id).removeAttr("disabled");
                        $(button_id).text(button_text);
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(form_id + " ." + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }
                        $(button_id).removeAttr("disabled");
                        $(button_id).text(button_text);
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(button_id).removeAttr("disabled");
                    $(button_id).text(button_text);
                }
            });
        });

        $(document).on("click", ".edit_contact", function(e){
            e.preventDefault();

            var id = $(this).attr("data-id");
            var action = $(this).attr("data-action");

            $.ajax({
                url: "/edit-contact/"+id+"/"+action,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        var value = JSON.parse(resp.message.value);
                        
                        $('.contact_form_update #coop').val(resp.message.coop).trigger('change');
                        $('.contact_form_update #contact_type').val(value.contact_type).trigger('change');

                        $('.contact_form_update #ID').val(resp.message.ID);
                        $('.contact_form_update #contact_number').val(value.contact_number);
                        $('.contact_form_update #email').val(value.email);
                        $('.contact_form_update #firstname').val(value.firstname);
                        $('.contact_form_update #lastname').val(value.lastname);
                        $('.contact_form_update #action').val("contacts");

                        $(".contact_div_edit").removeClass("d-none");
                        $(".table_contact_parent").addClass("d-none");
                    } else {
                        Swal.fire(
                            'Error',
                            resp,
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

        $(document).on("click", ".cancel_update", function (e) {
            e.preventDefault();

            $(".contact_div_edit").addClass("d-none");
            $(".table_contact_parent").removeClass("d-none");
        })

        $(document).on("click", ".modal_close", function (e) {
            e.preventDefault();

            $("#coop_details").modal("hide");
            $("#btn_cancel_add_issues").trigger("click");
            $("#btn_back_to_issues").trigger("click");
            $("a[href='#tab-coop-details']").trigger("click");
        });

        $(document).on("click", ".modal_close", function (e) {
            
        });

</script>

@endsection
