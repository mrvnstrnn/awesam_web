$(document).ready(() => {
    var program_lists = [];

    var program_list = JSON.parse($("#program_lists").val());

    for (let i = 0; i < program_list.length; i++) {
        program_lists.push(program_list[i].program.replace(" ", "-").toLowerCase());
    }

    for (let i = 0; i < program_lists.length; i++) 
    {
        
        $.ajax({
            type: "GET", /* You could use GET if the server support it */
            url: $('#agent-'+program_lists[i]+'-table').attr('data-href'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data)
            {
                // Log the data to check the structure.
                var obj = data.data[0];

                var whatColumns = [];

                for (const [key, value] of Object.entries(obj)) {
                    var tempCol = ( {data: key} );
                    whatColumns.push(tempCol);
                }

                $('#agent-'+program_lists[i]+'-table').DataTable({
                    processing: true,
                    data: data.data,
                    columns: whatColumns
                });
            },
            error: function()
            {
                alert('Failed to get data from server');
            }
        });

    }
});