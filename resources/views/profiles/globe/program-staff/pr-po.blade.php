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

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="PR / PO" activitytype="site prmemo"/>

@endsection


@section('modals')

{{-- <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
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

                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <x-milestone-modal />

<div class="modal fade" id="craetePrPoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        Create PR Memo
                                    </h5>
                                </div>
                            </div>
                        </div> 

                        <form action="/print-to-pdf-pr-po" method="POST" class="pr_po_form" target="_blank">@csrf
                            <input type="hidden" name="file_name" id="file_name">
                            <div class="form_div">
                                <div class="card-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                                    
                                    <div class="form-group">
                                        <label for="vendor">Vendor</label>
                                        <select name="vendor" id="vendor" class="form-control">
                                            @php
                                                $vendors = \App\Models\Vendor::select("vendor.vendor_sec_reg_name", "vendor.vendor_id", "vendor.vendor_acronym")
                                                                    ->join("vendor_programs", "vendor_programs.vendors_id", "vendor.vendor_id")
                                                                    ->where("vendor_programs.programs", 1)
                                                                    ->get();
                                            @endphp
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger vendor-error"></small>
                                    </div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="to">To</label>
                                                <input type="text" class="form-control" name="to" id="to">
                                                <small class="text-danger to-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="thru">Thru</label>
                                                <input type="text" class="form-control" name="thru" id="thru">
                                                <small class="text-danger thru-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="date_created">Date Created</label>
                                                <input type="text" class="form-control" name="date_created" id="date_created" value="{{ \Carbon\Carbon::now() }}" readonly>
                                                <small class="text-danger date_created-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="from">From</label>
                                                <input type="text" class="form-control" name="from" id="from" value="{{ \Auth::user()->name }}" readonly>
                                                <small class="text-danger from-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="group">Group</label>
                                                <input type="text" class="form-control" name="group" id="group" value="Network Technical" readonly>
                                                <small class="text-danger group-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="division">Division</label>
                                                <input type="text" class="form-control" name="division" id="division" value="Network Technical Group" readonly>
                                                <small class="text-danger division-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <input type="text" class="form-control" name="department" id="department" value="Site Aquisition and Management" readonly>
                                                <small class="text-danger department-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class=" col-12">
                                            <div class="form-group">
                                                <label for="subject">Subject</label>
                                                <input type="text" class="form-control" name="subject" id="subject">
                                                <small class="text-danger subject-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="requested_amount">Requested Amount</label>
                                                <input type="number" class="form-control" name="requested_amount" id="requested_amount" value="0" readonly>
                                                <small class="text-danger requested_amount-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="budget_source">Budget Source</label>
                                                <input type="text" class="form-control" name="budget_source" id="budget_source">
                                                <small class="text-danger budget_source-error"></small>
                                            </div>
                                        </div>
                                    </div>
    
                                    <hr>
    
                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="recommendation">Recommendation</label>
                                                <textarea style="resize: vertical;" type="text" cols="50" rows="5" class="form-control" name="recommendation" id="recommendation"></textarea>
                                                <small class="text-danger recommendation-error"></small>
                                            </div>
                                        </div>
                                    </div>
    
                                    <hr>
    
                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="financial_analysis">Financial Analysis</label>
                                                @php
                                                    // $sites = \DB::connection('mysql2')->table('new_sites')->get();
                                                    $sites = \DB::connection('mysql2')
                                                                    ->table("milestone_tracking")
                                                                    ->leftjoin("new_sites", "new_sites.sam_id", "milestone_tracking.sam_id")
                                                                    ->where('milestone_tracking.program_id', 1)
                                                                    ->where('milestone_tracking.activity_type', 'PR / PO')
                                                                    ->where('milestone_tracking.profile_id', \Auth::user()->profile_id)
                                                                    ->where('milestone_tracking.activity_complete', 'false')
                                                                    ->get();
                                                                    // dd($sites);
                                                @endphp
                                                <select name="financial_analysis" id="financial_analysis" class="form-control">
                                                    <option value="">Select site</option>
                                                    @foreach ($sites as $site)
                                                    <option class="option{{ $site->sam_id }}" value="{{ $site->sam_id }}">{{ $site->search_ring }}</option>
                                                    @endforeach
                                                </select>
    
                                                <button type="button" class="my-3 btn btn-primary btn-shadow btn-sm pull-right add_new_site">Add</button>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="table_financial_analysis table-responsive">
                                        <table class="table table-hovered">
                                            <thead>
                                                <tr>
                                                    <th style='width: 20%'>Site ID</th>
                                                    <th style='width: 40%'>Search Ring Name</th>
                                                    <th>Region</th>
                                                    <th>Province</th>
                                                    <th style='width: 10%'>Gross Amount PHP (VAT EXCLUSIVE)</th>
                                                    <th style='width: 15%;'>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="input_hidden"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body line_items_area" class="d-none" style="overflow-y: auto !important; max-height: calc(100vh - 210px);"></div>
                            <div class="file_view d-none">
                                <div class="card-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                                    <div class="file_view_child"></div>
                                    <button class="btn btn-shadow btn-sm btn-primary edit_form_pdf" type="button">Edit</button>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-primary add_pr_po">Create PR/PO</button>
                                <button type="submit" class="print_to_pdf d-none"></button>
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
    var profile_id = 8;
    var table_to_load = 'site_approvals';
    // var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  

<script>
    // $(document).ready(function() {
    //     $(".table_financial_analysis table").DataTable().ajax.reload();
    // });
    
    $('.assigned-sites-table').on( 'click', 'tr td', function (e) {
        e.preventDefault();
        $(document).find('#viewInfoModal').modal('show');

        var json_parse = JSON.parse($(this).parent().attr('data-site_all'));

        $(".btn-accept-endorsement").attr('data-program', $(this).parent().attr('data-program'));

        allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"];

        // $("..content-data .position-relative.form-group").remove();
        $(".card-body .position-relative.form-group").remove();
        $("#viewInfoModal .main-card.mb-3.card .modal-footer").remove();

        if (json_parse.site_fields != null) {
            var new_json = JSON.parse(json_parse.site_fields.replace(/&quot;/g,'"'));

            for (let i = 0; i < new_json.length; i++) {
                // if(allowed_keys.includes(new_json[i].field_name.toUpperCase())){
                    $("#viewInfoModal .card-body").append(
                        '<div class="position-relative form-group col-md-6">' +
                            '<label for="' + new_json[i].field_name.toLowerCase() + '" style="font-size: 11px;">' +  new_json[i].field_name + '</label>' +
                            '<input class="form-control"  value="'+new_json[i].value+'" name="' + new_json[i].field_name.toLowerCase() + '"  id="'+new_json[i].field_name.toLowerCase()+'" >' +
                        '</div>'
                    );
                // }
            }
        } else {
            $("#viewInfoModal .card-body").append(
                '<div><h1>No fields available.</h1></div>'
            );
        }
        $(".modal-title").text(json_parse.site_name);
        $(".btn-accept-endorsement").attr('data-sam_id', json_parse.sam_id);
        $(".btn-accept-endorsement").attr('data-site_vendor_id', json_parse.vendor_id);
        $(".btn-accept-endorsement").attr('data-what_table', $(this).closest('tr').attr('data-what_table'));
        $(".btn-accept-endorsement").attr('data-program_id', $(this).closest('tr').attr('data-program_id'));
    } );

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
                            "<td>"+resp.message.serial_number+"</td>" +
                            "<td>"+resp.message.search_ring+"</td>" +
                            "<td>"+resp.message.region+"</td>" +
                            "<td>"+resp.message.province+"</td>" +
                            "<td>"+resp.sites_fsa+"</td>" +
                            "<td><button type='button' class='btn btn-primary btn-shadow btn-sm line_item_td' data-id='"+resp.message.sam_id+"' data-sam_id='"+sam_id+"'>Line Items</button> <button type='button' class='btn btn-danger btn-sm btn-shadow remove_td' data-sites_fsa='"+resp.sites_fsa+"' data-sam_id='"+sam_id+"' data-id='"+resp.message.sam_id+"''><i class='fa fa-minus'></i></button></td>" +
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

                    });
                    
                    $(".pr_po_form #file_name").val(resp.file_name);
                    $(".print_to_pdf").trigger("click");

                    $("#craetePrPoModal").modal("hide");

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

                    
                    $(".add_pr_po").removeAttr("disabled");
                    $(".add_pr_po").text("Create PR/PO");
                    $(".remove_td").trigger("click");
                    $(".pr_po_form")[0].reset();
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