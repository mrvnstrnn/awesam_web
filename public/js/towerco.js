$(document).ready(() => {

    var whatTable = $('#towerco-table');

    // TOWERCO TABLE

    if(actor == 'towerco'){

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
            },
            
            columns: [
                {data: null, render: function(){ return '<i class="site-add fa fa-fw fa-lg" aria-hidden="true"></i>';}},
                {data: 'Serial Number'},
                {data: 'REGION'},
                {data: 'Search Ring'},
            ],    

        }); 

    } else {
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
            },
            
            columns: [
                {data: null, render: function(){ return '<i class="site-add fa fa-fw fa-lg" aria-hidden="true"></i>';}},
                {data: 'Serial Number'},
                {data: 'REGION'},
                {data: 'Search Ring'},
                {data: 'TOWERCO'},
            ],    

        }); 

    }

    // MULTIPLE SITES

    $(document).on('click', '.site-add', function(){

        var table = $('#towerco-table').DataTable();


            var active_tr = $(this).closest('tr');
            $(active_tr).toggleClass('selected');
            
            $(this).closest('td').html('<i class="site-added fa fa-fw fa-lg" aria-hidden="true" ></i>'); 


            if(table.rows('.selected').data().length > 1){
                $('.update-button').removeClass('d-none');
                $('.export-button').addClass('d-none');
                $('.update-button').find('span').text(table.rows('.selected').data().length);    
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

        } else {
            $('.update-button').addClass('d-none');
            $('.export-button').removeClass('d-none');

        }
    });

    $('.update-button').on('click', function(e){

        var table = $('#towerco-table').DataTable();
        
        e.preventDefault();
        $('#towerco_multi').modal('show');

        $('#tab-towerco-actor-multi').html('');
        $('#tab-towerco-site-multi').html('');

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

        // $('#towerco-table tbody tr').each(function (){
        //     if($(this).hasClass('selected')){
        //         console.log($(this));
        //     }
        // })
        $('#selected-sites tbody').empty();
        table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var row = $(this.node());
            if($(row).hasClass('selected')){

                $('#selected-sites tbody').append('<tr>' + $(row).html() + '</tr>');
            }
            // ... do something with data(), or this.node(), etc
        } );

    });

    var ajax_load = "";

    
    $(document).on('click', '.actor_update_multi', function(){

        ajax_load = "actor_update_multi";

        var loader = '<i class="fa fa-fw" aria-hidden="true"></i> Saving...';
        $(this).html(loader);

        $('#selected-sites tbody tr').each(async function (){
            var active_serial = $(this).find('td:nth-child(2').text();

            $('#multi_serial').val(active_serial);
            let result;

            try{
                result = await $.ajax({
                    url: '/save-towerco/',
                    method: 'POST',
                    data: $('#form-towerco-actor-multi').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(resp){
                        console.log(resp);
                    }
                });
            } catch (error) {
                console.error(error);
            }
            
        });

    });

    $(document).ajaxStop(function() {

        if(ajax_load == 'actor_update_multi'){
            $('.actor_update_multi').text('Update Sites');
            $('.update-button').addClass('d-none');
            $('#towerco_multi').modal('hide');
            $("#towerco-table").DataTable().ajax.reload();    
            Swal.fire(
                'Success', 'Sites Updated','success'
            ); 
            ajax_load = "";
        }


    });

    // SINGLE SITE

    $('.assigned-sites-table').on('click', 'tbody tr td:not(:first-child)', function(e){
        

        e.preventDefault();
        $('#towerco_details').modal('show');
        var active_tr = $(this).closest('tr');
        var serial_number = $(active_tr).find('td:nth-child(2)').text();

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
    

});
