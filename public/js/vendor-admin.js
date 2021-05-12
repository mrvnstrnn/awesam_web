$(document).ready(() => {
    $('#for-verification-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#for-verification-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function(row, data) {
            $(row).attr('data-id', data.id);
            $(row).addClass('modalSetProfile');
        },
        columns: [
            { data: "name" },
            { data: "email" },
        ],
    });

});