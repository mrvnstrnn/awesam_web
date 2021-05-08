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
                $(row).attr('id', data.sam_id);
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

        console.log(data_endorsement);

        // console.log(Object.keys(JSON.parse(data_endorsement)).length);

        allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"]

        $(".content-data").append(
            "<H1>" + $(".modal-title").text().replace(" ","_") + "</H1>"
        );

        for (const [key, value] of Object.entries(JSON.parse(data_endorsement))) {

            // console.log(key + ": " + value);

            if(allowed_keys.includes(key) > 0){
                $(".content-data").append(

                    '<div class="position-relative form-group">' +
                        '<label for="' + key.toLowerCase() + '" style="font-size: 11px;">' +  key + '</label>' +
                        '<input class="form-control"  value="'+value+'" name="' + key.toLowerCase() + '"  id="'+key.toLowerCase()+'" >' +
                    '</div>'

                );
            }
        }

        $("#btn-accept-endorsement").attr('data-sam_id', $(".modal-title").text() );

        $("#modal-endorsement").modal("show");
        $('#modal-endorsement').modal('handleUpdate')

    });

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("#btn-accept-endorsement").click(function(){

        $("#" + $("#btn-accept-endorsement").attr('data-sam_id')  ).remove();
        $(".content-data").html('');
        $("#modal-endorsement").modal('hide');

    });
    

});