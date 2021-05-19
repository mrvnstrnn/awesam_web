
$(document).ready(() => {

    var program_lists = [
        'coloc',
        'ftth',
        'renewal',
    ];

    
    /////////////////////////////////////
    //                                 //  
    //   A S S I G N E D   S I T E S   //
    //                                 //  
    /////////////////////////////////////

    for (let i = 0; i < program_lists.length; i++) {
        $('#agent-'+program_lists[i]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#agent-'+program_lists[i]+'-table').attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            // 'createdRow': function( row, data, dataIndex ) {
            //     $(row).attr('data-site', JSON.stringify(data));
            //     $(row).attr('data-program', program_lists[i]);
            //     $(row).attr('data-id', data.sam_id);
            //     $(row).addClass('modalDataUnassigned'+data.sam_id);
            //     $(row).addClass('modalDataEndorsement');
            // },
            columnDefs: [{
                "targets": 0,
                "orderable": false
            }],
            columns: [
                { data: "photo" },
                { data: "firstname" },
                { data: "lastname" },
                { data: "email" },
                { data: "null" },
            ],
        });
    }


    /////////////////////////////////////
    //                                 //  
    // U N A S S I G N E D   S I T E S //
    //                                 //  
    /////////////////////////////////////


    for (let i = 0; i < program_lists.length; i++) {
        $('#unasigned-'+program_lists[i]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#unasigned-'+program_lists[i]+'-table').attr('data-href'),
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
                $(row).attr('data-program', program_lists[i]);
                $(row).attr('data-id', data.sam_id);
                $(row).addClass('modalDataUnassigned'+data.sam_id);
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
    }

    $('.unasigned-table').on( 'click', 'tr td:first-child', function (e) {
        e.preventDefault();
        $("#btn-assign-sites").attr('data-id', $(this).parent().attr('data-id'));
        $("#btn-assign-sites").attr('data-program', $(this).parent().attr('data-program'));
        $("#sam_id").val($(this).parent().attr('data-id'));
        $("#modal-assign-sites").modal("show");
    });

    $(document).on('click',"#btn-assign-sites", function(e){
        e.preventDefault();

        $(this).attr('disabled', 'disabled');
        $(this).text('Processing...');
        var data_program = $(this).attr('data-program');

        $.ajax({
            url: $(this).attr('data-href'),
            data: $("#agent_form").serialize(),
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#btn-assign-sites").removeAttr('disabled');
                    $("#btn-assign-sites").text('Assign');
                    $("#unasigned-"+data_program.replace(" ", "-")+"-table").DataTable().ajax.reload(function(){
                        $("#modal-assign-sites").modal("hide");
                        toastr.success(resp.message, 'Success');
                    });
                } else {
                    $("#btn-assign-sites").removeAttr('disabled');
                    $("#btn-assign-sites").text('Assign');
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                $("#btn-assign-sites").removeAttr('disabled');
                $("#btn-assign-sites").text('Assign');
                toastr.error(resp.message, 'Error');
            }
        });
    });
      

    /////////////////////////////////////
    //                                 //  
    //           E N D   O F           //  
    // U N A S S I G N E D   S I T E S //
    //                                 //  
    /////////////////////////////////////



    /////////////////////////////////////
    //                                 //  
    // N E W   E N D O R S E M E N T S //
    //                                 //  
    /////////////////////////////////////



    for (let i = 0; i < program_lists.length; i++) {
        $('#new-endoresement-'+program_lists[i]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#new-endoresement-'+program_lists[i]+'-table').attr('data-href'),
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
                $(row).attr('data-program', program_lists[i]);
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
    }

    $('.new-endorsement-table').on( 'click', 'tr td:not(:first-child)', function (e) {
        e.preventDefault();
        // var json_parse = JSON.parse($(this).attr("data-site"));
        var json_parse = JSON.parse($(this).parent().attr('data-site'));
        $(".btn-accept-endorsement").attr('data-program', $(this).parent().attr('data-program'));

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

    $("#checkAll").click(function(e){
        e.preventDefault();
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(".btn-accept-endorsement").click(function(e){
        e.preventDefault();
        $("#loaderModal").modal("show");

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');

        // var program_div = "";

        // if (data_program == 'coloc'){
        //     program_div = '#new-endoresement-coloc-table';
        // } else if (data_program == 'ffth'){
        //     program_div = '#new-endoresement-ffth-table';
        // } else if (data_program == 'ibs'){
        //     program_div = '#new-endoresement-ibs-table';
        // } else if (data_program == 'mwan'){
        //     program_div = '#new-endoresement-mwan-table';
        // } else if (data_program == 'new sites'){
        //     program_div = '#new-endoresement-new-sites-table';
        // } else if (data_program == 'towerco'){
        //     program_div = '#new-endoresement-towerco-table';
        // }

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
                        $("#loaderModal").modal("hide");
                    });
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


    $(".btn-bulk-acceptreject-endorsement").click(function(e){
        e.preventDefault();
        $("#loaderModal").modal("show");

        var sam_id = $(this).attr('data-sam_id');
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');

        // var program_div = "";

        // if (data_program == 'coloc'){
        //     program_div = '#new-endoresement-coloc-table';
        // } else if (data_program == 'ffth'){
        //     program_div = '#new-endoresement-ffth-table';
        // } else if (data_program == 'ibs'){
        //     program_div = '#new-endoresement-ibs-table';
        // } else if (data_program == 'mwan'){
        //     program_div = '#new-endoresement-mwan-table';
        // } else if (data_program == 'new sites'){
        //     program_div = '#new-endoresement-new-sites-table';
        // } else if (data_program == 'towerco'){
        //     program_div = '#new-endoresement-towerco-table';
        // }

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
                    $("#new-endoresement-"+data_program.replace(" ", "-")+"-table").DataTable().ajax.reload(function(){
                        $("#modal-endorsement").modal("hide");
                        $("#loaderModal").modal("hide");
                        toastr.success(resp.message, 'Success');
                    });
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

    /////////////////////////////////////
    //                                 //  
    //           E N D   O F           //  
    // N E W   E N D O R S E M E N T S //
    //                                 //  
    /////////////////////////////////////



    
});