$(document).ready(() => {
    var program_lists = [
        'coloc',
        'ftth',
        'ibs',
        'mwan',
        'new-sites',
        'towerco',
        'renewal',
        'wireless',
    ];

    for (let i = 0; i < program_lists.length; i++) {
        console.log('#workflow-'+program_lists[i]+'-table');
        $(function() {
            $('#workflow-'+program_lists[i]+'-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: $('#workflow-'+program_lists[i]+'-table').attr('data-href'),
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(){
                        
                    },
                    complete: function(){
                        
                    }
                },
                dataSrc: function(json){
                    return json.data;
                },
                columns: [
                    { data: 'activity_duration_days', name: 'activity_duration_days' },
                    { data: 'activity_name', name: 'activity_name' },
                    { data: 'activity_sequence', name: 'activity_sequence' },
                    { data: 'activity_type', name: 'activity_type' },
                ]
            });
        });
    }
    
});