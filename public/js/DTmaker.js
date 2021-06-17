
function makeDT(whatTable, whatCols, table_to_load) {

    // Load Datatable
    $(whatTable).DataTable({
        processing: true,
        serverSide: true,
        filter: true,
        
        ajax: {
            url: $(whatTable).attr('data-href'),
            type: 'GET',

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        
        language: {
            "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Kinukuha ang datos</strong></div>",
        },
        dataSrc: function(json){
            return json.data;
        },

        createdRow: function (row, data, dataIndex) {
                $(row).attr('data-activity', data.activity_name);
                $(row).attr('data-site', data.site_name);
                $(row).attr('data-sam_id', data.sam_id);
        },

        columns: whatCols

    }); 


    
    
}



$(document).ready(() => {

    $('.assigned-sites-table').each(function(i, obj) {

        var activeTable = document.getElementById(obj.id)

        active_program = $(activeTable).attr('data-program_id');

        // Get Active Tab Where Table is located
        var active_tab =  $(activeTable).closest('div').attr('id');

        if($(activeTable).attr('data-table_loaded') === "false" && $("#"+active_tab).hasClass('show')){

            var cols = getCols(active_program, table_to_load, profile_id);

            // console.log(cols);

            if(cols.length > 0){
                // Add Column Headers
                $.each(cols, function (k, colObj) {
                        str = '<th>' + colObj.name + '</th>';
                        $(str).appendTo($(activeTable).find("thead>tr"));
                });

                makeDT(activeTable, cols, table_to_load);

                // Set Table setting to loaded
                $(activeTable).attr('data-table_loaded', "true");

            }
        }

    });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var active_tab = $(this).attr('href');
        var activeTable = "#" + $(active_tab).find('table').attr('id');
        var active_program = $(activeTable).attr('data-program_id');

        var cols = getCols(active_program, table_to_load, profile_id);

        if( $(activeTable).attr('data-table_loaded') === "false" && cols.length > 0 ){


            // Add Column Headers
            $.each(cols, function (k, colObj) {
                str = '<th>' + colObj.name + '</th>';
                $(str).appendTo($(activeTable).find("thead>tr"));
            });

            makeDT(activeTable, cols, table_to_load);
        
            // Set Table setting to loaded
            $(activeTable).attr('data-table_loaded', "true");

        } else {
            console.log('Program Columns Not');
        }

    
    });



});
