$(document).ready(() => {

    profile_id = 6;
    
    // $.get( "/api/new-endorsements/" + profile_id, function( sites ) {

    //     var dataSet = [];

    //     sites.forEach(function(site){

    //         var row_columns = [];

    //         // Site Columns
    //         row_columns.push(site['site_endorsement_date']);
    //         row_columns.push(site['sam_id']);
    //         row_columns.push(site["site_name"]);

    //         // Site Fields Columns
    //         row_columns.push(site['site_fields'][0]['TECHNOLOGY']);
    //         row_columns.push(site['site_fields'][0]['PLA_ID']);

    //         dataSet.push(row_columns);
        
    //     });

    //     $('#new-endoresement-coloc-table').DataTable( {
    //         data: dataSet,
    //         responsive: true,
    //         columns: [
    //             { title: "Endorsement Date" },
    //             { title: "SAM ID" },
    //             { title: "Site Name" },
    //             { title: "Technology" },
    //             { title: "PLA ID" }
    //         ],

    //         'createdRow': function( row, dataSet, dataIndex ) {
    //             $(row).attr('id', dataSet[1]);
    //             $(row).attr('data-site_name', dataSet[2]);
    //         },
          
    
    //     } );    

    //     // console.log(dataSet[0][5]);

    // });

    $('#new-endoresement-coloc-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#new-endoresement-coloc-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                // $("#loaderModal").modal("show");
            },
            complete: function(){
                // $("#loaderModal").modal("hide");
            }
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-site', JSON.stringify(data));
            $(row).addClass('modalDataEndorsement');
        },
        columnDefs: [{
            "targets": 0,
            "orderable": false
        }],
        columns: [
            { data: "checkbox" },
            { data: "site_endorsement_date" },
            { data: "sam_id" },
            { data: "site_name" },
            { data: "technology" },
            { data: "pla_id" }
        ],
    });  

    $('#new-endoresement-ibs-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#new-endoresement-ibs-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-site', JSON.stringify(data));
            $(row).addClass('modalDataEndorsement');
        },
        columnDefs: [{
            "targets": 0,
            "orderable": false
        }],
        columns: [
            { data: "checkbox" },
            { data: "site_endorsement_date" },
            { data: "sam_id" },
            { data: "site_name" },
            { data: "technology" },
            { data: "pla_id" }
        ],
    });  
      
    $('.new-endorsement-table').on( 'click', 'tr td:not(:first-child)', function () {
        // var json_parse = JSON.parse($(this).attr("data-site"));
        var json_parse = JSON.parse($(this).parent().attr('data-site'));

        allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"];

        $(".content-data .position-relative.form-group").remove();

        Object.entries(json_parse.site_fields).forEach(([key, value]) => {
            Object.entries(value).forEach(([keys, values]) => {
                if(allowed_keys.includes(keys) > 0){
                    $(".content-data").append(
                        '<div class="position-relative form-group col-md-6">' +
                            '<label for="' + keys.toLowerCase() + '" style="font-size: 11px;">' +  keys + '</label>' +
                            '<input class="form-control"  value="'+values+'" name="' + keys.toLowerCase() + '"  id="'+key.toLowerCase()+'" >' +
                        '</div>'
                    );
                }
            });
        });

        $(".modal-title").text(json_parse.site_name);
        $(".btn-accept-endorsement").attr('data-sam_id', json_parse.sam_id);
        $("#modal-endorsement").modal("show");
    } );

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(".btn-accept-endorsement").click(function(){
        $("#loaderModal").modal("show");

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');

        $.ajax({
            url: $(this).attr('data-href'),
            data: {
                sam_id : sam_id,
                data_complete : data_complete
            },
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $('.new-endorsement-table').DataTable().ajax.reload();
                    $("#modal-endorsement").modal("hide");
                    toastr.success(resp.message, 'Success');
                    $("#loaderModal").modal("hide");
                } else {
                    $("#loaderModal").modal("hide");
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
            }
        });

    });

    $(".btn-bulk-acceptreject-endorsement").click(function(){
        $("#loaderModal").modal("show");

        var sam_id = $(this).attr('data-sam_id');
        var data_complete = $(this).attr('data-complete');

        var inputElements = document.getElementsByClassName('checkbox-new-endorsement');

        sam_id = [];
        for(var i=0; inputElements[i]; ++i){
            if(inputElements[i].checked){
                sam_id.push(inputElements[i].value);
            }
        }

        $.ajax({
            url: $(this).attr('data-href'),
            data: {
                sam_id : sam_id,
                data_complete : data_complete
            },
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $('.new-endorsement-table').DataTable().ajax.reload();
                    $("#modal-endorsement").modal("hide");
                    $("#loaderModal").modal("hide");
                    toastr.success(resp.message, 'Success');
                } else {
                    $("#loaderModal").modal("hide");
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
            }
        });

    });
    

});