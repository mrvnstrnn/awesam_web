        $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {

            e.preventDefault();

            
            $(".ajax_content_box").attr("data-what_table", $(this).attr('data-what_table'));

            if($(this).find("td").hasClass('dataTables_empty') == false){

                if (typeof $(this).attr('data-sam_id') !== 'undefined') {

                    var sam_id = $(this).attr('data-sam_id');
                    var activity = $(this).attr('data-activity');
                    var main_activity = $(this).attr('data-main_activity');
                    var site = $(this).attr("data-site");
    
                    var program_id =  $("#"+$(this).attr('data-what_table')).attr("data-program_id");

                    // loader = "<img src='/images/awesam_med.png' />";
                    // $.blockUI({ 
                    //     message: loader,  
                    //     css: {
                    //         backgroundColor: 'transparent',
                    //         border: '0',
                    //         width: '300px',
                    //     }
                    // });
    
                    $("#viewInfoModal .modal-title").text($(this).attr("data-site") + " : " + activity);
    
                    $.ajax({
                        url: "/get-all-docs",
                        method: "POST",
                        data: {
                            site : site,
                            activity : activity,
                            main_activity : main_activity,
                            mode : table_to_load,
                            sam_id : sam_id,
                            program_id : program_id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                         },
              
                        success: function (resp){
                            $('.ajax_content_box').html("");
                            $('.ajax_content_box').html(resp);
    
                            $.unblockUI();
                            $('#viewInfoModal').modal('show');

                        },
                        complete: function(){
                            // $('#loader_modal').modal('hide');
                            // $('.modal-backdrop').hide();
                        },
                        error: function (resp){
                            toastr.error(resp.message, "Error");
                        }
                    })
                    .done(function(){
                        $('.file_list_item').first().click();
                    });
    
                }

                else {


                    var activity = $(this).attr('data-activity');
                    var all = $(this).attr('data-site_all');
                    var program_id =  $("#"+$(this).attr('data-what_table')).attr("data-program_id");


                    loader = '<div class="p-2">Loading...</div>';
                    $.blockUI({ message: loader });


                    $("#viewInfoModal .modal-title").text($(this).attr("data-site") + " : " + activity);


                        $.ajax({
                            url: "/get-pr-memo",
                            method: "POST",
                            data: {
                                pr_memo : all,
                                activity : activity,
                                program_id : program_id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function() {
                             },
                  
                            success: function (resp){
                                $('.ajax_content_box').html("");   
                                $('.ajax_content_box').html(resp);
        
                                $.unblockUI();
                                $('#viewInfoModal').modal('show');
        
        
                            },
                            complete: function(){
    
                                // $('#loader_modal').modal('hide');
                                // $('.modal-backdrop').hide();
                            },
                            error: function (resp){
                                toastr.error(resp.message, "Error");
                            }
                        });




                    
    
                }
            } 
        });

        
        $('.show_activity_modal').on( 'click', function (e) {

            e.preventDefault();

            var sam_id = $(this).attr('data-sam_id');
            var activity = $(this).attr('data-activity')
            var activity_id = $(this).attr('data-activity_id')
            var site = $(this).attr("data-site");
            var main_activity = $(this).attr('data-main_activity')

            var loader =  '<div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">' +
            '<div class="loader">' +
             '<div class="ball-scale-multiple">' +
               '<div></div>' +
               '<div></div>' +
               '<div></div>' +
             '</div>' +
            '</div>' +
            '</div>';
            $.blockUI({ message: loader });

            $(".ajax_content_box").attr("data-sam_id", $(this).attr('data-sam_id'));
            $(".ajax_content_box").attr("data-activity", $(this).attr('data-activity'));

            $.ajax({
                url: "/get-all-docs",
                method: "POST",
                data: {
                    site : site,
                    activity : activity,
                    activity_id : activity_id,
                    main_activity : main_activity,
                    sam_id : sam_id,
                    vendor_mode : true
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                 },
      
                success: function (resp){
                    $('.ajax_content_box').html("");   
                    $('.ajax_content_box').html(resp);   

                    $.unblockUI();
                    $('#viewInfoModal').modal('show');


                },
                complete: function(){
                    // $('#loader_modal').modal('hide');
                    // $('.modal-backdrop').hide();
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });



        });

        

