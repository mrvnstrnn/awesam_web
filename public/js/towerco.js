$(document).ready(() => {

    var whatTable = $('#towerco-table');

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
            "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Loading...</strong></div>",
        },
        
        dataSrc: function(json){
            return json.data;
        },

        createdRow: function (row, data, dataIndex) {
        },
        
        columns: [
            {data: 'Serial Number'},
            {data: 'REGION'},
            {data: 'Search Ring'},
            {data: 'TOWERCO'},

        ],    

    }); 


    $('.assigned-sites-table').on('click', 'tbody tr', function(e){
        
        e.preventDefault();
        $('#towerco_details').modal('show');

        var serial_number = $(this).find('td:first').text();

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
                $('.actor_update').attr('data-actor', 'towerco');

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
                        },
                    ],

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
