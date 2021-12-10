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

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="New Endorsements" activitytype="new endorsements globe"/>

@endsection


@section('modals')

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-keyboard="false">
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
                                            Endorsement
                                        </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body form-row" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                            <div class="row form_fields"></div>

                            <div class="row reject_remarks d-none">
                                <div class="col-12">
                                    <p class="message_p">Are you sure you want to reject this site <b></b>?</p>
                                    <form class="reject_form">
                                        <input type="hidden" name="sam_id" id="sam_id">
                                        <input type="hidden" name="type" id="type" value="reject_site">
                                        <div class="form-group">
                                            <label for="remarks">Remarks:</label>
                                            <textarea style="width: 100%;" name="remarks" id="remarks" rows="5" cols="100" class="form-control"></textarea>
                                            <small class="text-danger remarks-error"></small>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm btn-shadow confirm_reject">Confirm</button>
                                            
                                            <button class="btn btn-secondary btn-sm btn-shadow cancel_reject">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    var profile_id = 9;
    var table_to_load = 'new_endorsements_globe';
    var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
{{-- <script type="text/javascript" src="/js/modal-loader.js"></script>   --}}

<script>
    $('.assigned-sites-table').on( 'click', 'tr td:not(:first-child)', function (e) {
        e.preventDefault();
        $(document).find('#viewInfoModal').modal('show');

        var sam_id = $(this).parent().attr('data-sam_id');
        var program_id = $(this).parent().attr('data-sam_id');
        var site_category = $(this).parent().attr('data-site_category');
        var activity_id = $(this).parent().attr('data-activity_id');
        var site_name = $(this).parent().attr('data-site_name');

        $(".btn-accept-endorsement").attr('data-program', $(this).parent().attr('data-program'));

        allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"];

        // $("..content-data .position-relative.form-group").remove();
        $(".card-body .form_fields .position-relative.form-group").remove();
        $(".main-card.mb-3.card .modal-footer").remove();

        var what_table = $(this).closest('tr').attr('data-what_table');
        var program_id = $(this).closest('tr').attr('data-program_id');

        $.ajax({
            url: '/get-program-fields/' + sam_id + '/' + $(this).closest('tr').attr('data-program_id'),
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
                        $("#viewInfoModal .card-body .form_fields").append(
                            '<div class="position-relative form-group col-md-6">' +
                                '<label for="' + index.toLowerCase() + '" style="font-size: 11px;">' + field_name.split('_').join(' ') + '</label>' +
                                '<input class="form-control"  value="'+data+'" name="' + index.toLowerCase() + '"  id="'+index.toLowerCase()+'" readonly>' +
                            '</div>'
                        );
                    });

                    if ("{{ \Auth::user()->profile_id != 2 }}") {
                        $("#viewInfoModal .main-card.mb-3.card").append(
                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-primary btn-accept-endorsement btn-shadow btn-sm" data-complete="true" id="btn-accept-endorsement-true" data-href="/accept-reject-endorsement" data-activity_name="endorse_site">Accept Endorsement</button>' +
                                '<button type="button" class="btn btn btn-outline-danger btn-shadow btn-accept-endorsement btn-sm d-none" data-complete="false" id="btn-accept-endorsement-false" data-href="/accept-reject-endorsement" data-activity_name="endorse_site">Reject Site</button>' +

                                '<button type="button" class="btn btn btn-outline-danger btn-shadow btn-sm btn-reject" data-complete="false" id="btn-accept-endorsement-false">Reject Site</button>' +
                            '</div>'
                        );
                    } else {
                        $("#viewInfoModal .main-card.mb-3.card").append(
                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-primary btn-accept-endorsement btn-sm" data-complete="true" id="btn-accept-endorsement-true" data-href="/accept-reject-endorsement" data-activity_name="endorse_site">Endorse New Site</button>' +
                            '</div>'
                        );
                    }

                    $(".modal-title").text(site_name);
                    $(".btn-reject").attr('data-sam_id', sam_id);
                    $(".btn-accept-endorsement").attr('data-sam_id', sam_id);
                    $(".btn-accept-endorsement").attr('data-site_category', site_category);
                    // $(".btn-accept-endorsement").attr('data-site_vendor_id', vendor_id);
                    $(".btn-accept-endorsement").attr('data-activity_id', activity_id);
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
        
    } );

    $(document).on("click", ".checkAll", function(e){
        e.preventDefault();
        var val = $(this).val();
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
                site_vendor_id.push(inputElements[i].attributes[4].value);
                site_category.push(inputElements[i].attributes[5].value);
                activity_id.push(inputElements[i].attributes[6].value);
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
                activity_id : activity_id,
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

    $(document).on("click", ".btn-reject", function(e){
        e.preventDefault();

        $("#sam_id").val($(this).attr("data-sam_id"));
        $(".message_p b").text($(this).attr("data-sam_id"));
        $(".form_fields").addClass("d-none");
        $(".modal-footer").addClass("d-none");
        $(".reject_remarks").removeClass("d-none");
    });

    $(document).on("click", ".cancel_reject", function(e){
        e.preventDefault();
        
        $(".form_fields").removeClass("d-none");
        $(".modal-footer").removeClass("d-none");
        $(".reject_remarks").addClass("d-none");
    });

    $(document).on("click", ".confirm_reject", function(e){
        e.preventDefault();

        
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $(".reject_form small").text("");
        $.ajax({
            url: "/reject-site",
            method: "POST",
            data: $(".reject_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {

                    $('button[data-complete="false"]').trigger("click");

                    $(".cancel_reject").trigger("click");
                    $(".reject_form")[0].reset();

                    console.log(resp.message);

                    $(".confirm_reject").removeAttr("disabled");
                    $(".confirm_reject").text("Confirm");
                    // Swal.fire(
                    //     'Success',
                    //     resp.message,
                    //     'succes'
                    // )
                } else { 
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    $(".confirm_reject").removeAttr("disabled");
                    $(".confirm_reject").text("Confirm");
                }
            }, 
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $(".confirm_reject").removeAttr("disabled");
                $(".confirm_reject").text("Confirm");
            }, 
        })
    });
</script>




@endsection