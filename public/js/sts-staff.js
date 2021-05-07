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
                // $(row).attr('data-endorsement', JSON.parse(data.site_fields.replace(/&quot;/g,'"')));
                $(row).attr('data-title', data.sam_id);
                $(row).attr('data-endorsement', JSON.stringify(JSON.parse(data.site_fields.replace(/&quot;/g,'"'))));
                $(row).addClass('modalDataEndorsement');
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                { data: 'site_endorsement_date', name: 'site_endorsement_date' },
                { data: 'sam_id', name: 'sam_id' },
                { data: 'site_name', name: 'site_name' },
                { data: 'technology', name: 'technology', className: "text-center"},
                { data: 'pla_id', name: 'pla_id' },
            ]
        });
    });

    $('table').find('tbody').on('click','.modalDataEndorsement td:not(:first-child)',function(){
        $(".content-data .appendData").remove();
        $(".modal-title").text($(this)[0].parentElement.attributes[0].nodeValue);
        var data_endorsement = $(this)[0].parentElement.attributes[1].nodeValue;
        // console.log(Object.keys(JSON.parse(data_endorsement)).length);

        for (const [key, value] of Object.entries(JSON.parse(data_endorsement))) {
            // console.log(key, value);
            $(".content-data").append('<div class="appendData"><b>' + key + '</b> : <span>' + value + '</span></div>');
        }
        $("#modal-endorsement").modal("show");
    });

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    

});