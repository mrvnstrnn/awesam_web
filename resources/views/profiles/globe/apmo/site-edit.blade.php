@extends('layouts.main')

@section('content')
<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>    

    {{-- <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="New Endorsements" activitytype="new endorsements globe"/> --}}
    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Site Editor" activitytype="site editor"/>

@endsection


@section('modals')

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                        <h5 class="menu-header-title">
                                            Site Editor
                                        </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body form-row" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">

                        </div>
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
    var profile_id = 8;
    var table_to_load = 'apmo_site_edit';
    var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
{{-- <script type="text/javascript" src="/js/modal-loader.js"></script>   --}}

<script>

    $(document).ready(function () {

    
        $('.assigned-sites-table').on( 'click', 'tr td:not(:first-child)', function (e) {
            e.preventDefault();
            $(document).find('#viewInfoModal').modal('show');

            var json_parse = JSON.parse($(this).parent().attr('data-site_all'));

            $(".btn-accept-endorsement").attr('data-program', $(this).parent().attr('data-program'));

            allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"];

            var what_table = $(this).closest('tr').attr('data-what_table');
            var program_id = $(this).closest('tr').attr('data-program_id');

            $.ajax({
                url: '/get-program-fields/' + json_parse.sam_id + '/' + $(this).closest('tr').attr('data-program_id'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){

                        $(".card-body .position-relative.form-group").remove();
                        $(".main-card.mb-3.card .modal-footer").remove();

                        $.each(resp.message[0], function(index, data) {
                            field_name = index.charAt(0).toUpperCase() + index.slice(1);
                            $("#viewInfoModal .card-body").append(
                                '<div class="position-relative form-group col-md-6">' +
                                    '<label for="' + index.toLowerCase() + '" style="font-size: 11px;">' + field_name.split('_').join(' ') + '</label>' +
                                    '<input class="form-control"  value="'+data+'" name="' + index.toLowerCase() + '"  id="'+index.toLowerCase()+'" readonly>' +
                                '</div>'
                            );
                        });

                        $("#viewInfoModal .main-card.mb-3.card").append(
                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-primary btn-sm btn-accept-endorsement btn-shadow" data-complete="true" id="btn-accept-endorsement-true" data-href="/accept-reject-endorsement" data-activity_name="endorse_site">Endorse New Site</button>' +
                            '</div>'
                        );

                        $(".modal-title").text(json_parse.site_name);
                        $(".btn-accept-endorsement").attr('data-sam_id', json_parse.sam_id);
                        $(".btn-accept-endorsement").attr('data-site_category', json_parse.site_category);
                        $(".btn-accept-endorsement").attr('data-site_vendor_id', json_parse.vendor_id);
                        $(".btn-accept-endorsement").attr('data-activity_id', json_parse.activity_id);
                        $(".btn-accept-endorsement").attr('data-what_table', what_table);
                        $(".btn-accept-endorsement").attr('data-program_id', program_id);

                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });

            // $(".card-body .position-relative.form-group").remove();
            // $(".main-card.mb-3.card .modal-footer").remove();

            // if (json_parse.site_fields != null) {
            //     var new_json = JSON.parse(json_parse.site_fields.replace(/&quot;/g,'"'));

            //     for (let i = 0; i < new_json.length; i++) {
            //         field_name = new_json[i].field_name.charAt(0).toUpperCase() + new_json[i].field_name.slice(1);
            //         $("#viewInfoModal  .card-body").append(
            //             '<div class="position-relative form-group col-md-6">' +
            //                 '<label for="' + new_json[i].field_name.toLowerCase() + '" style="font-size: 11px;">' + field_name.split('_').join(' ') + '</label>' +
            //                 '<input class="form-control"  value="'+new_json[i].value+'" name="' + new_json[i].field_name.toLowerCase() + '"  id="'+new_json[i].field_name.toLowerCase()+'" >' +
            //             '</div>'
            //         );
            //     }
            // } else {
            //     $("#viewInfoModal .card-body").append(
            //         '<div class="position-relative form-group"><h1>No fields available.</h1></div>'
            //     );
            // }

            // $("#viewInfoModal .main-card.mb-3.card").append(
            //     '<div class="modal-footer">' +
            //         '<button type="button" class="btn btn-primary btn-sm btn-accept-endorsement btn-shadow" data-complete="true" id="btn-accept-endorsement-true" data-href="/accept-reject-endorsement" data-activity_name="endorse_site">Endorse New Site</button>' +
            //     '</div>'
            // );

            // $(".modal-title").text(json_parse.site_name);
            // $(".btn-accept-endorsement").attr('data-sam_id', json_parse.sam_id);
            // $(".btn-accept-endorsement").attr('data-site_category', json_parse.site_category);
            // $(".btn-accept-endorsement").attr('data-site_vendor_id', json_parse.vendor_id);
            // $(".btn-accept-endorsement").attr('data-activity_id', json_parse.activity_id);
            // $(".btn-accept-endorsement").attr('data-what_table', $(this).closest('tr').attr('data-what_table'));
            // $(".btn-accept-endorsement").attr('data-program_id', $(this).closest('tr').attr('data-program_id'));
        } );



        $(document).on("click", ".checkAll", function(e){
            e.preventDefault();


            var val = $(this).val();

            $(this).prop('checked', true);

            var atLeastOneIsChecked = $('input[name='+val+']:checkbox:checked').length > 0;
            
            if (!atLeastOneIsChecked) {
                $('input[name='+val+']').not(this).prop('checked', this.checked);
            } else {
                $('input[name='+val+']').not(this).prop('checked', false);
            }
        });

        $(document).on("click", ".btn-accept-endorsement", function(e){
            e.preventDefault();

            var sam_id = [$(this).attr('data-sam_id')];
            var data_complete = $(this).attr('data-complete');
            var what_table = $(this).attr('data-what_table');
            var data_program = $("#"+what_table).attr('data-program_id');
            var activity_name = $(this).attr('data-activity_name');
            var site_vendor_id = [$(this).attr('data-site_vendor_id')];
            var site_category = [$(this).attr('data-site_category')];
            var activity_id = [$(this).attr('data-activity_id')];

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: $(this).attr('data-href'),
                data: {
                    sam_id : sam_id,
                    data_complete : data_complete,
                    activity_name : activity_name,
                    site_vendor_id : site_vendor_id,
                    data_program : data_program,
                    site_category : site_category,
                    activity_id : activity_id,
                },
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+what_table).DataTable().ajax.reload(function(){
                            $("#viewInfoModal").modal("hide");
                            
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                            $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Accept Endorsement");
                            // $("#loaderModal").modal("hide");
                        });
                    } else {
                        // $("#loaderModal").modal("hide");
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                        $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Accept Endorsement");
                    }
                },
                error: function(resp){
                    // $("#loaderModal").modal("hide");
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    toastr.error(resp.message, 'Error');
                    $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                    $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Accept Endorsement");
                }
            });

        });

        $(".btn-bulk-acceptreject-endorsement").click(function(e){
            e.preventDefault();

            // var sam_id = $(this).attr('data-sam_id');
            var data_complete = $(this).attr('data-complete');
            var data_program = $(this).attr('data-program');
            var data_program_id = $(this).attr('data-id');
            var data_id = $(this).attr('data-id');
            var activity_name = $(this).attr('data-activity_name');

            var inputElements = document.getElementsByName('program'+data_id);

            var id = $(this).attr('id');

            var text = id == "reject"+data_program.replace(" ", "-") ? "Reject" : "Endorse New Sites";

            $("#"+id).attr("disabled", "disabled");
            $("#"+id).text("Processing...");


            sam_id = [];
            site_vendor_id = [];
            site_category = [];
            activity_id = [];
            for(var i=0; inputElements[i]; ++i){
                if(inputElements[i].checked){
                    sam_id.push(inputElements[i].value);
                    site_vendor_id.push(inputElements[i].attributes[5].value);
                    site_category.push(inputElements[i].attributes[6].value);
                    activity_id.push(inputElements[i].attributes[7].value);
                }
            }

            $.ajax({
                url: $(this).attr('data-href'),
                data: {
                    sam_id : sam_id,
                    data_complete : data_complete,
                    activity_name : activity_name,
                    data_program : data_program_id,
                    site_vendor_id : site_vendor_id,
                    site_category : site_category,
                    activity_id : activity_id
                },
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#assigned-sites-"+data_program.replace(" ", "-")+"-table").DataTable().ajax.reload(function(){
                            $("#modal-endorsement").modal("hide");
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )
                            $("#"+id).removeAttr("disabled");
                            $("#"+id).text(text);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        $("#"+id).removeAttr("disabled");
                        $("#"+id).text(text);
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $("#"+id).removeAttr("disabled");
                    $("#"+id).text(text);
                }
            });

        });
        
    })

</script>




@endsection