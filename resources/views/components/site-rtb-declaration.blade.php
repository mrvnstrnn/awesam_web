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
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="position-relative form-group">
                        <input type="number" min="0" id="afi_lines" name="afi_lines" class="form-control" />
                        <small class="afi_lines-error text-danger"></small>
                    </div>        
                </div>
            </div>
            @endif
            <div class="form-row"> 
                <div class="col-md-4 col-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration" class="">RTB Declaration</label>
                    </div>
                </div>

                <div class="col-md-8 col-12">
                    <div class="position-relative form-group">
                        <select name="rtb_declaration" id="rtb_declaration" class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        <small class="rtb_declaration-error text-danger"></small>
                    </div>        
                </div>
            </div>
            {{-- <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="exampleSelect" rows="6" class="">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" style="height: 95px;"></textarea>
                    </div>        
                </div>
            </div> --}}
        </form>
    </div>
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12">
        <button class="float-right btn btn-shadow btn-success declare_rtb">Declare RTB</button>                                            
    </div>
</div>

<script>
    $(function() {

        $(".flatpicker").flatpickr();

        $("input[name=rtb_declaration_date]").flatpickr(
            { 
            minDate: new Date()
            }
        );
        // $("#datepicker").on("change",function(){
        //     var selected = $(this).val();
        //     $("#rtb_declaration_date").val(selected);
        // });


        $(".declare_rtb").on("click", function (e){
            e.preventDefault();

            var sam_id = "{{ $site[0]->sam_id }}";
            var rtb_declaration_date = $("#rtb_declaration_date").val();
            var rtb_declaration = $("#rtb_declaration").val();
            var program_id = "{{ $site[0]->program_id }}";
            var activity_name = "rtb_declation";
            var afi_lines = $("#afi_lines").val();

            var activity_id = ["{{ $site[0]->activity_id }}"];
            var site_category = ["{{ $site[0]->site_category }}"];
            // var remarks = $("#remarks").val();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $("#declare_rtb_form small").text("");

            $.ajax({
                url: "/declare-rtb",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    rtb_declaration_date : rtb_declaration_date,
                    rtb_declaration : rtb_declaration,
                    activity_name : activity_name,
                    program_id : program_id,
                    activity_id : activity_id,
                    site_category : site_category,
                    afi_lines : afi_lines,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                            $("#viewInfoModal").modal("hide");
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
