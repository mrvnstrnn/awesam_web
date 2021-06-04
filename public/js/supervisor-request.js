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
        $(".approvereject_request_final").attr("data-id", data_info.id);

        $("#modalRequest").modal("show");
    });

    $(".reject_request").on("click", function(){

    });

    $(".approvereject_request_final").on("click", function(){
        var data_id = $(".approvereject_request_final").attr("data-id");
        var data_action = $(".approvereject_request_final").attr("data-action");
        $.ajax({
            url: $(this).attr("data-href"),
            data: {
                data_id : data_id,
                data_action : data_action
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            success: function (resp) {

                if(data_action == "approve"){
                    $('#active-request-table').DataTable().ajax.reload();
                    $('#approved-request-table').DataTable().ajax.reload(function (){
                        toastr.success(resp.message, "Success");
                    });
                } else {
                    $('#active-request-table').DataTable().ajax.reload();
                    $('#reject-request-table').DataTable().ajax.reload(function (){
                        toastr.success(resp.message, "Success");
                    });
                }
            },
            error: function (resp) {
                toastr.error(resp.message, "Error");
            }
        });
    });

});