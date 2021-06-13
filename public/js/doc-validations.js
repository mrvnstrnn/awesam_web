

    function getCols(active_program){

        var cols = [];


        $.ajax({
            url: "/datatables-columns/"+active_program+"/doc_validation",
            method: 'GET',
            async: false,

            success: function (resp) {

                if(resp.length > 0){
                    resp.forEach(function(field){

                        switch(field['source_field']){
                            case "site_fields":
                                cols.push(
                                    {
                                        data : field['source_field'], 
                                        name: field['field_name'],
                                        render : function(data){
        
                                            col = JSON.parse(data.replace(/&quot;/g,'"'));
                                            var results = $.map( col, function(e,i){
                                                if( e.field_name === field['search_field'] ) 
                                                return e; 
                                            });
                                            return results[0]['value'];
                                        
                                        }
                                    }
                                );
                                break;

                            case 'site_agent':
                                cols.push(
                                    {
                                        data : field['source_field'], 
                                        name: field['field_name'],
                                        render : function(data){
                                            col = JSON.parse(data.replace(/&quot;/g,'"'));
                                            agent = col[0]['firstname'] + " " + col[0]['middlename'] + " " + col[0]['lastname'];
                                            return agent;
                                        }
                                    }
                                );
                                break;

                            case 'action':
                                cols.push(
                                    {
                                        data : field['source_field'], 
                                        name: field['field_name'],
                                        render : function(data){
                                            data_icon = data;
                                            return data_icon;
                                        }
                                    }
                                );
                                break;

                            default:
                                cols.push({data : field['source_field'], name: field['field_name']});

                        }

                    });    
                }

            },

            error: function (resp) {
                console.log(resp);
            }

        });


        console.log(cols);

        return cols;

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
                    
                    language: {
                        "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Kinukuha ang datos</strong></div>",
                    },
        
                    columns: cols,
                    createdRow: function (row, data, dataIndex) {
                        $(row).attr('data-sam_id', data.sam_id);
                    }
                }); 

                // Set Table setting to loaded
                $(activeTable).attr('data-table_loaded', "true");

            }
        }

    });


    $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
        e.preventDefault();

        $('#viewInfoModal').modal('show')

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

                language: {
                    "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Kinukuha ang datos</strong></div>",
                },
                
                columns: cols,

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-sam_id', data.sam_id);
                }

            }); 

            // Set Table setting to loaded
            $(activeTable).attr('data-table_loaded', "true");

        } else {
            console.log('Program Columns Not');
        }

    
    })

});
