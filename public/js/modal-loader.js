        $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {

            e.preventDefault();

            if($(this).find("td").hasClass('dataTables_empty') == false){
                var sam_id = $(this).attr('data-sam_id');
                var activity = $(this).attr('data-activity')
                var main_activity = $(this).attr('data-main_activity')
                var site = $(this).attr("data-site");

                loader = '<div class="p-2">Loading...</div>';
                $.blockUI({ message: loader });

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
        });

