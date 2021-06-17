        $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {

            e.preventDefault();
            if($(this).find("td").attr("colspan") != 4){

                console.log($(this).attr("data-site"));

                var sam_id = $(this).attr('data-sam_id');
                var activity = $(this).attr('data-activity');

                $("#viewInfoModal .modal-title").text($(this).attr("data-site") + " : " + activity);

                $.ajax({
                    url: "/get-all-docs",
                    method: "POST",
                    data: {
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

        
        $(document).on("click", ".file_list_item", function (e){

            e.preventDefault();
            console.log(this);


            $(".file_list_item").removeClass('active');
            $(this).addClass('active');

            if($(this).attr('data-status')=="approved"){
                $('.btn_reject_approve').prop('disabled', true);
            } else {
                $('.btn_reject_approve').prop('disabled', false);
            }
            
            $('.modal_preview_marker').text($(this).attr('data-sub_activity_name') + " : " + $(this).attr('data-value'))

            var extensions = ["pdf", "jpg", "png"];

            if( extensions.includes($(this).attr('data-value').split('.').pop()) == true) {     

                htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 380px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';
                $('.modal_preview_content').html(htmltoload);

            } else {
                htmltoload = '<div class="text-center my-5"><a href="/files/' + $(this).attr('data-value') + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
                $('.modal_preview_content').html(htmltoload);
            }



        });
