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
                    { data: 'activity_id', name: 'activity_id' },
                    { data: 'profile_id', name: 'profile_id' },
                    { data: 'activity_name', name: 'activity_name' },
                    { data: 'activity_type', name: 'activity_type' },
                    { data: 'next_activity', name: 'next_activity' },
                    { data: 'return_activity', name: 'return_activity' },
                    { data: 'activity_duration_days', name: 'activity_duration_days' },
                    { data: 'activity_sequence', name: 'activity_sequence' },
                    { data: 'stage_id', name: 'stage_id' },
                    { data: 'program_id', name: 'program_id' },
                ]
            });
        });
    }
    
});