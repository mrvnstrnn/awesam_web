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

<div id="smartwizard" class="sw-main sw-theme-default">
    <ul class="forms-wizard nav nav-tabs step-anchor">
        @php
            $array_index = collect();
        @endphp
        @foreach ($substeps as $index => $substep)
            @php
                $substep_complete = \Auth::user()->substep_complete($substep->sub_activity_step_id, $sam_id, $substep->sub_activity_id);
                
                if (count($substep_complete) == 1) {
                    $class_step = "done";
                    $class_display = "d-none";
                } else {
                    $array_index->push($index);
                    
                    if ($array_index[0] == $index) {
                        $class_step = "active";
                        $class_display = "d-block";
                    } else {
                        $class_step = "";
                        $class_display = "d-none";
                    }
                }
            @endphp
            <li class="nav-item {{ $class_step }} step-{{ $index + 1}}">
                <a href="#step-{{ $index + 1}}" class="nav-link">
                    <em>{{ $index + 1 }}</em><span>{{ $substep->sub_activity_step }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="form-wizard-content sw-container tab-content" style="min-height: 347.891px;">
        @foreach ($substeps as $index => $substep)
            @php
                // $substep_complete = \Auth::user()->substep_complete($substep->sub_activity_step_id, $sam_id, $substep->sub_activity_id);
                if (count($substep_complete) == 1) {
                    $class_step = "done";
                    $class_display = "d-none";
                } else {
                    $array_index->push($index);
                    
                    if ($array_index[0] == $index) {
                        $class_step = "active";
                        $class_display = "d-block";
                    } else {
                        $class_step = "";
                        $class_display = "d-none";
                    }
                }
            @endphp
            <div id="step-{{ $index + 1 }}" class="tab-pane step-content {{ $class_display }}">
                <form class="substep_form{{ $index + 1 }}">
                    <input type="hidden" class="form-control" name="sub_activity_step_id" id="sub_activity_step_id" value="{{ $substep->sub_activity_step_id }}">
                    <input type="hidden" class="form-control" name="sub_activity_id" id="sub_activity_id" value="{{ $substep->sub_activity_id }}">
                    <input type="hidden" class="form-control" name="sam_id" id="sam_id" value="{{ $sam_id }}">
                    <input type="hidden" class="form-control" name="sub_activity_step" id="sub_activity_step" value="{{ $substep->sub_activity_step }}">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" id="date">
                        <small class="text-danger date-error"></small>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" id="remarks" cols="30" rows="5" class="form-control"></textarea>
                        <small class="text-danger remarks-error"></small>
                    </div>

                    <button class="btn btn-sm btn-primary save_remarks" type="button" data-index="{{ $index + 1 }}" data-next_index="{{ $index + 2 }}" data-count="{{ count($substeps) }}" data-sub_activity_id="{{ $substep->sub_activity_id }}">Save</button>
                </form>
            </div>
        @endforeach
    </div>
</div>

<script>
    // $("#date").flatpickr({ 
    //     maxDate: new Date()
    // });

    date_time = "{{ date('Y-m-d', strtotime(\Carbon\Carbon::now())) }}";

    $("#date").attr("max", date_time);

    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    $(".save_remarks").on("click", function (){
        var index = $(this).attr("data-index");
        var next_index = $(this).attr("data-next_index");
        var count_step = $(this).attr("data-count");
        var sub_activity_id = $(this).attr("data-sub_activity_id");

        $(".substep_form"+index+ " small").text("");

        $(this).attr('disabled', 'disabled');
        $(this).text('Processing...');

        $.ajax({
            url: "/submit-subactivity-step",
            method: "POST",
            data: $(".substep_form"+index).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    Swal.fire(
                        'Sucess',
                        resp.message,
                        'success'
                    )
                    
                    if (count_step == index) {
                        $(".btn_switch_back_to_actions").trigger("click");

                        $(".action_to_complete_child"+sub_activity_id).attr("data-substep_same", "same");
                    }

                    $(".save_remarks").removeAttr('disabled');
                    $(".save_remarks").text('Save');

                    $(".substep_form"+index)[0].reset();

                    if ($(".step-"+index).hasClass("active")) {
                        $(".step-"+index).removeClass("active");
                        $(".step-"+index).addClass("done");
                        
                        $(".step-"+next_index).addClass("active");

                        $("#step-"+index).addClass("d-none");
                        $("#step-"+index).removeClass("d-block");

                        $("#step-"+next_index).removeClass("d-none");
                        $("#step-"+next_index).addClass("d-block");
                    }

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

                    // $(".btn_switch_back_to_actions").trigger("click");

                    $(".save_remarks").removeAttr('disabled');
                    $(".save_remarks").text('Save');
                }
            },
            error: function resp() {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                // $(".btn_switch_back_to_actions").trigger("click");

                $(".save_remarks").removeAttr('disabled');
                $(".save_remarks").text('Save');
            }
        });
    });
</script>