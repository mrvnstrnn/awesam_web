var cols = [];


function getSiteFieldValue(data, field){
    col = JSON.parse(data.replace(/&quot;/g,'"'));
    var results = $.map( col, function(e,i){
        if( e.field_name === field ) 
        return e; 
    });
    return results[0]['value'];
}

function getSiteAgent(data){

    col = JSON.parse(data.replace(/&quot;/g,'"'));
    agent = col[0]['firstname'] + " " + col[0]['middlename'] + " " + col[0]['lastname'];
    return agent;

}

function getCols(active_program){


    var cols = [];

    switch(active_program){

        case "1":
            cols.push({data : 'sam_id', name: 'SAM ID'});
            cols.push({data : 'site_name', name: 'Site Name'});
            break;

        case "2":
            cols.push({data : 'sam_id', name: 'SAM ID'});
            cols.push({data : 'site_name', name: 'Site Name'});
            break;

        case "3":
            // cols.push(
            //     {
            //         data : "site_agent", 
            //         name: 'Agent',
            //         render : function(data){
            //             return getSiteAgent(data);
            //         }
            //     }
            // );
            cols.push(
                {
                    data : "site_fields", 
                    name: 'Technology',
                    render : function(data){
                        return getSiteFieldValue(data, 'TECHNOLOGY');
                    }
                }
            );
            cols.push({data : 'site_name', name: 'Site Name'});
            cols.push(
                {
                    data : "site_fields", 
                    name: 'Nomination ID',
                    render : function(data){
                        return getSiteFieldValue(data, 'NOMINATION_ID');
                    }
                }
            );
            cols.push(
                {
                    data : "site_fields", 
                    name: 'PLA ID',
                    render : function(data){
                        return getSiteFieldValue(data, 'PLA_ID');
                    }
                }
            );
            break;
        
        case "4":
            cols.push({data : 'sam_id', name: 'SAM ID'});
            cols.push({data : 'site_name', name: 'Site Name'});
            break;

        case "5":
            cols.push({data : 'sam_id', name: 'SAM ID'});
            cols.push({data : 'site_name', name: 'Site Name'});
            break;

        case "6":
            cols.push({data : 'sam_id', name: 'SAM ID'});
            cols.push({data : 'site_name', name: 'Site Name'});
            break;

        case "7":
            cols.push({data : 'sam_id', name: 'SAM ID'});
            cols.push({data : 'site_name', name: 'Site Name'});
            break;

        case "8":
            cols.push({data : 'sam_id', name: 'SAM ID'});
            cols.push({data : 'site_name', name: 'Site Name'});
            break;

    }

    return cols;

}


$('.assigned-sites-table').each(function(i, obj) {

    var activeTable = document.getElementById(obj.id)

    active_program = $(activeTable).attr('data-program_id');

    var cols = getCols(active_program);


    // Get Active Tab Where Table is located
    var active_tab =  $(activeTable).closest('div').attr('id');

    if(cols.length > 0 && $(activeTable).attr('data-table_loaded') === "false" && $("#"+active_tab).hasClass('show')){


        // Add Column Headers
        $.each(cols, function (k, colObj) {
                str = '<th>' + colObj.name + '</th>';
                $(str).appendTo($(activeTable).find("thead>tr"));
        });

        // Load Datatable
        $(activeTable).DataTable({
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

        // Set Table setting to loaded
        $(activeTable).attr('data-table_loaded', "true");
    }

});


$('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
    e.preventDefault();

    window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
});


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

    var active_tab = $(this).attr('href');
    var activeTable = "#" + $(active_tab).find('table').attr('id');
    var active_program = $(activeTable).attr('data-program_id');



    if( $(activeTable).attr('data-table_loaded') === "false" ){

        var cols = getCols(active_program);

        // Add Column Headers
        $.each(cols, function (k, colObj) {
            str = '<th>' + colObj.name + '</th>';
            $(str).appendTo($(activeTable).find("thead>tr"));
        });

    
        // Load Datatable
        $(activeTable).DataTable({
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

        // Set Table setting to loaded
        $(activeTable).attr('data-table_loaded', "true");

    }

  
})
