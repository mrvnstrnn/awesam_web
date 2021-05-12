$(document).ready(() => {
    // if($("#firsttime_login").val() == 0){
    //     $("#firsttimeModal").modal({backdrop: 'static', keyboard: false});
    // }

    if($("#user_detail").val() != ''){
        $(".step-1-li").removeClass('active');
        $(".step-1-li").addClass('done');
        $(".step-2-li").addClass('done');
        $(".step-3-li").addClass('done');

        $("#step-1").addClass('d-none');
        $("#step-2").addClass('d-none');
        $("#step-3").addClass('d-none');
        $("#step-4").removeClass('d-none');

        $(".step-4-li").addClass('active');
    }

    $("#invite_btn").on('click', function(){
        $(this).text('Sending...');
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: $("#invitation_form").serialize(),
            success: function (resp) {
                if(!resp.error) {
                    $("#invitation_form")[0].reset();
                    toastr.success(resp.message, 'Success');
                    $("#invite_btn").text('Invite');
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                    $("#invite_btn").text('Invite');
                }
            },

            error: function (resp) {
                toastr.error(resp.message, 'Error');
            }
        });
    });

    // $(".update_password").on('click', function(){
    //     $.ajax({
    //         url: $(this).attr('data-href'),
    //         method: 'POST',
    //         data: $("#passwordUpdateForm").serialize(),
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(resp) {
    //             if (!resp.error) {
    //                 $("#passwordUpdateForm")[0].reset();
    //                 toastr.success(resp.message, 'Success');
    //                 $("#firsttimeModal").modal('hide');
    //             } else {
    //                 if (typeof resp.message === 'object' && resp.message !== null) {
    //                     $.each(resp.message, function(index, data) {
    //                         $("#" + index + "-error").text(data);
    //                     });
    //                 } else {
    //                     toastr.error(resp.message, 'Error');
    //                 }
    //             }
    //         },
    //         error: function (resp) {
    //             toastr.error(resp.message, 'Error');
    //         }
    //     });
    // });

    $("select[name=address]").on('change', function(){

        var id = $(this).attr('id');
        var val = $(this).val();

        $("#hidden_"+id).val(val);

        // if(
        //     $("#firstname").val() !== "" && 
        //     $("#lastname").val() !== "" && 
        //     $("#region").val() !== "" && 
        //     $("#province").val() !== "" && 
        //     $("#lgu").val() !== ""
        // ){
        //     $("#next-btn-1").removeAttr("disabled");
        // } else {
        //     $("#next-btn-1").attr("disabled", "disabled");
        // }

        if(id == 'province') {
            if (val == '') {
                $("#lgu option").remove();
                $("#lgu").attr('disabled', 'disabled');
                return;
            }
        } else if (id == 'region') {
            if (val == '') {
                $("#province option").remove();
                $("#lgu option").remove();

                $("#province").attr('disabled', 'disabled');
                $("#lgu").attr('disabled', 'disabled');
                return;
            }
        } else {
            return;
        }

        $.ajax({
            url:  $("#hidden_route").val(),
            method: 'POST',
            data: {
                id : id,
                val : val
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if(!resp.error){
                    if(resp.new_id) {
                        $("#"+resp.new_id+ " option").remove();
                        $("#"+resp.new_id).removeAttr('disabled');

                        if(id == 'region'){
                            $("#"+resp.new_id).append('<option value="">Please select province</option>');
                            resp.message.forEach(element => {
                                $("#"+resp.new_id).append('<option value="'+element.province+'">'+element.province+'</option>');
                            });
                        } else if (id == 'province'){
                            $("#"+resp.new_id).append('<option value="">Please select city</option>');
                            resp.message.forEach(element => {
                                $("#"+resp.new_id).append('<option value="'+element.lgu+'">'+element.lgu+'</option>');
                            });
                        }
                    }
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp) {
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $("#finish-btn").on('click', function(){
        $.ajax({
            url: $(this).attr('data-href'),
            data: $("#onboardingForm").serialize(),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (!resp.error){   
                    $(".step-1-li").removeClass('active');
                    $(".step-2-li").removeClass('active');
                    $(".step-3-li").removeClass('active');

                    $(".step-1-li").addClass('done');
                    $(".step-2-li").addClass('done');
                    $(".step-3-li").addClass('done');
                    $(".step-4-li").addClass('active');

                    $("#step-1").addClass('d-none');
                    $("#step-2").addClass('d-none');
                    $("#step-3").addClass('d-none');
                    $("#step-4").removeClass('d-none');

                    $(".results-title").text($("#mode").val());

                    toastr.success(resp.message, 'Success');
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            },
            error: function(resp) {
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $("#prev-btn").on('click', function(){
        $(".step-1-li").removeClass('done');
        $(".step-1-li").addClass('active');

        $(".step-2-li").removeClass('active');

        $("#step-1").removeClass('d-none');
        $("#step-2").addClass('d-none');
    });

    $("#prev-btn-2").on('click', function(){
        $(".step-1-li").removeClass('done');
        $(".step-1-li").addClass('active');

        $(".step-2-li").removeClass('active');

        $("#step-1").removeClass('d-none');
        $("#step-2").addClass('d-none');
    });

    $("#check-non-disclosure").on('change',function(){
        var atleastCheck = $('#check-non-disclosure:checkbox:checked').length > 0; 

        if(atleastCheck){
            $("#finish-btn").removeAttr('disabled');
        } else {
            $("#finish-btn").attr('disabled', 'disabled');
        }
    });
    
    $("#prev-btn-3").on('click', function(){
        $(".step-2-li").removeClass('done');
        $(".step-2-li").addClass('active');

        $(".step-3-li").removeClass('active');

        $("#step-2").removeClass('d-none');
        $("#step-3").addClass('d-none');
    });

    $(".reset-btn").on('click', function(){
        $(".step-1-li").removeClass('done');
        $(".step-2-li").removeClass('done');
        $(".step-1-li").addClass('active');
        
        $(".step-2-li").removeClass('active');
        $(".step-3-li").removeClass('active');

        $("#step-1").removeClass('d-none');
        $("#step-2").addClass('d-none');
        $("#step-3").addClass('d-none');

        $("#lgu option").remove();
        $("#province option").remove();

        $("#lgu").attr("disabled", "disabled");
        $("#province").attr("disabled", "disabled");

        $("#onboardingForm")[0].reset();
    });

    $("#next-btn-1").on('click', function(){
        if($(".step-1-li").hasClass('active')) {
            $(".step-1-li").removeClass('active');
            $(".step-2-li").addClass('active');
            
            $(".step-1-li").addClass('done');
            $("#step-1").addClass('d-none');
            $("#step-2").removeClass('d-none');
        }
    });

    $("#next-btn-2").on('click', function(){
        if($(".step-2-li").hasClass('active')) {
            $(".step-2-li").removeClass('active');
            $(".step-2-li").addClass('done');
            
            $("#step-2").addClass('d-none');
            $("#step-3").removeClass('d-none');

            $(".step-3-li").addClass('active');
        }
    });

});