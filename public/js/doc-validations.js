
function makeDT(whatTable, whatCols) {

    // Load Datatable
    $(whatTable).DataTable({
        processing: true,
        serverSide: false,          
        
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

        columns: whatCols,
        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-sam_id', data.sam_id);
            $(row).attr('data-value_id', data.value_id);
            $(row).attr('data-value', data.value);
            $(row).attr('data-action', data.action);

        }
    }); 


    
    
}

$(document).ready(() => {

    $('.assigned-sites-table').each(function(i, obj) {

        var activeTable = document.getElementById(obj.id)

        active_program = $(activeTable).attr('data-program_id');

        // Get Active Tab Where Table is located
        var active_tab =  $(activeTable).closest('div').attr('id');

        if($(activeTable).attr('data-table_loaded') === "false" && $("#"+active_tab).hasClass('show')){

            var cols = getCols(active_program);

            console.log(cols);

            if(cols.length > 0){
                // Add Column Headers
                $.each(cols, function (k, colObj) {
                        str = '<th>' + colObj.name + '</th>';
                        $(str).appendTo($(activeTable).find("thead>tr"));
                });

                makeDT(activeTable, cols);

                // Set Table setting to loaded
                $(activeTable).attr('data-table_loaded', "true");

            }
        }

    });


    $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
        e.preventDefault();

        showfile = $(this).attr('data-value');
        showaction = $(this).attr('data-action');

        $('.modal-body').html('');

        iframe =  '<div class="embed-responsive" style="height: 460px; text-center;">' +
                    '<iframe class="embed-responsive-item" src="files/' + showfile + '" allowfullscreen></iframe>' +
                  '</div>';

        $('.modal-body').html(iframe);

        $('#viewInfoModal').modal('show');

        // window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
    });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var active_tab = $(this).attr('href');
        var activeTable = "#" + $(active_tab).find('table').attr('id');
        var active_program = $(activeTable).attr('data-program_id');

        var cols = getCols(active_program);

        if( $(activeTable).attr('data-table_loaded') === "false" && cols.length > 0 ){


            // Add Column Headers
            $.each(cols, function (k, colObj) {
                str = '<th>' + colObj.name + '</th>';
                $(str).appendTo($(activeTable).find("thead>tr"));
            });

            makeDT(activeTable, cols);
        
            // Set Table setting to loaded
            $(activeTable).attr('data-table_loaded', "true");

        } else {
            console.log('Program Columns Not');
        }

    
    })

});
