$(document).ready(() => {    
    
    /////////////////////////////////////
    //                                 //  
    //           REQUEST TABLE         //
    //                                 //  
    /////////////////////////////////////


    var table_list = ['active', 'approved', 'denied'];

    for (let i = 0; i < table_list.length; i++) {
        $('#'+table_list[i]+'-request-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#'+table_list[i]+'-request-table').attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data ) {
                $(row).attr('data-info', JSON.stringify(data));
                // $(row).attr('data-program', program_lists[i]);
                $(row).addClass('modalDataRequestInfo');
            },
            columnDefs: [{
                "targets": 0,
                "orderable": false
            }],
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "email" },
                { data: "request_type" },
                { data: "reason" },
                { data: "requested_date" },
                { data: "date_created" },
            ],
        });
    }
    
    /////////////////////////////////////
    //                                 //  
    //       END REQUEST TABLE         //
    //                                 //  
    /////////////////////////////////////

    $("table#active-request-table").on("click", "tr.modalDataRequestInfo", function(e){
        e.preventDefault();

        var data_info = JSON.parse($(this).attr('data-info'));

        $(".reject_request").attr("data-id", data_info.id);
        $(".reject_request").attr("data-name", data_info.name);
        $(".approvereject_request_final").attr("data-id", data_info.id);

        
        $("#request_type").val(data_info.request_type.replace(/(<([^>]+)>)/gi, ""));
        $("#start_date").val(data_info.start_date_requested);
        $("#end_date").val(data_info.end_date_requested);
        $("#reason").text(data_info.reason);

        $("#modalRequest").modal("show");
    });

    $(".reject_request").on("click", function(e){
        e.preventDefault();
        $("#modalRequest").modal("hide");
        $("#deniedModal").modal("show");

        
        var data_id = $(".reject_request").attr("data-id");
        var data_name = $(".reject_request").attr("data-name");

        $(".denied-name").text(data_name);

        $(".approvereject_request_final").attr("data-id", data_id);
        $(".approvereject_request_final").attr("data-name", data_name);
    });

    $(".approvereject_request_final").on("click", function(e){
        e.preventDefault();
        var data_id = $(this).attr("data-id");
        var data_action = $(this).attr("data-action");

        var reason = $("#reason").val();
        $.ajax({
            url: $(this).attr("data-href"),
            data: {
                data_id : data_id,
                data_action : data_action,
                reason : reason
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            success: function (resp) {

                if(!resp.error){
                    $('#active-request-table').DataTable().ajax.reload();
                    $('#approved-request-table').DataTable().ajax.reload(function (){
                        toastr.success(resp.message, "Success");
                        if (data_action == "denied") {
                            $("#deniedModal").modal("hide");
                        } else {
                            $("#modalRequest").modal("hide");
                        }
                        $("textarea").val("");
                    });
                } else {
                    // $('#active-request-table').DataTable().ajax.reload();
                    // $('#reject-request-table').DataTable().ajax.reload(function (){
                        toastr.error(resp.message, "Error");

                        $("#message-error").text(resp.message[0]);
                        // $("#modalRequest").modal("hide");
                    // });
                }
            },
            error: function (resp) {
                toastr.error(resp.message, "Error");
            }
        });
    });

});