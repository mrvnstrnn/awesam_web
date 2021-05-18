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
