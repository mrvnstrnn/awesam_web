

$(document).ready(() => {

    $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
        e.preventDefault();
        if($(this).find("td").attr("colspan") != 4){
            showfile = $(this).attr('data-value');
            showaction = $(this).attr('data-action');
            data_value_id = $(this).attr('data-value_id');
            data_table = $(this).parent().parent()[0].id;

            console.log(showfile);
    
            $(".btn_reject_approve").attr("data-id", data_value_id);
            $(".btn_reject_approve").attr("data-table", data_table);
    
            $('.modal-body').html('');
    
            iframe =  '<div class="embed-responsive" style="height: 460px;">' +
                        '<iframe class="embed-responsive-item" src="files/' + showfile + '" allowfullscreen></iframe>' +
                      '</div>';
    
            $('.modal-body').html(iframe);
    
            $('#viewInfoModal').modal('show');
        }

        // window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
    });

    $(".btn_reject_approve").on("click", function(){

        var data_action = $(this).attr("data-action");
        var data_id = $(this).attr("data-id");
        var data_table = $(this).attr("data-table");

        console.log(data_table);

        $.ajax({
            url: "/doc-validation-approvals/"+data_id+"/"+data_action,
            method: "GET",
            success: function(resp){
                if(!resp.error){
                    $("#"+data_table).DataTable().ajax.reload(function(){
                        $('#viewInfoModal').modal('hide');
                        toastr.success(resp.message,"Success");
                    });
                } else {
                    toastr.error(resp.message,"Error");
                }
            },
            error: function(resp){
                toastr.error(resp.message,"Error");
            }
        });
    })

});