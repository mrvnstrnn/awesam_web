        $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {

            e.preventDefault();
            if($(this).find("td").attr("colspan") != 4){

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
                    success: function (resp){

                        console.log(resp);
                        $('.ajax_content_box').html(resp);   


                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
                })
                .done(function(){
                    $('#viewInfoModal').modal('show');
                    $('.file_list_item').first().click();
                });
            }
        });

        
