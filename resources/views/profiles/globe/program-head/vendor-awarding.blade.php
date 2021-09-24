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

<x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Vendor Awarding" activitytype="vendor awarding"/>

@endsection


@section('modals')

<div class="ajax_content_box"></div>

@endsection

@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'vendor_awarding';
    // var table_to_load = 'pr_memo';
    // var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  
<!-- PR PO Counter -->
<script type="text/javascript" src="/js/newsites_ajax_counter.js"></script>  

<script>
    // $(document).ready(function() {
    //     $(".table_financial_analysis table").DataTable().ajax.reload();
    // });

    $(document).on("click", ".btn_create_pr", function(e){
        e.preventDefault();
        
        $("#craetePrPoModal").modal("show");
    });

    $(document).on("click", ".add_new_site", function(e){
        e.preventDefault();
        
        var sam_id = $("#financial_analysis").val();
        var vendor = $("#vendor").val();

        if (sam_id != "") {

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/get-fiancial-analysis/" + sam_id + "/" + vendor,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        $(".table_financial_analysis table tbody").append("<tr class='tr"+resp.message.sam_id+"'>" + 
                            "<td><strong>"+resp.message.search_ring+"</strong><br><small><strong>S/N:</strong> "+ resp.message.serial_number +" | <strong>SAM ID: </strong>"+ resp.message.sam_id +"</small></td>" +
                            "<td>"+resp.message.region+"</td>" +
                            "<td>"+resp.message.province+"</td>" +
                            "<td>"+resp.sites_fsa+"</td>" +
                            "<td><button type='button' class='btn btn-success btn-shadow btn-sm line_item_td' data-id='"+resp.message.sam_id+"' data-sam_id='"+sam_id+"'><i class='fa fa-fw' aria-hidden='true' ></i></button> <button type='button' class='btn btn-danger btn-sm btn-shadow remove_td' data-sites_fsa='"+resp.sites_fsa+"' data-sam_id='"+sam_id+"' data-id='"+resp.message.sam_id+"''><i class='fa fa-minus'></i></button></td>" +
                            "</tr>");

                        var sum =  Number($("#requested_amount").val()) + Number(resp.sites_fsa);

                        $("#requested_amount").val(sum);

                        $("select option.option"+resp.message.sam_id).addClass("d-none");
                        
                        $(".input_hidden").append(
                            "<input class='hidden_sam_id' value='"+resp.message.sam_id+"' type='hidden' name='sam_id[]' id='sam_id"+resp.message.sam_id+"'>"
                        );

                        $("#financial_analysis").val("");

                        $(".add_new_site").removeAttr("disabled");
                        $(".add_new_site").text("Add");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )

                        $(".add_new_site").removeAttr("disabled");
                        $(".add_new_site").text("Add");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".add_new_site").removeAttr("disabled");
                    $(".add_new_site").text("Add");
                }
            });
        }
    });

    $(document).on("click", ".remove_td", function(e){

        $("tr.tr"+$(this).attr("data-id")).remove();

        var sum =  Number($("#requested_amount").val()) - Number($(this).attr("data-sites_fsa"));

        $("#requested_amount").val(sum);

        $("select option.option"+$(this).attr("data-id")).removeClass("d-none");
        $(".input_hidden input#sam_id"+$(this).attr("data-id")).remove();
    });

    $(document).on("click", ".add_pr_po", function (e) {
        e.preventDefault();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");
        
        $(".pr_po_form small").text("");

        $.ajax({
            url: "/add-pr-po",
            method: "POST",
            data: $(".pr_po_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if (!resp.error) {
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                    $("#assigned-sites-new-sites-table").DataTable().ajax.reload(function(){

                    
                        $(".pr_po_form #file_name").val(resp.file_name);
                        $(".print_to_pdf").trigger("click");

                        $("#craetePrPoModal").modal("hide");
                        
                        $(".add_pr_po").removeAttr("disabled");
                        $(".add_pr_po").text("Create PR/PO");
                        $(".remove_td").trigger("click");
                        $(".pr_po_form")[0].reset();
                    });

                    // $(".file_view").removeClass("d-none");
                    // $(".form_div").addClass("d-none");

                    // var extensions = ["pdf", "jpg", "png"];
                    
                    // if( extensions.includes(resp.file_name.split('.').pop()) == true) {     
                    //     htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/pdf/' + resp.file_name + '" allowfullscreen></iframe>';
                    // } else {
                    //     htmltoload = '<div class="text-center my-5"><a href="/files/pdf/' + resp.file_name + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
                    // }
                    
                    // $('.file_view_child').html('');
                    // $('.file_view_child').html(htmltoload);

                    // $(".input_hidden input").remove();

                    
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".pr_po_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".add_pr_po").removeAttr("disabled");
                    $(".add_pr_po").text("Create PR/PO");
                }
            },
            error: function (resp){
                
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".add_pr_po").removeAttr("disabled");
                $(".add_pr_po").text("Create PR/PO");
            }
        });
    });

    $(document).on("click", ".line_item_td", function (e){
        e.preventDefault();

        var sam_id = $(this).attr('data-sam_id');
        
        var vendor = $("#vendor").val();

        $("#craetePrPoModal .menu-header-title").text(sam_id);

        $("#craetePrPoModal .line_items_area").removeClass("d-none");
        $("#craetePrPoModal .form_div").addClass("d-none");

        $(".line_items_area div").remove();

        $.ajax({
            url: "/get-line-items/" + sam_id + "/" +vendor,
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    // console.log(resp.message);
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".line_items_area").append(
                                '<div><label><b>'+index+'</b></label></div>'
                            );

                            $.each(data, function(i, checkbox_data) {
                                $(".line_items_area").append(
                                    '<div class="form-group">' +
                                    '<input type="checkbox" value="'+checkbox_data.fsa_id+'" name="line_item" id="line_item'+checkbox_data.fsa_id+'"> <label for="line_item'+checkbox_data.fsa_id+'">' + checkbox_data.item +
                                    '</label></div>'
                                );
                            });
                        });


                        resp.site_items.forEach(element => {
                            $("input[value='" + element.fsa_id + "']").prop('checked', true);
                        });

                        $(".line_items_area").append(
                            '<div><button type="button" class="btn btn-shadow btn-sm btn-secondary cancel_line_items">Cancel</button> <button type="button" class="btn btn-shadow btn-sm btn-primary save_line_items" data-sam_id="'+sam_id+'"">Save line items</button></div>'
                        );
                    }
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
    });

    $(document).on("click", ".save_line_items", function(e){
        e.preventDefault();

        var sam_id = $(this).attr('data-sam_id');
        var inputElements = document.getElementsByName('line_item');

        line_item_id = [];
        for(var i=0; inputElements[i]; ++i){
            if(inputElements[i].checked){
                line_item_id.push(inputElements[i].value);
            }
        }

        $.ajax({
            url: "/save-line-items",
            data: {
                line_item_id : line_item_id,
                sam_id : sam_id,
            },
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if (!resp.error) {

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    
                    $("button.remove_td[data-sam_id='"+sam_id+"']").trigger("click");

                    
                    $('#financial_analysis').val(sam_id).trigger('change');

                    $(".add_new_site").trigger("click");

                    $(".cancel_line_items").trigger("click");
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
    });

    $(document).on("click", ".cancel_line_items", function(e){
        $("#craetePrPoModal .line_items_area").addClass("d-none");
        $("#craetePrPoModal .form_div").removeClass("d-none");
    });
    
    $(document).on("click", ".edit_form_pdf", function (e) {
        $(".line_items_area div").remove();

        $(".file_view").addClass("d-none");
        $(".form_div").removeClass("d-none");
    });
    

</script>




@endsection