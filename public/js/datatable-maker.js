$(document).ready(() => {


    var cols = [
        {data: null},
        {data: null},
        {data: null},
        {data: null},
    ];


    $("#datatable-coloc-program-sites").DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: "/datatable-data/3/1/program sites",
        type: 'GET',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },
    
    language: {
        "processing": "<img src='/images/awesam_loader.png' width='120px;' alt-text='Loading...'/>",
    },
    
    dataSrc: function(json){
        return json.data;
    },

    createdRow: function (row, data, dataIndex) {
    },
    
    columns: cols,

    columnDefs: [ 
        {
            "targets": [ "site_name" ],
            "visible": true,
            "searchable": true,
            "render": function ( data, type, row ) {
                if (row['region_name'] == undefined || row['province_name'] == undefined || row['lgu_name'] == undefined) {
                    return '<div class="font-weight-bold">' + data +'</div><div></div><div> <small>'+ row['sam_id'] + '</small></div>';
                } else {
                    return '<div class="font-weight-bold">' + data +'</div><div><small>' + row['region_name'] + ' > ' + row['province_name'] + ' > ' + row['lgu_name'] + '</small></div><div> <small>'+ row['sam_id'] + '</small></div>';
                }
            },
        },
        {
            "targets": [ "sam_id" ],
            "visible": false,
            "searchable": true,
        },
        // {
        //     "targets": [ "activity_name" ],
        //     "visible": true,
        //     "searchable": true,
        //     "render": function ( data, type, row ) {

        //         var varDate = new Date(row['end_date']);
        //         var today = new Date();
        //         today.setHours(0,0,0,0);

        //         if(varDate >= today) {
        //             badge_color = "success";
        //             date_text = row['start_date'] + ' to ' +row['end_date'];

        //         } else {
        //             badge_color = "danger";
        //             const diffTime = Math.abs(today - varDate);
        //             const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        //             date_text = diffDays + " days delayed";
                                                
        //         }

                
        //         return '<div class="badge badge-' + badge_color + ' text-sm mb-0 px-2 py-1">' + data +'</div>' + 
        //                 '<div><small>'+ date_text +'</small></div>'
        //     },
        // }

    ]


}); 

});