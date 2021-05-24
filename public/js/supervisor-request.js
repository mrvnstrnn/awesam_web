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

});