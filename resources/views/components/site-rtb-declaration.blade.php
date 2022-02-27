<div class="row">
    <div class="col-12">
        <form id="declare_rtb_form">
            <div class="form-row"> 
                <div class="col-md-4 col-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration_date">Date Declaration</label>
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="position-relative form-group">
                        <input type="text" id="rtb_declaration_date" name="rtb_declaration_date" class="flatpicker form-control" style="background-color: white;" />
                        <small class="rtb_declaration_date-error text-danger"></small>
                    </div>        
                </div>
            </div>
            @if ($site[0]->program_id == 2)
            <div class="form-row"> 
                <div class="col-md-4 col-12">
                    <div class="position-relative form-group">
                        <label for="afi_lines">AFI Lines</label>
                        <br>
                        <b>Current AFI Lines:</b> {{ $site[0]->afi_lines }}
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="position-relative form-group">
                        <input type="number" min="0" id="afi_lines" name="afi_lines" class="form-control" />
                        <small class="afi_lines-error text-danger"></small>
                    </div>        
                </div>
            </div>

            <div class="form-row"> 
                <div class="col-md-4 col-12">
                    <div class="position-relative form-group">
                        <label for="afi_type">Type</label>
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="position-relative form-group">
                        <select name="afi_type" id="afi_type" class="form-control">
                            <option value=""></option>
                            <option value="Partial">Partial</option>
                            <option value="Full">Full</option>
                        </select>
                        <small class="afi_type-error text-danger"></small>
                    </div>        
                </div>
            </div>

            <div class="form-row"> 
                <div class="col-md-4 col-12">
                    <div class="position-relative form-group">
                        <label for="solution">Solution</label>
                        <br>
                        <b>Current Solution:</b> {{ $site[0]->solution }}
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="position-relative form-group">
                        <select name="solution" id="solution" class="form-control">
                            <option value=""></option>
                            <option value="Sunny">Sunny</option>
                            <option value="Cloudy">Cloudy</option>
                        </select>
                        <small class="solution-error text-danger"></small>
                    </div>        
                </div>
            </div>
            @endif
        </form>
    </div>
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12">
        <button class="float-right btn btn-shadow btn-primary declare_rtb">Declare RTB</button>
    </div>
</div>

@if ($site[0]->program_id == 2)
<hr>
<h5>Partial Declaration List</h5>
<div class="row">
    <div class="col-12">
        <table class="table table-hover rtb_declaration_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>AFI Lines</th>
                    <th>Type</th>
                    <th>Solution</th>
                    <th>Declaration Date</th>
                    <th>Date Created</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12">
        <button class="float-right btn btn-shadow btn-primary declare_rtb" data-value="now">Submit now RTB</button>
    </div>
</div>
@endif

<script>
    $(document).ready(function () {
        var sam_id = "{{ $site[0]->sam_id }}";
        var status = "pending";

        $('.rtb_declaration_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/get-partial-rtb-declaration",
                type: 'POST',
                data: {
                    sam_id : sam_id,
                    status : status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            columns: [
                { data: "id" },
                { data: "afi_lines" },
                { data: "afi_type" },
                { data: "solution" },
                { data: "rtb_declaration_date" },
                { data: "date_created" },
            ],
        });
    });

    $(function() {

        $(".flatpicker").flatpickr();

        $("input[name=rtb_declaration_date]").flatpickr(
            { 
            minDate: new Date()
            }
        );

        $(".declare_rtb").on("click", function (e){
            e.preventDefault();

            var sam_id = "{{ $site[0]->sam_id }}";
            var rtb_declaration_date = $("#rtb_declaration_date").val();
            // var rtb_declaration = $("#rtb_declaration").val();
            var program_id = "{{ $site[0]->program_id }}";
            var activity_name = "rtb_declation";
            var afi_lines = $("#afi_lines").val();
            var solution = $("#solution").val();

            var activity_id = ["{{ $site[0]->activity_id }}"];
            var site_category = ["{{ $site[0]->site_category }}"];
            
            var data_value = $(this).attr("data-value");

            if ( data_value == "now") {
                var afi_type = "Full";
            } else {
                var afi_type = $("#afi_type").val();
            }

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $("#declare_rtb_form small").text("");

            $.ajax({
                url: "/declare-rtb",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    rtb_declaration_date : rtb_declaration_date,
                    // rtb_declaration : rtb_declaration,
                    activity_name : activity_name,
                    program_id : program_id,
                    activity_id : activity_id,
                    site_category : site_category,
                    afi_lines : afi_lines,
                    afi_type : afi_type,
                    solution : solution,
                    data_value : data_value,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){

                            if ( afi_type == "Partial" ) {
                                
                                $('.rtb_declaration_table').DataTable().ajax.reload(function () {
                                    $("#rtb_declaration_date").val("");

                                    $(".declare_rtb").removeAttr("disabled");
                                    $(".declare_rtb").text("Declare RTB");

                                    Swal.fire(
                                        'Success',
                                        resp.message,
                                        'success'
                                    )
                                });
                            } else {
                                $("#viewInfoModal").modal("hide");
                                $("#rtb_declaration_date").val("");

                                $(".declare_rtb").removeAttr("disabled");
                                $(".declare_rtb").text("Declare RTB");

                                Swal.fire(
                                    'Success',
                                    resp.message,
                                    'success'
                                )
                            }
                        });
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
                        $(".declare_rtb").removeAttr("disabled");
                        $(".declare_rtb").text("Declare RTB");
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $(".declare_rtb").removeAttr("disabled");
                    $(".declare_rtb").text("Declare RTB");
                }
            });
        });
    });


</script>
