<div class="row">
    <div class="col-12">
        <button id="btn_add_issue_switch" class="mt-1 btn btn-danger float-right" type="button">Add Issue</button>
        <form class="add_issue_form mb-2 d-none">
            <input type="hidden" name="hidden_program_id" value="{{ $site[0]->program_id }}">
            <input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
            <div class="form-row mb-1">
                <div class="col-4">
                    <label for="issue_type" class="mr-sm-2">Issue Type</label>
                </div>
                <div class="col-8">
                    @php
                        $types = \App\Models\IssueType::select('*')->where('program_id', $site[0]->program_id)->get();
                        $type_array = array_keys($types->groupBy('issue_type')->toArray());
                    @endphp

                    <select name="issue_type" id="issue_type" class="form-control">
                        <option value="">Please select issue type</option>
                        @for ($i = 0; $i < count($type_array); $i++)
                            <option value="{{ $type_array[$i]  }}">{{ $type_array[$i] }}</option>
                        @endfor
                    </select>
                    <small class="text-danger issue_type-error"></small>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <label for="issue" class="mr-sm-2">Issue</label>
                </div>
                <div class="col-8">
                    <select name="issue" id="issue" class="form-control"></select>
                    <small class="text-danger issue-error"></small>
                </div>
            </div>

            <div class="form-row mb-1">
                <div class="col-4">
                    <label for="start_date" class="mr-sm-2">Issue Started</label>
                </div>
                <div class="col-8">
                    <input type="text" name="start_date" id="start_date" class="form-control flatpicker">
                    <small class="text-danger start_date-error"></small>
                </div>
            </div>

            <div class="form-row mb-1">
                <div class="col-4">
                    <label for="issue_details" class="mr-sm-2">Issue Details</label>
                </div>
                <div class="col-8">
                    <textarea name="issue_details" id="issue_details" cols="30" rows="10" class="form-control"></textarea>
                    <small class="text-danger issue_details-error"></small>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-12">
                    <button class="mt-1 btn btn-danger float-right add_issue" type="button">Add Issue</button>
                    <button id="btn_add_issue_cancel" class="mt-1 btn btn-outline-danger mr-1 float-right" type="button">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- <div class="divider"></div> --}}
<div class="row">
    <div class="col-12">
        <h5 class="card-title">Issue List</h5>
        <table class="mb-0 table table-bordered my_table_issue w-100" data-href="/get-my-issue/{{ $site[0]->sam_id }}">
            <thead>
                <tr>
                    <th>Start Date</th>
                    <th>Issue</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // issues

    $("#start_date").flatpickr(
    { 
        maxDate: new Date()
    });


    $('.my_table_issue').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('.my_table_issue').attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-id', data.issue_id);
        },
        columns: [
            { data: "start_date" },
            { data: "issue" },
            { data: "issue_details" },
            { data: "issue_status" },
        ],
    });

    $('#btn_add_issue_cancel').on( 'click', function (e) {
        $('.add_issue_form').addClass('d-none');
        $('#btn_add_issue_switch').removeClass('d-none');
    });

    $('#btn_add_issue_switch').on( 'click', function (e) {
        $('.add_issue_form').removeClass('d-none');
        $(this).addClass('d-none');
    });

    $("#issue_type").on("change", function (){
        if($(this).val() != ""){
            $("select[name=issue] option").remove();
            $.ajax({
                url: "/get-issue/"+$(this).val(),
                method: "GET",
                success: function (resp){
                    if(!resp.error){
                        resp.message.forEach(element => {
                            $("select[name=issue]").append(
                                '<option value="'+element.issue_type_id+'">'+element.issue+'</option>'
                            );
                        });
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });
        }
    });

    $(".add_issue").on("click", function (){
        $("small").text("");
        $.ajax({
            url: "/add-issue",
            method: "POST",
            data: $(".add_issue_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if(!resp.error){
                    $('.my_table_issue').DataTable().ajax.reload(function(){
                        $(".add_issue_form")[0].reset();
                        $('#btn_add_issue_cancel').trigger("click");
                        toastr.success(resp.message, "Success");
                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            },
            error: function (resp){
                toastr.error(resp.message, "Error");
            }
        });
    });

    $('.my_table_issue').on("click", "tr td", function(){
        if($(this).attr("colspan") != 4){
            $("#modal_issue").modal("show");

            $.ajax({
                url: "/get-issue/details/"+$(this).parent().attr('data-id'),
                method: "GET",
                success: function (resp){
                    if(!resp.error){
                        if(resp.message.issue_status == "cancelled"){
                            $(".cancel_issue").addClass("d-none");
                        } else {
                            $(".cancel_issue").removeClass("d-none");
                        }
                        $(".cancel_issue").attr("data-id", resp.message.issue_id);

                        $(".view_issue_form input[name=issue]").val(resp.message.issue);
                        $(".view_issue_form input[name=start_date]").val(resp.message.start_date);
                        $(".view_issue_form input[name=issue_type]").val(resp.message.issue_type);
                        $(".view_issue_form textarea[name=issue_details]").text(resp.message.issue_details);
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });
            
            $("#view_issue_form issue input[name=issue_id]").val();
        }
    });


    $(".cancel_issue").on("click", function(){
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");
        $.ajax({
            url: "/cancel-my-issue/"+$(this).attr('data-id'),
            method: "GET",
            success: function (resp){
                if(!resp.error){
                    $('.my_table_issue').DataTable().ajax.reload(function(){
                        toastr.success(resp.message, "Succes");
                        $("#modal_issue").modal("hide");
                        $(".cancel_issue").removeAttr("disabled");
                        $(".cancel_issue").text("Cancel Issue");
                    });
                } else {
                    toastr.error(resp.message, "Error");
                    $(".cancel_issue").removeAttr("disabled");
                    $(".cancel_issue").text("Cancel Issue");
                }
            },
            error: function (resp){
                toastr.error(resp.message, "Error");
                $(".cancel_issue").removeAttr("disabled");
                $(".cancel_issue").text("Cancel Issue");
            }
        });
    });
    //end issues

</script>