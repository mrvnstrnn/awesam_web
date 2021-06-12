var cols = [];


$('.assigned-sites-table').each(function(i, obj) {

    var activeTable = document.getElementById(obj.id)


    if($(activeTable).attr('data-program_id')==='3'){

        cols = [
            {data : null, name: 'agent'},
            {data : 'sam_id', name: 'SAM ID'},
            {data : 'site_name', name: 'Site Name'}, 

            // {
            //     data : 'site_fields',
            //     name: 'Nomination ID', 
            //     render : function(data){
            //             col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //             return col["NOMINATION_ID"];
            //     },
            // },
            // {
            //     data : 'site_fields',
            //     name: 'Technology', 
            //     render : function(data){
            //             col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //             return col["TECHNOLOGY"];
            //     },
            // },
            // {
            //     data : 'site_fields',
            //     name: 'PLA_ID', 
            //     render : function(data){
            //             col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //             return col["PLA_ID"];
            //     },
            // },
            // {
            //     data : 'site_fields',
            //     name: 'Location', 
            //     render : function(data){
            //         col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //         $field = '<div class="widget-content-left flex2">' +
            //                     '<div class="widget-heading">' + col['REGION'] + '</div>' +
            //                     '<div class="widget-subheading opacity-7">' + col['LOCATION'] + '</div>' +
            //                 '</div>';
            //         return $field;
            //     },
            // },
            //{
            //    data : 'site_fields',
            //    name: 'Nomination ID', 
            //    render : function(data){
            //            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //            return col["NOMINATION_ID"];
            //    },
            //},

        ];

    }
    else if($(activeTable).attr('data-program_id')==='4'){
        cols = [
            {data : 'sam_id', name: 'SAM ID'},
            {data : 'site_name', name: 'Site Name'}, 
            // {
            //     data : 'site_fields',
            //     name: 'PLA_ID', 
            //     render : function(data){
            //             col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //             return col["PLA_ID"];
            //     },
            // },
            // {
            //     data : 'site_fields',
            //     name: 'PROGRAM', 
            //     render : function(data){
            //             col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //             return col["PROGRAM"];
            //     },
            // },
            // {
            //     data : 'site_fields',
            //     name: 'Location', 
            //     render : function(data){
            //         col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //         $field = '<div class="widget-content-left flex2">' +
            //                     '<div class="widget-heading">' + col['REGION'] + '</div>' +
            //                 '</div>';
            //         return $field;
            //     },
            // },
            //{
            //    data : 'site_fields',
            //    name: 'PLA_ID', 
            //    render : function(data){
            //            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //            return col["PLA_ID"];
            //    },
            //},
            //{
            //    data : 'site_fields',
            //    name: 'PROGRAM', 
            //    render : function(data){
            //            col = JSON.parse(data.replace(/&quot;/g,'"'))[0];
            //            return col["PROGRAM"];
            //    },
            //},
        ];
    } else {
        cols = [];
    }

    $.each(cols, function (k, colObj) {
            str = '<th>' + colObj.name + '</th>';
            $(str).appendTo($(activeTable).find("thead>tr"));
    });


    var table = $(activeTable).DataTable({
      processing: true,
      serverSide: true,          
      
      ajax: {
            url: $(activeTable).attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
      
      columns: cols,
      createdRow: function (row, data, dataIndex) {
         $(row).attr('data-sam_id', data.sam_id);
      }
  });


});


$('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
    e.preventDefault();

    window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
});

