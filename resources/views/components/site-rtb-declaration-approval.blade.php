
<div class="row">

    @php
        $json = json_decode($rtbdeclaration->value, true);
    @endphp
    <div class="col-lg-5 text-center m-auto">
        {{-- <div id="datepicker" class=""></div> --}}
        <h3 style="font-size: 56px; font-weight: 700;">{{ date('M', strtotime($json['rtb_declaration_date'] )) }}</h3>
        <h1 style="font-size: 70px; font-weight: 900;">{{ date('d', strtotime($json['rtb_declaration_date'] )) }}</h1>
    </div>
    <div class="col-lg-7">
        <form>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration_date">Date Declaration</label>
                        <input type="text" id="rtb_declaration_date" name="rtb_declaration_date" value="{{ date("m/d/Y", strtotime($json['rtb_declaration_date'] )) }}" class="form-control" readonly />
                    </div>        
                </div>
            </div>
            @if ( isset($json['afi_lines']) && $site[0]->program_id == 2 )
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="afi_lines">AFI Lines</label>
                        <input type="text" id="afi_lines" name="afi_lines" value="{{ $json['afi_lines'] }}" class="form-control" readonly />
                    </div>        
                </div>
            </div>

            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="solution">Solution</label>
                        <br>
                        <b>Current Solution:</b> {{ $site[0]->solution }}
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
            {{-- <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration">RTB Declaration</label>
                        <input type="text" name="rtb_declaration" id="rtb_declaration" value="{{ $json['rtb_declaration'] }}" class="form-control" readonly>
                    </div>        
                </div>
            </div> --}}
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="remarks" rows="6" class="">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" style="height: 95px;"></textarea>
                        <small class="remarks-error text-danger"></small>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12 align-right">
        <button class="float-right btn btn-shadow btn-success declaration_approve_reject" id="declaration_approve" data-action="true" data-sam_id="{{ $rtbdeclaration->sam_id }}">Approve RTB Declaration</button>                                            
        <button class="float-right btn btn-shadow btn-danger mr-2 declaration_approve_reject" id="declaration_reject" data-action="false" data-sam_id="{{ $rtbdeclaration->sam_id }}">Reject</button>                                            
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

    $(document).ready(function(){

        var sam_id = "{{ $site[0]->sam_id }}";
        var status = "approved";

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

    
        $(".declaration_approve_reject").on("click", function(e) {
            e.preventDefault();
            var sam_id = "{{ $site[0]->sam_id }}";
            var action = $(this).attr("data-action");
            var program_id = "{{ $site[0]->program_id }}"
            var remarks = $("#remarks").val();
            var activity_name = "rtb_declation_approval";

            var activity_id = ["{{ $site[0]->activity_id }}"];
            var site_category = ["{{ $site[0]->site_category }}"];

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var message = action == "false" ? "Reject" : "Approve RTB Declaration";
            var button_id = action == "false" ? "declaration_reject" : "declaration_approve";
            
            var solution = $("#solution").val();
            var afi_lines = $("#afi_lines").val();

            $("form small").text("");

            $.ajax({
                url: "/approve-reject-rtb",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    action : action,
                    remarks : remarks,
                    activity_name : activity_name,
                    program_id : program_id,
                    activity_id : activity_id,
                    site_category : site_category,
                    solution : solution,
                    afi_lines : afi_lines,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                            $("#viewInfoModal").modal("hide");

                            $("#"+button_id).removeAttr("disabled");
                            $("#"+button_id).text(message);

                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )
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

                        $("#"+button_id).removeAttr("disabled");
                        $("#"+button_id).text(message);
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $("#"+button_id).removeAttr("disabled");
                    $("#"+button_id).text(message);
                }
            });
        });
    })
</script>
