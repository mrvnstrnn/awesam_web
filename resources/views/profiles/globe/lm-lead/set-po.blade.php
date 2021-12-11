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

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Set PO Details" activitytype="set po"/>

@endsection


@section('modals')
    <div class="modal fade" id="create_pr_renewal_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-dark">
                        <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title">
                                Set PO
                            </h5>
                        </div>
                    </div>
                </div> 

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form_html"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                            Site
                                        </h5>
                                    </div>
                                </div>
                            </div> 
    
                            <div class="card-body form-row" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                                <div class="row form_fields"></div>
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
    var table_to_load = 'new_endorsements_globe';
    var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  

<script>
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

    $('.assigned-sites-table').on( 'click', 'tr td:not(:first-child)', function (e) {
        e.preventDefault();
        
        $(document).find('#viewInfoModal').modal('show');

        var sam_id = $(this).parent().attr('data-sam_id');
        var program_id = $(this).parent().attr('data-sam_id');
        var site_category = $(this).parent().attr('data-site_category');
        var activity_id = $(this).parent().attr('data-activity_id');        
        var site_name = $(this).parent().attr('data-site_name');

        allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"];

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

                    var array_not_allowed = [
                        "id",
                        "sam_id",
                        "load_date",
                        "mar_status",
                        "las_completed_date",
                        "las_completed_month",
                        "contract_completed_date",
                        "contract_completed_month",
                        "challenges",
                        "rate_demand",
                        "escalation_demand",
                        "tco_demand",
                        "escalation_new",
                        "tco_new",
                        "tco_increase",
                        "entire_savings",
                        "realized_savings",
                        "entire_cost_avoidance",
                        "realized_cost_avoidance",
                        "vendor_name",
                        "vendor",
                        "site_class",
                        "contract_type",
                        "contract_duration_new"
                    ];

                    var data_not_allowed = [
                        'NULL',
                        'null',
                        null,
                    ];

                    $.each(resp.message[0], function(index, data) {
                        field_name = index.charAt(0).toUpperCase() + index.slice(1);
                        
                        if ( !array_not_allowed.includes(index) ) {
                            if (!data_not_allowed.includes(data)) {
                                $("#viewInfoModal .card-body .form_fields").append(
                                    '<div class="position-relative form-group col-md-4" style="text-transform: uppercase;">' +
                                        '<label for="' + index.toUpperCase() + '" style="font-size: 11px;">' + field_name.split('_').join(' ') + '</label>' +
                                    '</div>'+
                                    '<div class="position-relative form-group col-md-8">' +
                                        '<input class="form-control"  value="'+data+'" name="' + index.toLowerCase() + '"  id="'+index.toLowerCase()+'" readonly>' +
                                    '</div>'
                                );
                            }
                        }

                    });

                    $("#viewInfoModal .menu-header-title").text(site_name);

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

    $(document).on("click", ".create_pr_po", function (){
        var data_program = $(this).attr('data-program');
        var data_program_id = $(this).attr('data-program_id');

        var inputElements = document.getElementsByName('program'+data_program_id);

        sam_id = [];
        site_category = [];
        activity_id = [];
        for(var i=0; inputElements[i]; ++i){
            if(inputElements[i].checked){
                sam_id.push(inputElements[i].value);
                site_category.push(inputElements[i].attributes[5].value);
                activity_id.push(inputElements[i].attributes[6].value);
            }
        }

        if ( sam_id.length > 0 ) {
            $.ajax({
                url: "/get-form/" + activity_id[0] + "/" + "Create PR",
                method: "GET",
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function (resp) {
                    if (!resp.error) {
                        $("#create_pr_renewal_modal").modal("show");
                        $(".form_html").html(resp.message);
                        
                        for (let i = 0; i < sam_id.length; i++) {
                            $(".form_html form").append(
                                "<input type='hidden' name='sam_id[]' value='"+ sam_id[i] +"'>"
                            );
                        }

                        $(".form_html form").append(
                            "<input type='hidden' name='program_id' value='"+ data_program +"'>"
                        );

                        var vendors = JSON.parse("{{ \Auth::user()->vendor_list_based_program(8) }}".replace(/&quot;/g,'"'));

                        $("#vendor option").remove();

                        vendors.forEach(vendor => {
                            $("#vendor").append(
                                "<option value='"+ vendor.vendor_id +"'>"+ vendor.vendor_sec_reg_name +" ( " + vendor.vendor_acronym + " )</option>"
                            );
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
        }
    });

    $(document).on("click", ".save_create_pr_btn", function (){
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: "/create-pr-renewal",
            method: "POST",
            data: $(".create_pr_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    $("#assigned-sites-"+resp.program_id+"-table").DataTable().ajax.reload(function(){
                        $("#create_pr_renewal_modal").modal("hide");

                        $(".save_create_pr_btn").removeAttr("disabled");
                        $(".save_create_pr_btn").text("Create PR");
                    });

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".create_pr_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_create_pr_btn").removeAttr("disabled");
                    $(".save_create_pr_btn").text("Create PR");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_create_pr_btn").removeAttr("disabled");
                $(".save_create_pr_btn").text("Create PR");
            }
        });

    });

</script>




@endsection