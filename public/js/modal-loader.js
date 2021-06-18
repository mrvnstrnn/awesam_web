        $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {

            e.preventDefault();

            if($(this).find("td").hasClass('dataTables_empty') == false){

                console.log($(this).attr("data-site"));

                var sam_id = $(this).attr('data-sam_id');
                var activity = $(this).attr('data-activity')
                var site = $(this).attr("data-site");

                console.log(sam_id);
                console.log(activity);
                console.log(site);

                $("#viewInfoModal .modal-title").text($(this).attr("data-site") + " : " + activity);

                $.ajax({
                    url: "/get-all-docs",
                    method: "POST",
                    data: {
                        site : site,
                        activity : activity,
                        mode : table_to_load,
                        sam_id : sam_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#loader_modal').modal('show');
                     },
          
                    success: function (resp){

                        console.log(resp);
                        // $('#loader_modal').modal('hide');

                        $('.ajax_content_box').html("");   
                        $('.ajax_content_box').html(resp);   

                        $('#viewInfoModal').modal('show');

                    },
                    complete: function(){
                        $('#loader_modal').modal('hide');
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

