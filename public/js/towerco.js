$(document).ready(() => {

    var whatTable = $('#towerco-table');

    // TOWERCO TABLE

    $(whatTable).DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        filter: true,
        searching: true,
        lengthChange: true,
        select: true,
        dom: 'Bfrtip',

        regex: true,
        ajax: {
            url: $(whatTable).attr('data-href'),
            type: 'GET',

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        
        language: {
            "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Loading...</strong></div>",
        },
        
        dataSrc: function(json){
            return json.data;
        },


        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-serial_number', row['Serial Number']);
        },
        
        columns: [
            {data: null, render: function(){ return '<i class="site-add fa fa-fw fa-lg" aria-hidden="true"></i>';}},
            {data: 'Search Ring',
            render: function (data, type, row, meta) {
                return '<strong>' + data + '</strong><div class="selected-sn">' + row['Serial Number'] + '</div>'; }
            },
            {data: 'TOWERCO'},
            {data: 'PROJECT TAG'},
            {data: 'MILESTONE STATUS'},
            {data: 'REGION', 
            render: function (data, type, row, meta) {
                return data + ' > ' + row['PROVINCE']; }},
            {data: 'OFF-GRID/GOOD GRID'},
            {data: 'TSSR STATUS'},
        ],
        columnDefs: [
            {'max-width': '10px', 'targets': 2},
            {'text-overflow': 'ellipsis', 'targets': 2},
        ],
        

    }); 

    // MULTIPLE SITES

    $(document).on('click', '.site-add', function(){

        var table = $('#towerco-table').DataTable();


            var active_tr = $(this).closest('tr');
            $(active_tr).toggleClass('selected');
            
            $(this).closest('td').html('<i class="site-added fa fa-fw fa-lg" aria-hidden="true" ></i>'); 


            if(table.rows('.selected').data().length > 1){
                $('.update-button').removeClass('d-none');
                $('.export-button').addClass('d-none');
                $('.show-filters').addClass('d-none');                
                $('.update-button').find('span').text(table.rows('.selected').data().length);    
            } else {
                $('.export-button').removeClass('d-none');
                $('.show-filters').removeClass('d-none');
            }
    });

    $(document).on('click', '.site-added', function(){

        var table = $('#towerco-table').DataTable();
    

        var active_tr = $(this).closest('tr');
        $(active_tr).toggleClass('selected');

        $(this).closest('td').html('<i class="site-add fa fa-fw fa-lg" aria-hidden="true"></i>');
        $(this).closest('tr').addClass('tr-site-added');
        
        if(table.rows('.selected').data().length > 1){
            $('.update-button').find('span').text(table.rows('.selected').data().length);
            $('.export-button').addClass('d-none');
            $('.show-filters').addClass('d-none');


        } else {
            $('.update-button').addClass('d-none');
            $('.export-button').removeClass('d-none');
            $('.show-filters').removeClass('d-none');

        }
    });

    $('.update-button').on('click', function(e){

        var table = $('#towerco-table').DataTable();
        
        e.preventDefault();
        $('#towerco_multi').modal('show');

        $('#tab-towerco-actor-multi').html('');
        // $('#tab-towerco-sites-multi').html('');

        $.ajax({
            url: "/get-towerco-multi/"+actor,
            method: 'GET',
            async: false,

            success: function (resp) {
                $('#tab-towerco-actor-multi').html(resp.actor);

                flatpickr(".flatpicker");
                $('.flatpicker').css('background', '#ffffff');

                $('.actor_update').attr('data-actor', actor);

            },

            error: function (resp) {
                console.log(resp);
            }

        });
        
        $('#selected-sites tbody').empty();
        $('#form-towerco-actor-multi td[name="Serial Number[]"]').remove();   // Matches exactly 'tcol1'

        var ctr = 0;
        table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var row = $(this.node());
            if($(row).hasClass('selected')){

                var sn = $(row).find('.selected-sn').text();
                var sr = $(row).find(':first-child').text().replace('','');
                var tw = $(row).find(':nth-child(3)').text();

                $('#form-towerco-actor-multi').append('<input type="hidden" name="Serial Number[]" value="' + sn + '" />')

                $('#selected-sites tbody').append('<tr><td>' + tw +'</td><td>' + sn + '</td><td>' + sr + '</td></tr>');
                ctr = ctr + 1;

            }
            // ... do something with data(), or this.node(), etc
        } );

    });

    
    $(document).on('click', '.actor_update_multi', function(){

        var loader = '<i class="fa fa-fw" aria-hidden="true"></i> Saving...';
        $(this).html(loader);

        try{
            $.ajax({
                url: '/save-towerco-multi',
                method: 'POST',
                data: $('#form-towerco-actor-multi').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    $('.actor_update_multi').text('Update Sites');
                    $('.update-button').addClass('d-none');
                    $('#towerco_multi').modal('hide');
                    $("#towerco-table").DataTable().ajax.reload();   
                    $('.export-button').removeClass('d-none');
                    $('.show-filters').removeClass('d-none');

                    $('#tab-towerco-actor-multi').html('');
                    $('#selected-sites body').empty();
                    $('#form-towerco-actor-multi').empty();

                    Swal.fire(
                        'Success', 'Sites Updated','success'
                    ); 
                }
            });
        } catch (error) {
            console.error(error);
        }
    });


    // SINGLE SITE

    $('.assigned-sites-table').on('click', 'tbody tr td:not(:first-child)', function(e){
        

        e.preventDefault();
        $('#towerco_details').modal('show');
        var active_tr = $(this).closest('tr');
        var serial_number = $(active_tr).find('td:nth-child(2)').find('.selected-sn').text();

        $('#towerco_details').find('.modal-title').html('<i class="pe-7s-map-marker pe-lg mr-2"></i>' + serial_number);

        $('#tab-towerco-details').html('');
        $('#tab-towerco-actor').html('');
        $('#tab-towerco-logs').html('');

        $("#serial_number").val(serial_number);

        $.ajax({
            url: "/get-towerco/"+serial_number+'/'+actor,
            method: 'GET',
            async: false,

            success: function (resp) {

                $('#tab-towerco-details').html(resp.details);
                $('#tab-towerco-actor').html(resp.actor);

                flatpickr(".flatpicker");
                $('.flatpicker').css('background', '#ffffff');

                $('.actor_update').attr('data-serial', serial_number);
                $('.actor_update').attr('data-actor', actor);

                var xTable =  '<table id="table-towerco-logs" class="table" style="width: 100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>Field</th>' +
                                '<th>OLD</th>' +
                                '<th>NEW</th>' +
                                '<th>User</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        '</tbody>' +
                    '</table>';                   

                $('#tab-towerco-logs').html(xTable);


                $('#table-towerco-logs').DataTable({
                    responsive: true,
                    ajax: {
                        type: 'GET',
                        url: '/get-towerco-logs/' + serial_number,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    
                    columns: [
                        {
                            data: 'field', 
                            render: function(data, type, row, meta){
                                return data + '<br><small>' + row.add_timestamp +'</small>';
                            }
                        },
                        {data: 'old_value'},
                        {data: 'new_value'},
                        {
                            data: 'name', 
                            render: function(data, type, row, meta){
                                return data + '<br><small>' + row.user_group +'</small>';
                            }
                        },                    ],

                }); 

                htmllist = '<div class="table-responsive table_uploaded_parent my-3">' +
                    '<table class="table_uploaded_tssr align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                        '<thead>' +
                            '<tr>' +
                                '<th style="width: 20%;">Date</th>' +
                                '<th>Filename</th>' +
                                '<th style="width: 20%;">Uploaded By</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>' +
                '</div>';

                $('.file_viewer_tssr_list').html(htmllist);
                $(".table_uploaded_tssr").attr("id", "table_uploaded_tssr_files_"+serial_number);

                htmllisttb = '<div class="table-responsive table_uploaded_parent my-3">' +
                    '<table class="table_uploaded_rtb align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                        '<thead>' +
                            '<tr>' +
                                '<th style="width: 20%;">Date</th>' +
                                '<th>Filename</th>' +
                                '<th style="width: 20%;">Uploaded By</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>' +
                '</div>';

                $('.file_viewer_rtb_list').html(htmllisttb);
                $(".table_uploaded_rtb").attr("id", "table_uploaded_rtb_files_"+serial_number);

                if (! $.fn.DataTable.isDataTable("#table_uploaded_tssr_files_"+serial_number) ){
                    $("#table_uploaded_tssr_files_"+serial_number).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/get-my-towerco-file/"+serial_number+"/tssr",
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        dataSrc: function(json){
                            return json.data;
                        },
                        'createdRow': function( row, data, dataIndex ) {
                            $(row).attr('data-file_name', data.file_name);
                            $(row).attr('data-id', data.id);
                            $(row).attr('data-serial_number', data.serial_number);
                            $(row).attr('style', 'cursor: pointer');
                        },
                        columns: [
                            { data: "date_uploaded" },
                            { data: "file_name" },
                            { data: "uploaded_by" },
                        ],
                    });

                    $("#table_uploaded_rtb_files_"+serial_number).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/get-my-towerco-file/"+serial_number+"/rtb",
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        dataSrc: function(json){
                            return json.data;
                        },
                        'createdRow': function( row, data, dataIndex ) {
                            $(row).attr('data-file_name', data.file_name);
                            $(row).attr('data-id', data.id);
                            $(row).attr('data-serial_number', data.serial_number);
                            $(row).attr('style', 'cursor: pointer');
                        },
                        columns: [
                            { data: "date_uploaded" },
                            { data: "file_name" },
                            { data: "uploaded_by" },
                        ],
                    });
                } else {
                    $("#table_uploaded_tssr_files_"+serial_number).DataTable().ajax.reload();
                    $("#table_uploaded_rtb_files_"+serial_number).DataTable().ajax.reload();
                }


            },

            error: function (resp) {
                console.log(resp);
            }

        });
    });

    $(document).on("click", ".table_uploaded_tssr tr", function(e){
        e.preventDefault();

        var extensions = ["pdf", "jpg", "png"];

        var file_name = $(this).attr('data-file_name');

        if( extensions.includes(file_name.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + file_name + '" allowfullscreen></iframe><button class="btn btn-shadow btn-sm btn-secondary my-3 back_to_list_tssr">Back to list</button>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + file_name + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div><button class="btn btn-shadow btn-sm btn-secondary my-3 back_to_list_tssr">Back to list</button>';
        }

        $('.file_viewer_tssr_list').addClass('d-none');

        $('.file_viewer_tssr').html('');
        $('.file_viewer_tssr').html(htmltoload);
    });

    $(document).on("click", ".table_uploaded_rtb tr", function(e){
        e.preventDefault();

        var extensions = ["pdf", "jpg", "png"];

        var file_name = $(this).attr('data-file_name');

        if( extensions.includes(file_name.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + file_name + '" allowfullscreen></iframe><button class="btn btn-shadow btn-sm btn-secondary my-3 back_to_list_rtb">Back to list</button>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + file_name + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div><button class="btn btn-shadow btn-sm btn-secondary my-3 back_to_list_rtb">Back to list</button>';
        }

        $('.file_viewer_rtb_list').addClass('d-none');

        $('.file_viewer_rtb').html('');
        $('.file_viewer_rtb').html(htmltoload);
    });

    $(document).on('click', '.back_to_list_tssr', function(){
        $('.file_viewer_tssr_list').removeClass('d-none');
        $('.file_viewer_tssr').html('');
    });

    $(document).on('click', '.back_to_list_rtb', function(){
        $('.file_viewer_rtb_list').removeClass('d-none');
        $('.file_viewer_rtb').html('');
    });

    $(document).on('click', '.actor_update', function(){
        $.ajax({
            url: '/save-towerco/',
            method: 'POST',
            data: $('#form-towerco-actor').serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                Swal.fire(
                    'Success', resp.message,'success'
                );
                $('#towerco_details').modal('hide');
                
                $("#towerco-table").DataTable().ajax.reload();


            }
        });
    });

    // EXPORT
    $(document).on('click', '.export-button', function(){
        $('#towerco_export').modal('show');
    });
    
    $(document).on('click', '.actor_export_download', function(){
        window.open('/get-towerco/export', 'export'); 
        $('#towerco_export').modal('hide');
    });    

    // AUTO VALUE
    $(document).on('change', 'input[name="Tower Co TSSR Submission Date to GT"]',function(){
            $('select[name="TSSR STATUS"]').val('SUBMITTED');
    });

    // FILTERS

    $(document).on('click', '.close-filters', function(){
        $('#filters-box').addClass('d-none');
    });

    $(document).on('click', '.show-filters', function(){
        $('#filters-box').toggleClass('d-none');
    });

    $(document).on('click', '.filter-records', function(){

        var tf = $('#towerco-filters-form').serialize();

        var two = $('select[name="region"]').val();
        var three = $('select[name="tssr_status"]').val();
        var four = $('select[name="milestone_status"]').val();
        var five = $('input[name="actor"]').val();

        if (five != 'TowerCo') {
            var one = $('select[name="towerco"]').val();
        } else {
            var one = '-';
        }

        var table = $('#towerco-table').DataTable();


        table.ajax.url( '/get-towerco-filter/' + one + '/' + two + '/' + three + '/' + four + '/' + five ).load();
    });
    

});
