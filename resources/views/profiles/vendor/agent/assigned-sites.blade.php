@extends('layouts.main')

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>COLOC</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                            Assigned Sites
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="test" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table">
                                <thead>
                                    <tr></tr>
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
@endsection

@section('modals')

    <div class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none; padding-right: 17px;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas
                        eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
                    </p>
                    <p>
                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue
                        laoreet rutrum faucibus dolor auctor.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_script')
<script type="text/javascript">

    var cols = [
        {data : 'sam_id', name: 'SAM ID'},
        {data : 'site_name', name: 'Site Name'}, 
        {
            data : 'site_fields',
            name: 'Nomination ID', 
            render : function(data){
                    col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                    return col["NOMINATION_ID"];
            },
            orderable: true,
        },
        {
            data : 'site_fields',
            name: 'Technology', 
            render : function(data){
                    col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                    return col["TECHNOLOGY"];
            },
            orderable: true,
        },
        {
            data : 'site_fields',
            name: 'PLA_ID', 
            render : function(data){
                    col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                    return col["PLA_ID"];
            },
            orderable: true,
        },
        {
            data : 'site_fields',
            render : function(data){
                col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                $field = '<div class="widget-content-left flex2">' +
                            '<div class="widget-heading">' + col['REGION'] + '</div>' +
                            '<div class="widget-subheading opacity-7">' + col['LOCATION'] + '</div>' +
                         '</div>';

                return $field;
            },
            name: 'Status', 
            orderable: true,
        },
    ];

    $.each(cols, function (k, colObj) {
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo('#test'+'>thead>tr');
                });


    $(function () {
      var table = $('#test').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('agent_assigned_sites.list', [3]) }}",          
          columns: cols,
          createdRow: function (row, data, dataIndex) {
             $(row).attr('data-site_fields', data.site_fields.replace(/&quot;/g,'"'));
          }
      });
      
    });
  </script>  


@endsection