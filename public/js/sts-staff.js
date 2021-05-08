$(document).ready(() => {

    profile_id = 6;
    
    $.get( "/api/new-endorsements/" + profile_id, function( sites ) {

        var dataSet = [];

        sites.forEach(function(site){

            var row_columns = [];

            // Site Columns
            row_columns.push(site['site_endorsement_date']);
            row_columns.push(site['sam_id']);
            row_columns.push(site["site_name"]);

            // Site Fields Columns
            row_columns.push(site['site_fields'][0]['TECHNOLOGY']);
            row_columns.push(site['site_fields'][0]['PLA_ID']);

            dataSet.push(row_columns);
        
        });

        $('#new-endoresement-table').DataTable( {
            data: dataSet,
            responsive: true,

            columns: [
                { title: "Endorsement Date" },
                { title: "SAM ID" },
                { title: "Site Name" },
                { title: "Technology" },
                { title: "PLA ID" }
            ],

            'createdRow': function( row, dataSet, dataIndex ) {
                $(row).attr('id', dataSet[1]);
                $(row).attr('data-site_name', dataSet[2]);
            },
          
    
        } );    

        console.log(dataSet[0][5]);

    });
      
    $('#new-endoresement-table tbody').on( 'click', 'tr', function () {

        $("#modal-endorsement").modal("show");
        $(".modal-title").text($(this).attr("data-site_name"));

        console.log($(this)[0]);
    } );



    // $('#new-endoresement-table tbody').find('tbody').on('click','.modalDataEndorsement td:not(:first-child)',function(){
    //     $(".content-data .appendData").remove();
    //     $(".modal-title").text($(this)[0].parentElement.attributes[0].nodeValue);
    //     var data_endorsement = $(this)[0].parentElement.attributes[1].nodeValue;

    //     console.log(data_endorsement);

    //     // console.log(Object.keys(JSON.parse(data_endorsement)).length);

    //     allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"]

    //     $(".content-data").append(
    //         "<H1>" + $(".modal-title").text().replace(" ","_") + "</H1>"
    //     );

    //     for (const [key, value] of Object.entries(JSON.parse(data_endorsement))) {

    //         // console.log(key + ": " + value);

    //         if(allowed_keys.includes(key) > 0){
    //             $(".content-data").append(

    //                 '<div class="position-relative form-group">' +
    //                     '<label for="' + key.toLowerCase() + '" style="font-size: 11px;">' +  key + '</label>' +
    //                     '<input class="form-control"  value="'+value+'" name="' + key.toLowerCase() + '"  id="'+key.toLowerCase()+'" >' +
    //                 '</div>'

    //             );
    //         }
    //     }

    //     $("#btn-accept-endorsement").attr('data-sam_id', $(".modal-title").text() );

    //     $("#modal-endorsement").modal("show");
    //     $('#modal-endorsement').modal('handleUpdate')

    // });

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("#btn-accept-endorsement").click(function(){

        $("#" + $("#btn-accept-endorsement").attr('data-sam_id')  ).remove();
        $(".content-data").html('');
        $("#modal-endorsement").modal('hide');

    });
    

});