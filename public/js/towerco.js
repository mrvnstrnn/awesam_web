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

        var ctr = 1;
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
                url: '/save-towerco-multi/',
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


            },

            error: function (resp) {
                console.log(resp);
            }

        });
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

        var table = $('#towerco-table').DataTable();

        table.ajax.url( '/get-towerco/' ).load();
    });
    

});
