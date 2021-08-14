
function makeDT(whatTable, whatCols, table_to_load) {

        if (typeof main_activity === 'undefined') {
            main_activity = "";
        }
        
        $(whatTable).DataTable({
            processing: true,
            serverSide: false,
            filter: true,
            searching: true,
            lengthChange: true,
            regex: true,
            ajax: {
                url: $(whatTable).attr('data-href'),
                type: 'GET',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            
            language: {
                // "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Kinukuha ang datos</strong></div>",
                "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Loading...</strong></div>",
            },
            
            dataSrc: function(json){
                return json.data;
            },

            createdRow: function (row, data, dataIndex) {
                // console.log(data);
                $(row).attr('data-site_all', JSON.stringify(data));
                $(row).attr('data-activity', data.activity_name);
                $(row).attr('data-site', data.site_name);
                $(row).attr('data-sam_id', data.sam_id);
                $(row).attr('data-main_activity', main_activity);
                $(row).attr('data-profile', data.profile_id);
                $(row).attr('data-what_table', $(whatTable).attr('id'));
                $(row).attr('data-issue_id', data.issue_id ? data.issue_id : "");

                $(row).attr('data-program_id', data.program_id ? data.program_id : "");
                $(row).attr('data-vendor_id', data.vendor_id ? data.vendor_id : "");
                $(row).attr('data-site_category', data.site_category);
            },
            
            columns: whatCols,

            columnDefs: [ 
                {
                    "targets": [ "site_name" ],
                    "visible": true,
                    "searchable": true,
                    "render": function ( data, type, row ) {
                        return '<div class="font-weight-bold">' + data +'</div> <small>'+ row['sam_id'] + '</small>';
                    },
                },
                {
                    "targets": [ "sam_id" ],
                    "visible": false,
                    "searchable": true,
                },
                {
                    "targets": [ "activity_name" ],
                    "visible": true,
                    "searchable": true,
                    "render": function ( data, type, row ) {

                        var varDate = new Date(row['end_date']);
                        var today = new Date();
                        today.setHours(0,0,0,0);

                        if(varDate >= today) {
                            // console.log('Greater: ' + row['end_date']);
                            badge_color = "success";
                            date_text = row['start_date'] + ' to ' +row['end_date'];

                        } else {
                            // console.log('Lower: ' + row['end_date']);
                            badge_color = "danger";
                            const diffTime = Math.abs(today - varDate);
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                            date_text = diffDays + " days delayed";
                                                        
                        }

                        
                        return '<div class="badge badge-' + badge_color + ' text-sm mb-0 px-2 py-1">' + data +'</div>' + 
                                '<div><small>'+ date_text +'</small></div>'
                    },
                }

            ]
    

        }); 


    // $('#DTsearch').on( 'keyup', function () {
    //     XDT.search( this.value ).draw();
    // } );



    
    
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


                        str = '<th class="' + colObj.data + '">' + colObj.name + '</th>';
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
                str = '<th class="' + colObj.data + '">' + colObj.name + '</th>';
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