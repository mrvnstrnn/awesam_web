$(document).ready(() => {
    var program_lists = [];

    var program_list = JSON.parse($("#program_lists").val());

    for (let i = 0; i < program_list.length; i++) {
        program_lists.push(program_list[i].program.replace(" ", "-").toLowerCase());
    }

    if(program_lists.length >= 1){
        $('#new-endoresement-'+program_lists[0]+'-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('#new-endoresement-'+program_lists[0]+'-table').attr('data-href'),
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
                $(row).attr('data-program', program_lists[0]);
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
            ],
        });
    }
    // }

    $(".nav-link.new-endoresement").on("click", function(){
        if ( ! $.fn.DataTable.isDataTable('#new-endoresement-'+$(this).attr("data-program")+'-table') ) {
            $('#new-endoresement-'+$(this).attr("data-program")+'-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: $('#new-endoresement-'+$(this).attr("data-program")+'-table').attr('data-href'),
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
                    $(row).attr('data-program', $(this).attr("data-program"));
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
                ],
            });
        }
    });
      
    $('.new-endorsement-table').on( 'click', 'tr td:not(:first-child)', function (e) {
        e.preventDefault();
        // var json_parse = JSON.parse($(this).attr("data-site"));
        var json_parse = JSON.parse($(this).parent().attr('data-site'));
        $(".btn-accept-endorsement").attr('data-program', $(this).parent().attr('data-program'));

        allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"];

        $(".content-data .position-relative.form-group").remove();

        var new_json = JSON.parse(json_parse.site_fields.replace(/&quot;/g,'"'));

        for (let i = 0; i < new_json.length; i++) {
            if(allowed_keys.includes(new_json[i].field_name)){
                $(".content-data").append(
                    '<div class="position-relative form-group col-md-6">' +
                        '<label for="' + new_json[i].field_name.toLowerCase() + '" style="font-size: 11px;">' +  new_json[i].field_name + '</label>' +
                        '<input class="form-control"  value="'+new_json[i].field_name+'" name="' + new_json[i].field_name.toLowerCase() + '"  id="'+new_json[i].field_name.toLowerCase()+'" >' +
                    '</div>'
                );
            }
        }

        $(".modal-title").text(json_parse.site_name);
        $(".btn-accept-endorsement").attr('data-sam_id', json_parse.sam_id);
        $("#modal-endorsement").modal("show");
    } );

    $(".checkAll").click(function(e){
        e.preventDefault();
        var val = $(this).val();
        $('input[name='+val+']').not(this).prop('checked', this.checked);
    });

    $(".btn-accept-endorsement").click(function(e){
        e.preventDefault();
        // $("#loaderModal").modal("show");

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');

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
                    $("#new-endoresement-"+data_program.replace(" ", "-")+"-table").DataTable().ajax.reload(function(){
                        $("#modal-endorsement").modal("hide");
                        toastr.success(resp.message, 'Success');
                        // $("#loaderModal").modal("hide");
                    });
                } else {
                    // $("#loaderModal").modal("hide");
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                // $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
            }
        });

    });

    $(".btn-bulk-acceptreject-endorsement").click(function(e){
        e.preventDefault();
        // $("#loaderModal").modal("show");


        var sam_id = $(this).attr('data-sam_id');
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');

        var data_id = $(this).attr('data-id');
        var inputElements = document.getElementsByName('program'+data_id);

        var id = $(this).attr('id');

        var text = id == "reject"+data_program.replace(" ", "-") ? "Reject" : "Endorse New Sites";

        $("#"+id).attr("disabled", "disabled");
        $("#"+id).text("Processing...");

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
                    $("#new-endoresement-"+data_program.replace(" ", "-")+"-table").DataTable().ajax.reload(function(){
                        $("#modal-endorsement").modal("hide");
                        // $("#loaderModal").modal("hide");
                        toastr.success(resp.message, 'Success');

                        $("#"+id).removeAttr("disabled");
                        $("#"+id).text(text);
                    });
                    // $("#modal-endorsement").modal("hide");
                    // $("#loaderModal").modal("hide");
                    // toastr.success(resp.message, 'Success');
                } else {
                    // $("#loaderModal").modal("hide");
                    toastr.error(resp.message, 'Error');
                    $("#"+id).removeAttr("disabled");
                    $("#"+id).text(text);
                }
            },
            error: function(resp){
                // $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
                $("#"+id).removeAttr("disabled");
                $("#"+id).text(text);
            }
        });

    });
    

});