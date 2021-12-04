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

    $(".form_html").on("click", ".save_create_pr_btn", function (){
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