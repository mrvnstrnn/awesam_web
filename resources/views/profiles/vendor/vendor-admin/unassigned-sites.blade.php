@extends('layouts.main')

@section('content')
<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
    
    .dropzone {
        min-height: 20px !important;
        border: 2px dashed #3f6ad8 !important;
        border-radius: 10px;
        padding: unset !important;
    }

    .ui-datepicker.ui-datepicker-inline {
    width: 100% !important;
    }
    
    .ui-datepicker table {
        font-size: 1.3em;
    }
    
</style>

    {{-- <x-assigned-sites mode="vendor"/> --}}
    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Unassigned Sites" activitytype="unassigned sites"/>

@endsection


@section('modals')

<div class="modal fade" id="modal-assign-sites" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        Assign Sites
                                    </h5>
                                </div>
                            </div>
                        </div> 

                        <form id="agent_form">
                            <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                                <div class="form-row">
                                <input type="hidden" id="sam_id" name="sam_id">
                                    <select name="agent_id" id="agent_id" class="form-control"></select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-assign-sites" data-href="{{ route('assign.supervisor') }}" data-activity_name="site_assign">Assign</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 1;
    var table_to_load = 'unassigned_site';
    var main_activity = 'Unassigned Sites';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
{{-- <script src="{{ asset('js/supervisor.js') }}"></script> --}}

<script>
    $('.assigned-sites-table').on( 'click', 'tr td:first-child', function (e) {
        e.preventDefault();
        if ($(this).attr("colspan") != 4) {
            $(document).find('#modal-assign-sites').modal('show');
            
            $("#modal-assign-sites select#agent_id").append(
                '<option value="">Processing...</option>'
            );

            $("#sam_id").val($(this).parent().attr('data-sam_id'));
            $("#btn-assign-sites").attr('data-id', $(this).parent().attr('data-id'));
            $("#btn-assign-sites").attr('data-site_vendor_id', $(this).parent().attr('data-vendor_id'));
            $("#btn-assign-sites").attr('data-program', $(this).parent().attr('data-what_table'));
            
            $("#btn-assign-sites").attr("data-site_name", $(this).parent().attr('data-site'));
            $("#btn-assign-sites").attr("data-program_id", $(this).parent().attr('data-program_id'));
            $("#btn-assign-sites").attr("data-site_category", $(this).parent().attr('data-site_category'));
            $("#btn-assign-sites").attr("data-activity_id", $(this).parent().attr('data-activity_id'));

            // $("#modal-assign-sites select#agent_id option").remove();

            $.ajax({
                url: "/get-agent-based-program/"+ $(this).parent().attr('data-program_id'),
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        
                        $("#modal-assign-sites select#agent_id option").remove();

                        resp.message.forEach(element => {
                            $("#modal-assign-sites select#agent_id").append(
                                '<option value="'+element.id+'">'+element.name+'</option>'
                            );
                        });

                        $("#modal-assign-sites").modal("show");
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
        }
    } );

    $(document).on('click',"#btn-assign-sites", function(e){
        e.preventDefault();

        $(this).attr('disabled', 'disabled');
        $(this).text('Processing...');
        var sam_id = $("#sam_id").val();
        var agent_id = $("#agent_id").val();

        var table = $(this).attr('data-program');
        var data_program = $(this).attr('data-program_id');
        var site_name = $(this).attr('data-site_name');
        var activity_name = $(this).attr('data-activity_name');
        var site_vendor_id = $(this).attr('data-site_vendor_id');
        var site_category = $(this).attr('data-site_category');
        var activity_id = $(this).attr('data-activity_id');

        $.ajax({
            url: $(this).attr('data-href'),
            data: {
                sam_id : sam_id,
                agent_id : agent_id,
                site_name : site_name,
                activity_name : activity_name,
                site_vendor_id : site_vendor_id,
                data_program : data_program,
                site_category : site_category,
                activity_id : activity_id
            },
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#"+table).DataTable().ajax.reload(function(){
                        $("#modal-assign-sites").modal("hide");
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $("#btn-assign-sites").removeAttr('disabled');
                        $("#btn-assign-sites").text('Assign');
                    });
                } else {
                    $("#btn-assign-sites").removeAttr('disabled');
                    $("#btn-assign-sites").text('Assign');
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },
            error: function(resp){
                $("#btn-assign-sites").removeAttr('disabled');
                $("#btn-assign-sites").text('Assign');
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