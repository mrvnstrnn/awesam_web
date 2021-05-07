$(document).ready(() => {
    $(function() {
        $('#new-endoresement-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('#new-endoresement-table').attr('data-href'),
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
            'createdRow': function(row, data) {
                $(row).attr('data-endorsement', data.sam_id);
                $(row).addClass('modalDataEndorsement');
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                { data: 'sam_id', name: 'sam_id' },
                { data: 'site_name', name: 'site_name' },
                { data: 'technology', name: 'technology' },
                { data: 'PLA_ID', name: 'PLA_ID' },
            ]
        });
    });

    $('table').find('tbody').on('click','.modalDataEndorsement td:not(:first-child)',function(event){
        $(".modal-title").text($(this)[0].parentElement.attributes[0].nodeValue);
        $("#modal-endorsement").modal("show");
    });

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    

});