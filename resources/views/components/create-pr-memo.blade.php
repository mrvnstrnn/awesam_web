<div class="modal fade" id="craetePrPoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                                    
                                    <input type="hidden" class="form-control" name="site_category" id="site_category" value="none">
                                    <input type="hidden" class="form-control" name="activity_id" id="activity_id" value="2">
                                    <div class="form-row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="to">To</label>
                                                <input type="text" class="form-control" name="to" id="to">
                                                <small class="text-danger to-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="subject">Subject</label>
                                                <input type="text" class="form-control" name="subject" id="subject">
                                                <small class="text-danger subject-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="thru">Thru</label>
                                                <input type="text" class="form-control" name="thru" id="thru">
                                                <small class="text-danger thru-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="date_created">Date Created</label>
                                                <input type="text" class="form-control" name="date_created" id="date_created" value="{{ \Carbon\Carbon::now() }}" readonly>
                                                <small class="text-danger date_created-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="from">From</label>
                                                <input type="text" class="form-control" name="from" id="from" value="{{ \Auth::user()->name }}" readonly>
                                                <small class="text-danger from-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="group">Group</label>
                                                <input type="text" class="form-control" name="group" id="group" value="Network Technical" readonly>
                                                <small class="text-danger group-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="division">Division</label>
                                                <input type="text" class="form-control" name="division" id="division" value="Network Technical Group" readonly>
                                                <small class="text-danger division-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <input type="text" class="form-control" name="department" id="department" value="Site Aquisition and Management" readonly>
                                                <small class="text-danger department-error"></small>
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
        
                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="recommendation">Recommendation</label>
                                                <textarea style="resize: vertical;" type="text" cols="50" rows="5" class="form-control" name="recommendation" id="recommendation"></textarea>
                                                <small class="text-danger recommendation-error"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="vendor">Vendor</label>
                                                <select name="vendor" id="vendor" class="form-control">
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger vendor-error"></small>
                                            </div>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="financial_analysis">Add Site</label>
                                                <select name="financial_analysis[]" id="financial_analysis" class="form-control" multiple="multiple">
                                                    {{-- <option value="">Select site</option> --}}
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
                                                    {{-- <th style='width: 20%'>Site ID</th> --}}
                                                    <th>Search Ring Name</th>
                                                    <th>Region</th>
                                                    <th>Province</th>
                                                    <th>Gross Amount</th>
                                                    <th>Action</th>
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
                                <button type="button" class="btn btn-sm btn-primary add_pr_po">Create PR Memo</button>
                                <button type="submit" class="print_to_pdf d-none"></button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#financial_analysis').select2({
            width: '100%'
        });
    // });

        $(".remove_td").on("click", function(e){
            console.log("test");

            var sam_id = $(this).attr("data-id");

            $("tr.tr" + sam_id).remove();

            var sum =  Number($("#requested_amount").val()) - Number($(this).attr("data-sites_fsa"));

            $("#requested_amount").val(sum);

            // $("select option.option" + sam_id).removeClass("d-none");
            
            $("select option.option" + sam_id).removeAttr("disabled");

            $(".input_hidden input#sam_id" + sam_id).remove();

        });

        $(".add_new_site").on("click", function(e){
            e.preventDefault();
            
            var sam_id = $("#financial_analysis").val();
            var vendor = $("#vendor").val();

            if (sam_id != "") {

                $(this).attr("disabled", "disabled");
                $(this).text("Processing...");

                $.ajax({
                    url: "/get-fiancial-analysis",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        sam_id : sam_id,
                        vendor : vendor,
                    },
                    success: function (resp) {
                        if (!resp.error) {
                            resp.message.forEach(element => {
                                
                                var sum_fsa = 0;
                                for (let i = 0; i < element.length; i++) {
                                    sum_fsa = Number(sum_fsa) + Number(element[i].price);
                                }

                                $(".table_financial_analysis table tbody").append("<tr class='tr"+element[0].sam_id+"'>" + 
                                    "<td><strong>"+element[0].search_ring+"</strong><br><small><strong>S/N:</strong> "+ element[0].serial_number +" | <strong>SAM ID: </strong>"+ element[0].sam_id +"</small></td>" +
                                    "<td>"+element[0].region+"</td>" +
                                    "<td>"+element[0].province+"</td>" +
                                    "<td>"+sum_fsa+"</td>" +
                                    "<td><button type='button' class='btn btn-success btn-shadow btn-sm line_item_td' data-id='"+element[0].sam_id+"' data-sam_id='"+element[0].sam_id+"'><i class='fa fa-fw' aria-hidden='true' ></i></button> <button type='button' class='btn btn-danger btn-sm btn-shadow remove_td' data-sites_fsa='"+sum_fsa+"' data-sam_id='"+element[0].sam_id+"' data-id='"+element[0].sam_id+"''><i class='fa fa-minus'></i></button></td>" +
                                    "</tr>");

                                $("select option.option"+element[0].sam_id).attr("disabled", "disabled");

                                $("#financial_analysis").val(null).trigger("change"); 
                        
                                $(".input_hidden").append(
                                    "<input class='hidden_sam_id' value='"+element[0].sam_id+"' type='hidden' name='sam_id[]' id='sam_id"+element[0].sam_id+"'>"
                                );
                            });

                            var sum =  Number($("#requested_amount").val()) + Number(resp.sites_fsa);

                            $("#requested_amount").val(sum);

                            // $("select option.option"+resp.message.sam_id).addClass("d-none");
                            
                            // $(".input_hidden").append(
                            //     "<input class='hidden_sam_id' value='"+resp.message.sam_id+"' type='hidden' name='sam_id[]' id='sam_id"+resp.message.sam_id+"'>"
                            // );

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

        $(document).unbind("click").on("click", ".add_pr_po", function (e) {
            e.preventDefault();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");
            
            $(".pr_po_form small").text("");

            var sam_id = [];
            var values = $("input[name='sam_id[]']")
                            .map(function(){
                                sam_id.push($(this).val())
                            }).get();
            $.ajax({
                url: "/add-pr-po",
                method: "POST",
                data: $(".pr_po_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {
                        for (let i = 0; i < sam_id.length; i++) {
                            $("select option.option"+sam_id[i]).addClass("d-none");
                            $(".input_hidden input#sam_id"+sam_id[i]).remove();
                        }

                        $("#assigned-sites-new-sites-table").DataTable().ajax.reload(function(){

                        
                            $(".pr_po_form #file_name").val(resp.file_name);
                            // $(".print_to_pdf").trigger("click");

                            var pdf_link = "/files/pdf/" + resp.file_name;

                            Swal.fire(
                                'Success',
                                resp.message + "<br><a href='"+pdf_link+"' download='"+resp.file_name+"'>Download PR Memo</a>",
                                'success'
                            )

                            // $(".table_site_count").load(location.href + " .table_site_count");

                            $("#craetePrPoModal").modal("hide");
                            
                            $(".add_pr_po").removeAttr("disabled");
                            $(".add_pr_po").text("Create PR Memo");
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
                        $(".add_pr_po").text("Create PR Memo");
                    }
                },
                error: function (resp){
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".add_pr_po").removeAttr("disabled");
                    $(".add_pr_po").text("Create PR Memo");
                }
            });
        });

        $(".table_financial_analysis").unbind("click").on("click", ".line_item_td", function (e){
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

        $(".line_items_area").unbind("click").on("click", ".save_line_items", function(e){
            e.preventDefault();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

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

                        $("button.remove_td[data-sam_id='"+sam_id+"']").trigger("click");

                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        
                        $('#financial_analysis').val(sam_id).trigger('change');

                        $(".add_new_site").trigger("click");

                        $(".cancel_line_items").trigger("click");

                        $(".save_line_items").removeAttr("disabled");
                        $(".save_line_items").text("Save line items");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )

                        $(".save_line_items").removeAttr("disabled");
                        $(".save_line_items").text("Save line items");
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".save_line_items").removeAttr("disabled");
                        $(".save_line_items").text("Save line items");
                }

            });
        });

        $("#craetePrPoModal").on("click", ".cancel_line_items", function(e){
            $("#craetePrPoModal .line_items_area").addClass("d-none");
            $("#craetePrPoModal .form_div").removeClass("d-none");
        });
        
        $(document).on("click", ".edit_form_pdf", function (e) {
            $(".line_items_area div").remove();

            $(".file_view").addClass("d-none");
            $(".form_div").removeClass("d-none");
        });
        
    });
    

</script>