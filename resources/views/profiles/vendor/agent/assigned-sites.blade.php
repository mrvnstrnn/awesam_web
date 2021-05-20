@extends('layouts.main')

@section('content')
<style>
    .assigned-sites-table {
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
                                Assigned Sites
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="assigned-sites-{{ strtolower(str_replace(" ", "-", $program->program))  }}-table" 
                                    class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table"
                                    data-href="{{ route('agent_assigned_sites.list', [$program->program_id]) }}"
                                    data-program_id="{{ $program->program_id  }}"
                                    >
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
        @endforeach

    </div>
@endsection

@section('js_script')
<script type="text/javascript">

    var cols = [];


    $('.assigned-sites-table').each(function(i, obj) {

        // console.log( document.getElementById(obj.id));

        var activeTable = document.getElementById(obj.id)


        if($(activeTable).attr('data-program_id')==='3'){

            cols = [
                {data : 'sam_id', name: 'SAM ID'},
                {data : 'site_name', name: 'Site Name'}, 
                {
                    data : 'site_fields',
                    name: 'Nomination ID', 
                    render : function(data){
                            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                            return col["NOMINATION_ID"];
                    },
                },
                {
                    data : 'site_fields',
                    name: 'Technology', 
                    render : function(data){
                            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                            return col["TECHNOLOGY"];
                    },
                },
                {
                    data : 'site_fields',
                    name: 'PLA_ID', 
                    render : function(data){
                            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                            return col["PLA_ID"];
                    },
                },
                {
                    data : 'site_fields',
                    name: 'Location', 
                    render : function(data){
                        col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                        $field = '<div class="widget-content-left flex2">' +
                                    '<div class="widget-heading">' + col['REGION'] + '</div>' +
                                    '<div class="widget-subheading opacity-7">' + col['LOCATION'] + '</div>' +
                                '</div>';
                        return $field;
                    },
                },
            ];

        }
        else if($(activeTable).attr('data-program_id')==='4'){
            cols = [
                {data : 'sam_id', name: 'SAM ID'},
                {data : 'site_name', name: 'Site Name'}, 
                {
                    data : 'site_fields',
                    name: 'PLA_ID', 
                    render : function(data){
                            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                            return col["PLA_ID"];
                    },
                },
                {
                    data : 'site_fields',
                    name: 'PROGRAM', 
                    render : function(data){
                            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                            return col["PROGRAM"];
                    },
                },
                {
                    data : 'site_fields',
                    name: 'Location', 
                    render : function(data){
                        col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
                        $field = '<div class="widget-content-left flex2">' +
                                    '<div class="widget-heading">' + col['REGION'] + '</div>' +
                                '</div>';

                        return $field;
                    },
                },
            ];
        } else {
            cols = [];
        }

        $.each(cols, function (k, colObj) {
                str = '<th>' + colObj.name + '</th>';
                $(str).appendTo($(activeTable).find("thead>tr"));
        });




        var table = $(activeTable).DataTable({
          processing: true,
          serverSide: true,          
        //   ajax: "{{ route('agent_assigned_sites.list', [3]) }}", 
          
          ajax: {
                url: $(activeTable).attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
          
          columns: cols,
          createdRow: function (row, data, dataIndex) {
             $(row).attr('data-site_fields', data.site_fields.replace(/&quot;/g,'"'));
             $(row).attr('data-sam_id', data.sam_id);
             $(row).attr('data-site_name', data.site_name);
          }
      });


    });


    $('.assigned-sites-table').on( 'click', 'tr td', function (e) {
        e.preventDefault();
        var json_parse = JSON.parse($(this).parent().attr('data-site_fields'));
        // console.log(json_parse);

        $("#modal-site_fields").html('');

        Object.entries(json_parse).forEach(([key, value]) => {
            Object.entries(value).forEach(([keys, values]) => {
                $("#modal-site_fields").append(
                    '<div class="position-relative form-group col-md-6">' +
                        '<label for="' + keys.toLowerCase() + '" style="font-size: 11px;">' +  keys + '</label>' +
                        '<input class="form-control"  value="'+values+'" name="' + keys.toLowerCase() + '"  id="'+key.toLowerCase()+'" >' +
                    '</div>'
                );
            });
        });

        $("#modal_site_name").text($(this).parent().attr('data-site_name'));
        $("#modal-site_details").modal("show");
    } );



  </script>  


@endsection


@section('modals')

<div class="modal fade" id="modal-site_details" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Site Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                <H3 id="modal_site_name">Site Information</H3>
                <div class="divider"></div>
                <div class="row" id="modal-site_fields">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-outline-success" data-dismiss="modal" aria-label="Close">
                    Close
                </button>
                <button type="button" class="btn btn btn-success" data-complete="false" id="" data-href="">View Full Information</button>
            </div>
        </div>
    </div>
</div>

@endsection
