$(document).ready(() => {

    $(function() {
        $('#profile-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('#profile-table').attr('data-href'),
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
                { data: 'profile', name: 'profile' },
                { data: 'mode', name: 'mode' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#permission-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('#permission-table').attr('data-href'),
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
                { data: 'title', name: 'title' },
                { data: 'title_subheading', name: 'title_subheading' },
                { data: 'menu', name: 'menu' },
                { data: 'slug', name: 'slug' },
                { data: 'level_one', name: 'level_one' },
                { data: 'level_two', name: 'level_two' },
                { data: 'level_three', name: 'level_three' },
                { data: 'icon', name: 'icon' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

    $(document).on('click', '.edit_profile', function (){
        $(".profile_list .col-md-6").remove();
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'GET',
            success: function(resp){
                if(!resp.error){
                    console.log(resp.message);
                    resp.permissions.forEach(element => {
                        $(".profile_list").append(
                            '<div class="col-md-6"><input type="checkbox" name="profile_checkbox[]" class="form-check-input" id="permission'+element.id+'" value="'+element.id+'"><label class="form-check-label" for="permission'+element.id+'">'+element.title+'</label></div>'
                        );
                    });

                    resp.message.forEach(element => {
                        $('.profile_list input:checkbox').filter('[value='+element.id+']').prop('checked', true);
                    });

                    $("#hidden_id").val(resp.message[0].profile_id);
                    $("#profile_name").val(resp.message[0].profile);
                    $("#profileModal").modal('show');
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            },
        });
    });

    $(".update_pofile").on('click', function(){
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: $("#profile_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#profile_form")[0].reset();
                    $("#profileModal").modal('hide');
                    $('#profile-table').DataTable().ajax.reload();
                    toastr.success(resp.message, 'Success');
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $(document).on('click', '.edit_permission', function (){
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'GET',
            success: function(resp){
                if(!resp.error){
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index).val(data);
                        });
                    }
                    $("#permissionModal").modal('show');
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            },
        });
    });

    $(".addnewpermission_btn").on('click', function(){
        $("#permission_form")[0].reset();
        $("#permissionModal").modal("show");
    });

    $(".addupdate_permission").on('click', function(){
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: $("#permission_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#permission_form")[0].reset();
                    $("#permissionModal").modal('hide');
                    $('#permission-table').DataTable().ajax.reload();
                    toastr.success(resp.message, 'Success');
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $(document).on('click', '.delete_permission', function (){
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'GET',
            success: function(resp){
                if(!resp.error){
                    $("#hidden_permission_id").val(resp.message.id);
                    $("b.permission_name").text(resp.message.title);
                    $("#deletePermissionModal").modal('show');
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            },
        });
    });

    $(document).on('click', '.confirm_delete_permission', function (){
        var hidden_permission_id = $("#hidden_permission_id").val();
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: {
                hidden_permission_id : hidden_permission_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#hidden_permission_id").val();
                    $("b.permission_name").text(resp.message.title);
                    $("#deletePermissionModal").modal('hide');
                    $('#permission-table').DataTable().ajax.reload();
                    toastr.success(resp.message, 'Success');
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            },
        });
    });

});

$(document).ready(() => {
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
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-site', JSON.stringify(data));
            $(row).attr('data-program', 'coloc');
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
    
    $('#new-endoresement-ffth-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#new-endoresement-ffth-table").attr('data-href'),
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
            $(row).attr('data-program', 'coloc');
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
            $(row).attr('data-program', 'ibs');
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

    $('#new-endoresement-mwan-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#new-endoresement-mwan-table").attr('data-href'),
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
            $(row).attr('data-program', 'ibs');
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

    $('#new-endoresement-new-sites-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#new-endoresement-new-sites-table").attr('data-href'),
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
            $(row).attr('data-program', 'ibs');
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
    
    $('#new-endoresement-towerco-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#new-endoresement-towerco-table").attr('data-href'),
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
            $(row).attr('data-program', 'ibs');
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

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(".btn-accept-endorsement").click(function(){
        $("#loaderModal").modal("show");

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');

        var program_div = "";

        if (data_program == 'coloc'){
            program_div = '#new-endoresement-coloc-table';
        } else if (data_program == 'ffth'){
            program_div = '#new-endoresement-ffth-table';
        } else if (data_program == 'ibs'){
            program_div = '#new-endoresement-ibs-table';
        } else if (data_program == 'mwan'){
            program_div = '#new-endoresement-mwan-table';
        } else if (data_program == 'new sites'){
            program_div = '#new-endoresement-new-sites-table';
        } else if (data_program == 'towerco'){
            program_div = '#new-endoresement-towerco-table';
        }

        console.log(program_div);

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
                    $(program_div).DataTable().ajax.reload(function(){
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

    $(".btn-bulk-acceptreject-endorsement").click(function(){
        $("#loaderModal").modal("show");

        var sam_id = $(this).attr('data-sam_id');
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');

        var program_div = "";

        if (data_program == 'coloc'){
            program_div = '#new-endoresement-coloc-table';
        } else if (data_program == 'ffth'){
            program_div = '#new-endoresement-ffth-table';
        } else if (data_program == 'ibs'){
            program_div = '#new-endoresement-ibs-table';
        } else if (data_program == 'mwan'){
            program_div = '#new-endoresement-mwan-table';
        } else if (data_program == 'new sites'){
            program_div = '#new-endoresement-new-sites-table';
        } else if (data_program == 'towerco'){
            program_div = '#new-endoresement-towerco-table';
        }

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
                    $(program_div).DataTable().ajax.reload(function(){
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
    

});