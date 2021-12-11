$(document).ready(() => {

    $(".list-of-agent-dropdown-daily, .list-of-agent-dropdown-weekly, .list-of-agent-dropdown-monthly").on("click", function(){

        var classes = $(this).parent().closest('div').attr('class').split(' ');
        $(".dropdown-list-agent a").remove();
        
        if(classes.includes('show') == false) {
            $.ajax({
                url: "/get-agent",
                method: "GET",
                success: function(resp) {
                    if(!resp.error){
                        resp.message.forEach(element => {
                            $(".dropdown-list-agent").append(
                                '<a href="/activities/'+element.id+'" value="'+element.id+'" tabindex="0" class="dropdown-item agent_filter_activities">'+
                                    '<i class="dropdown-icon lnr-user"> </i><span>'+element.name+'</span>'+
                                '</a>'
                            );
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function(resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        }
    });

});