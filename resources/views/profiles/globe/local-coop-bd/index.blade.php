@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="localcoop" tableheader="Local Cooperatives" activitytype="all"/>

@endsection


@section('modals')
<style>
    #issues_table tbody tr:hover {
        cursor: pointer;
        background-color: rgb(221, 221, 221);
    }
</style>

<div id="coop_details" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">COOP Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="mb-3 card mb-0" style="box-shadow: none;">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-details" class="nav-link active">Details</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-contacts" class="nav-link">Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-engagements" class="nav-link">Engagements</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-coop-issues" class="nav-link">Issues</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-coop-details" role="tabpanel">
                        </div>
                        <div class="tab-pane" id="tab-coop-contacts" role="tabpanel">
                            <table class="table" id="contacts_table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Staff</th>
                                        <th>Type</th>
                                        <th>Firstame</th>
                                        <th>Lastame</th>
                                        <th>Cellphone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-coop-engagements" role="tabpanel">
                            <table class="table" id="engagement_table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Staff</th>
                                        <th>Type</th>
                                        <th>Result</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-coop-issues" role="tabpanel">
                            <div id="issue_table_box">
                                <table class="table" id="issues_table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Staff</th>
                                            <th>Dependency</th>
                                            <th>Nature of Issue</th>
                                            <th>Description</th>
                                            <th>Status of Issue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div id="issue_history_box" class="d-none">
                                <div class="row border-bottom mb-3">
                                    <div class="col-sm-6">
                                        <H5>Issue History</H5>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-secondary mb-1" id="btn_back_to_issues" >Back to Issues</button>
                                        <button type="button" class="btn btn-primary mb-1" id="btn_add_issue" >Add History</button>
                                    </div>
                                </div>
                                <table class="table" id="issues_history">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Staff</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div id="issue_add_box" class="d-none">
                                <div class="row border-bottom mb-3">
                                    <div class="col-sm-6">
                                        <H5>Add History</H5>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-secondary mb-1" id="btn_cancel_add_issues" >Cancel Add Issue</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
      

<div id="add_issue" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Issue</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="">
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">COOP</label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        @php
                            $coops = \DB::connection('mysql2')
                                ->table("local_coop")
                                ->get();
                        @endphp
                        <option>COOP</option>
                        @foreach ($coops as $coop)
                            <option>{{$coop->coop_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Dependency</label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        <option>Dependency</option>
                        <option>COOP</option>
                        <option>Globe</option>
                        <option>LGU</option>
                        <option>Others</option>
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Nature of Issue </label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        <option>Nature of Issue</option>
                        <option>Bills Payment</option>
                        <option>Power Upgrade</option>
                        <option>Power Application</option>
                        <option>Cable Regrooming</option>
                        <option>Pole Related Concern</option>
                        <option>JPA</option>
                        <option>RTA</option>
                        <option>Business Related Concerns</option>
                        <option>Others</option>
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleText" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="text" id="exampleText" class="form-control"></textarea>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Issue Raised By</label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        <option>Issue Raised By</option>
                        <option>COOP</option>
                        <option>Globe</option>
                    </select>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Issue Raised By (Name)</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Issue Raised By (Name)">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Date of Issue</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Date of Issue">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Issue Assigned To</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Issue Assigned To">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Status of Issue</label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        <option>Status of Issue</option>
                        <option>Not Started</option>
                        <option>Ongoing</option>
                        <option>On Hold</option>
                        <option>Resolved</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Add Issue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div id="add_engagement" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Engagement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="">
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">COOP</label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        @php
                            $coops = \DB::connection('mysql2')
                                ->table("local_coop")
                                ->get();
                        @endphp
                        <option>Select COOP</option>
                        @foreach ($coops as $coop)
                            <option>{{$coop->coop_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Engagement Type</label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        <option>Select Engagement Type</option>
                        <option>Power Upgrade</option>
                        <option>New Sites</option>
                        <option>Sites for Permanent Power</option>
                        <option>RTA</option>
                        <option>JPA</option>
                        <option>Bills Payment</option>
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleSelect" class="col-sm-3 col-form-label">Result of Engagement</label>
                <div class="col-sm-9">
                    <select name="select" id="exampleSelect" class="form-control">
                        <option>Select Engagement Result</option>
                        <option>Positive</option>
                        <option>Negative</option>
                        <option>Engaged</option>
                    </select>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="exampleText" class="col-sm-3 col-form-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="text" id="exampleText" class="form-control"></textarea>
                </div>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Add Engagement</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="add_contact" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Engagement</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="">
              <div class="position-relative row form-group">
                  <label for="exampleSelect" class="col-sm-3 col-form-label">COOP</label>
                  <div class="col-sm-9">
                      <select name="select" id="exampleSelect" class="form-control">
                          @php
                              $coops = \DB::connection('mysql2')
                                  ->table("local_coop")
                                  ->get();
                          @endphp
                          <option>Select COOP</option>
                          @foreach ($coops as $coop)
                              <option>{{$coop->coop_name}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="position-relative row form-group">
                  <label for="contact_type" class="col-sm-3 col-form-label">Contact Type</label>
                  <div class="col-sm-9">
                      <select name="select" id="contact_type" name="contact_type" class="form-control">
                          <option>Select Contact Type</option>
                          <option>Engineering</option>
                          <option>COOP Contact</option>
                      </select>
                  </div>
              </div>
              <div class="position-relative row form-group">
                  <label for="firstname" class="col-sm-3 col-form-label">Firstname</label>
                  <div class="col-sm-9">
                      <input type="text" value="" placeholder="Firstname" name="firstname" id="firstname" class="form-control" />
                  </div>
              </div>
              <div class="position-relative row form-group">
                <label for="lastname" class="col-sm-3 col-form-label">Lastname</label>
                <div class="col-sm-9">
                    <input type="text" value="" placeholder="Lastname" name="lastname" id="lastname" class="form-control"/>
                </div>
              </div>
              <div class="position-relative row form-group">
                <label for="cellphone" class="col-sm-3 col-form-label">Cellphone</label>
                <div class="col-sm-9">
                    <input type="number" value="" placeholder="Cellphone" name="cellphone" id="cellphone" class="form-control"/>
                </div>
              </div>
              <div class="position-relative row form-group">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" value="" placeholder="Email" name="email" id="email" class="form-control"/>
                </div>
              </div>
            </form>
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Add Contact</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 18;
    var table_to_load = 'local_coop';
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
{{-- <script type="text/javascript" src="/js/modal-loader.js"></script>   --}}

<script>

    // $('.show_activity_modal').on( 'click', function (e) {
    // });
        $('li').on('click','a', function(e){
            e.preventDefault();

            if($(this).attr('href')==' /add-issue '){
                $('#add_issue').modal('show');
            }

            else if($(this).attr('href')==' /add-engagement '){
                $('#add_engagement').modal('show');
            }

            else if($(this).attr('href')==' /add-contact '){
                $('#add_contact').modal('show');
            }

        });
    
        $('.assigned-sites-table').on('click', 'tbody tr', function(e){
            e.preventDefault();
            $('#coop_details').modal('show');
            $('#coop_details').find('.modal-title').html($(this).find('td:first').text());

            $('#tab-coop-details').html('');
            $('#contacts_table tbody').empty();
            $('#engagement_table tbody').empty();
            $('#issues_table tbody').empty();
            

            $.ajax({
                    url: "/localcoop-details/" + $(this).find('td:first').text(),
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){

                        console.log(resp[0]);
                        var columns = resp[0];
                        
                        var html = "";

                        Object.keys(columns).forEach(function (key, index){
                            html = html + "<div class='row'><div class='col-5'>" + key + "</div><div class='col-7'><input class='form-control mb-2' type='text' value='" + columns[key] + "' readonly /></div></div>";
                        });

                        $('#tab-coop-details').html(html);

                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
            });

            $.ajax({
                    url: "/localcoop-values/" + $(this).find('td:first').text() + "/contacts",
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){

                        var html = "";
                        resp.forEach(function(data){

                            var dateParts = data['add_timestamp'].split("-");
                            var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
                            var dateString = moment(jsDate).format('YYYY-MM-DD');

                            var engagement = JSON.parse(data['value'].replace(/&quot;/g,'"'));
                            html = html + "<tr>";
                            
                                html = html + "<td>" + dateString + "</td><td>" + data['firstname'] + " " +  data['lastname'] + "</td>"

                            Object.keys(engagement).forEach(function (key, index){

                                    html = html + "<td>" + engagement[key] + "</td>";
                                
                                console.log(key + " : " + engagement[key]);

                            });
                            html = html + "</tr>";
                        });

                        $('#contacts_table tbody').empty();
                        $('#contacts_table tbody').append(html);
                        $('#contacts_table').DataTable();


                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
            });

            $.ajax({
                    url: "/localcoop-values/" + $(this).find('td:first').text() + "/engagements",
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){

                        var html = "";
                        resp.forEach(function(data){

                            var dateParts = data['add_timestamp'].split("-");
                            var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
                            var dateString = moment(jsDate).format('YYYY-MM-DD');

                            var engagement = JSON.parse(data['value'].replace(/&quot;/g,'"'));
                            html = html + "<tr>";
                            
                                html = html + "<td>" + dateString + "</td><td>" + data['firstname'] + " " +  data['lastname'] + "</td>"

                            Object.keys(engagement).forEach(function (key, index){

                                    html = html + "<td>" + engagement[key] + "</td>";
                                
                                console.log(key + " : " + engagement[key]);

                            });
                            html = html + "</tr>";
                        });

                        $('#engagement_table tbody').empty();
                        $('#engagement_table tbody').append(html);
                        $('#engagement_table').DataTable();


                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
            });

            $.ajax({
                    url: "/localcoop-values/" + $(this).find('td:first').text() + "/issues",
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){

                        var html = "";
                        resp.forEach(function(data){

                            var dateParts = data['add_timestamp'].split("-");
                            var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
                            var dateString = moment(jsDate).format('YYYY-MM-DD');
                            var allowed_issues_column = ["dependency", "nature_of_issue", "description", "status_of_issue"];

                            var engagement = JSON.parse(data['value'].replace(/&quot;/g,'"'));
                            html = html + "<tr>";
                            
                                html = html + "<td>" + dateString + "</td><td>" + data['firstname'] + " " +  data['lastname'] + "</td>"

                            Object.keys(engagement).forEach(function (key, index){

                                console.log(key + " : " + engagement[key]);
                                if(allowed_issues_column.includes(key) == true){
                                html = html + "<td>" + engagement[key] + "</td>";
                                }

                            });
                            html = html + "</tr>";
                        });

                        $('#issues_table tbody').empty();
                        $('#issues_table tbody').append(html);
                        $('#issues_table').DataTable();

                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
            });

        });

        $(document).on('click', '#issues_table tbody tr', function(e){
            e.preventDefault();

            $('#issue_table_box').addClass('d-none');
            $('#issue_history_box').removeClass('d-none');

            $('#issues_history').DataTable();

        });

        $(document).on('click', '#btn_back_to_issues', function(e){

            $('#issue_table_box').removeClass('d-none');
            $('#issue_history_box').addClass('d-none');

        });

        $(document).on('click', '#btn_add_issue', function(e){

            $('#issue_history_box').addClass('d-none');
            $('#issue_add_box').removeClass('d-none');

        });
        
        $(document).on('click', '#btn_cancel_add_issues', function(e){

            $('#issue_history_box').removeClass('d-none');
            $('#issue_add_box').removeClass('d-none');

        });
        
        


</script>

@endsection

