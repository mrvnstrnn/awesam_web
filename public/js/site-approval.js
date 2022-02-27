

$(document).ready(() => {

    $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
        e.preventDefault();
        if($(this).find("td").attr("colspan") != 4){
            showfile = "";
            // showaction = $(this).attr('data-action');
            // data_value_id = $(this).attr('data-value_id');
            // data_table = $(this).parent().parent()[0].id;

            // console.log(showfile);
    
            // $(".btn_reject_approve").attr("data-id", data_value_id);
            // $(".btn_reject_approve").attr("data-table", data_table);
    
            $('.modal-body').html('');
    
            iframe =  '<div class="embed-responsive" style="height: 460px;">' +
                        '<iframe class="embed-responsive-item" src="files/' + showfile + '" allowfullscreen></iframe>' +
                      '</div>';
    
            $('.modal-body').html(iframe);
    
            $('#viewInfoModal').modal('show');
        }

        // window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
    });


});