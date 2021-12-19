
function makeDT(whatTable, whatCols, active_program) {

        var table_id = $(whatTable).attr("id");

        $('#' + table_id + ' thead tr')
            .clone(true)
            .addClass('filters')
            .prependTo('#' + table_id + ' thead');

        if (typeof main_activity === 'undefined') {
            main_activity = "";
        }
        
        var dt = $(whatTable).DataTable({
            processing: true,
            serverSide: false,
            filter: true,
            searching: true,
            lengthChange: true,
            responsive: true,
            stateSave: false,
            regex: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],    
      
            // scrollX: true,   
    
            dom: 'Bfrtip',
            buttons: [
                'pageLength', 
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
    
            ajax: {
                url: $(whatTable).attr('data-href'),
                type: 'GET',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            
            language: {
                
                "processing": "<img src='/images/awesam_loader.png' width='120px;' alt-text='Loading...'/>",
            },
            
            dataSrc: function(json){
                // console.log(json.data);
                return json.data;
            },

            createdRow: function (row, data, dataIndex) {

                // console.log(data);
                // if (data.activities != undefined) {
                //     var activity_names = JSON.parse( JSON.stringify(data.activities.replace(/&quot;/g,'"')) );

                //     var activity_name = JSON.parse(activity_names) != null ? JSON.parse(activity_names).activity_name : "";
                // } else {
                //     var activity_name = data.activity_name;
                // }

                // $(row).attr('data-site_all', JSON.stringify(data));
                // // $(row).attr('data-activity', data.activity_name);
                $(row).attr('data-id', data.id);
                // // $(row).attr('data-activity', JSON.parse(activity_name) != null ? JSON.parse(activity_name).activity_name : "");
                $(row).attr('data-site', data.site_name);
                $(row).attr('data-sam_id', data.sam_id);
                // console.log(data);
                // $(row).attr('data-main_activity', main_activity);
                // $(row).attr('data-profile', data.profile_id);
                $(row).attr('data-what_table', $(whatTable).attr('id'));

                if ( data.issue_id != undefined || data.issue_id) {
                    $(row).attr('data-issue_id', data.issue_id ? data.issue_id : "");
                }
                $(row).attr('data-program_id', data.program_id ? data.program_id : "");
                // $(row).attr('data-vendor_id', data.vendor_id ? data.vendor_id : "");
                $(row).attr('data-site_category', data.site_category);
                $(row).attr('data-activity_id', data.activity_id);
            },
            
            columns: whatCols,

            // columnDefs: [ 
            // ],

            "fnInitComplete": function(oSettings, json) {

                // Filter
                var api = this.api();
 
                // For each column
                api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );

                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                    .off('keyup change')
                    .on('keyup change', function (e) {
                        e.stopPropagation();

                        // Get the search value
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})'; //$(this).parents('th').find('select').val();

                        var cursorPosition = this.selectionStart;
                        // Search the column for that value
                        api
                            .column(colIdx)
                            .search(
                                this.value != ''
                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                    : '',
                                this.value != '',
                                this.value == ''
                            )
                            .draw();

                        $(this)
                            .focus()[0]
                            .setSelectionRange(cursorPosition, cursorPosition);
                    });
                });


                // MINIDASHBOARD FILTER MAKER

                if(active_program == 3){

                    if(window.location.pathname == "/program-sites"){
                        var filter_column = "gt_saq_milestone";
                    } 
                    else {
                        var filter_column = "gt_saq_milestone";

                    }
                }
                else if(active_program == 4){

                    if(window.location.pathname == "/program-sites"){
                        var filter_column = "saq_milestone";
                    } 
                    else {
                        var filter_column = "program";

                    }
                }
                else if(active_program == 8){

                    if(window.location.pathname == "/program-sites"){
                        var filter_column = "mar_status";
                    } 
                    else {
                        var filter_column = "classification";

                    }
                }        

                // console.log(result);

                // console.log();
                var object_data = json.data.sort((a, b) => (a.activity_id > b.activity_id) ? 1 : -1);

                var occurences = object_data.reduce(function (r, row) {
                    r[row[filter_column]] = ++r[row[filter_column]] || 1;
                    return r;
                }, {});
            
                var result = Object.keys(occurences).map(function (key) {
                    return { key: key, value: occurences[key] };
                });

                var i = 0;
                var bg = 1;
                $.each(result, function(){

                    var xx =    '<div class="col-2 border">' +          
                                    '<div class="milestone-bg bg_img_' + (bg) + '" style=""></div>' +
                                    '<div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">' +
                                        '<div class="widget-numbers mt-1" id=>' + result[i].value + '</div>' +
                                        '<div class="widget-subheading">'+ result[i].key + '</div>' +
                                    '</div>' +
                                '</div>';         

                    $(document).find('#dashboard_counters_options').append(xx);

                    i = i+1;
                    
                    if(bg < 7){
                        bg = bg + 1;
                    } else {
                        bg = 1;
                    }


                });

                var total_site =    '<div class="col-2 border">' +          
                                    '<div class="milestone-bg bg_img_' + (bg) + '" style=""></div>' +
                                    '<div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">' +
                                        '<div class="widget-numbers mt-1">'+ json.data.length + '</div>' +
                                        '<div class="widget-subheading">Total Site</div>' +
                                    '</div>' +
                                '</div>';

                $(document).find('#dashboard_counters_options').append(total_site);

            }
              

        }); 


    // $('#DTsearch').on( 'keyup', function () {
    //     XDT.search( this.value ).draw();
    // } );

        return dt;

    
    
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

                makeDT(activeTable, cols, active_program);

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