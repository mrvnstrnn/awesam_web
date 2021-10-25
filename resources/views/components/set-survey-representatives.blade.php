<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">{{ $sub_activity }}</H5>
    </div>
</div>

<div class="row form_add_representative_div">
    <div class="col-12">
        <form class="form_add_representative">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"class="form-control" name="name" id="name" placeholder="John Doe">
                <small class="name-errors text-danger"></small>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text"class="form-control" name="email" id="email" placeholder="john-doe@gmail.com">
                <small class="email-errors text-danger"></small>
            </div>

            <div class="form-group">
                <label for="designation">Designation</label>
                <select class="form-control" name="designation" id="designation">
                    <option value="">Please select designation</option>
                    <option value="SAQ (Site Acquisition)">SAQ (Site Acquisition)</option>
                    <option value="RRE (Regional RAN Engineering)">RRE (Regional RAN Engineering)</option>
                    <option value="FE (Facility Engineering)">FE (Facility Engineering)</option>
                    <option value="FO (Field Operations)">FO (Field Operations)</option>
                </select>
                <small class="designation-errors text-danger"></small>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary btn-sm btn-shadow pull-right add_representative_details">Add Representative</button>
            </div>
        </form>
    </div>
</div>

<div class="row confirmation_details d-none">
    <div class="col-12">
        <div class="form-group">
            <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;"><div class="swal2-icon-content">!</div></div>
            <p class="text-center">Are you sure this is the correct details? This information will be used to send an email to the representative/s.</p>

            <p><b>Name: </b><span class="span_name"></span></p>
            <p><b>Email: </b><span class="span_email"></span></p>
            <p><b>Designation: </b><span class="span_designation"></span></p>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm btn-shadow pull-right add_representative">Add Representative</button>
            <button type="button" class="btn btn-secondary btn-sm btn-shadow pull-right mr-1 cancel_representative">Cancel</button>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-hover" id="representative_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="row mt-3 mb-3 complete_btn_area {{ $is_done == 'done' ? '' : 'd-none' }}">
    <div class="col-12">
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-lg btn-shadow pull-right done_adding_representative">Done Adding Representative</button>
        </div>
    </div>
</div>

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
        $("#actions_box").html('');
    });

    $(".add_representative_details").on("click", function (e){
        e.preventDefault();

        var email = $("#email").val();
        var designation = $("#designation").val();
        var name = $("#name").val();

        if (email.trim() != "" && designation.trim() != "" && name.trim() != "") {

            $(".span_email").text(email);
            $(".span_designation").text(designation);
            $(".span_name").text(name);

            $(".confirmation_details").removeClass("d-none");
            $(".form_add_representative_div").addClass("d-none");
        }
    });

    $(".done_adding_representative").on("click", function (e){
        e.preventDefault();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var site_name = "{{ $site_name }}";
        var sam_id = "{{ $sam_id }}";

        $.ajax({
            url: "/done-adding-representative",
            method: "POST",
            data: {
                sam_id : sam_id,
                site_name : site_name,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    $(".done_adding_representative").removeAttr("disabled");
                    $(".done_adding_representative").text("Done Adding Representative");
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $(".done_adding_representative").removeAttr("disabled");
                    $(".done_adding_representative").text("Done Adding Representative");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $(".done_adding_representative").removeAttr("disabled");
                $(".done_adding_representative").text("Done Adding Representative");
            }
        });
    });

    $(".cancel_representative").on("click", function (e){
        $(".confirmation_details").addClass("d-none");
        $(".form_add_representative_div").removeClass("d-none");
    });

    $(".add_representative").on("click", function (e){
        e.preventDefault();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $(".form_add_representative small").text("");

        var sam_id = "{{ $sam_id }}";
        var sub_activity_id = "{{ $sub_activity_id }}";
        var email = $("#email").val();
        var designation = $("#designation").val();
        var name = $("#name").val();

        $.ajax({
            url: "/add-representative",
            method: "POST",
            data: {
                sam_id : sam_id,
                sub_activity_id : sub_activity_id,
                email : email,
                designation : designation,
                name : name,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (!resp.error) {
                    $('#representative_table').DataTable().ajax.reload(function () {

                        $(".form_add_representative")[0].reset();
                        
                        $(".add_representative").removeAttr("disabled");
                        $(".add_representative").text("Add Representative");

                        $(".confirmation_details").addClass("d-none");
                        $(".form_add_representative_div").removeClass("d-none");

                        $(".complete_btn_area").removeClass("d-none");
                    });

                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".form_add_representative ." + index + "-errors").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".add_representative").removeAttr("disabled");
                    $(".add_representative").text("Add Representative");
                }
            },
            error: function(resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $(".add_representative").removeAttr("disabled");
                $(".add_representative").text("Add Representative");
            }
         });
    });

    $('#representative_table').DataTable({
        processing: true,
        serverSide: true,
        select: true,
        order: [ 1, "asc" ],
        ajax: {
            url: "/jtss-representative/" + "{{ $sam_id }}",
            type: 'GET'
        },
        dataSrc: function(json){
            return json.data;
        },
        columns: [
            { data: "name" },
            { data: "email" },
            { data: "designation" },
        ]
    });
</script>