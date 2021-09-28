
$(document).ready(() => {

    var program_lists = [];

    var program_list = JSON.parse($("#program_lists").val());

    for (let i = 0; i < program_list.length; i++) {
        program_lists.push(program_list[i].program.replace(" ", "-").toLowerCase());
    }

    
    /////////////////////////////////////
    //                                 //  
    //     A G E N T S   S I T E S     //
    //                                 //  
    /////////////////////////////////////

    if(program_lists.length >= 1){
        $('#agent-'+program_lists[0]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#agent-'+program_lists[0]+'-table').attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('data-id', data.id);
                if($('#agent-'+program_lists[0]+'-table').attr('data-page') == "new-agent"){
                    $(row).addClass('modalAssigAgentnSite');
                    $(row).attr('data-program', program_lists[0]);
                    $(row).attr('style', "cursor: pointer");
                }
            },
            columnDefs: [{
                "targets": 0,
                "orderable": false
            }],
            columns: [
                { data: "photo" },
                { data: "firstname" },
                { data: "lastname" },
                { data: "email" },
                { data: "areas" },
            ],
        });

        $('#newagent-'+program_lists[0]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#newagent-'+program_lists[0]+'-table').attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('data-id', data.id);
                if($('#newagent-'+program_lists[0]+'-table').attr('data-page') == "new-agent"){
                    $(row).addClass('modalAssigAgentnSite');
                    $(row).attr('data-program', program_lists[0]);
                    $(row).attr('style', "cursor: pointer");
                }
            },
            columnDefs: [{
                "targets": 0,
                "orderable": false
            }],
            columns: [
                { data: "photo" },
                { data: "firstname" },
                { data: "lastname" },
                { data: "email" },
                // { data: "areas" },
            ],
        });
    }

    $(".nav-link.agent").on("click", function(){
        if ( ! $.fn.DataTable.isDataTable('#agent-'+$(this).attr("data-program")+'-table') ) {
            var data_program = $(this).attr("data-program");
            $('#agent-'+data_program+'-table').DataTable({
                processing: true,
                serverSide: true,
                // pageLength: 3,
                ajax: {
                    url: $('#agent-'+data_program+'-table').attr('data-href'),
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                dataSrc: function(json){
                    return json.data;
                },
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id);
                    if($('#agent-'+data_program+'-table').attr('data-page') == "new-agent"){
                        $(row).addClass('modalAssigAgentnSite');
                        $(row).attr('data-program', data_program);
                    }
                    $(row).attr('style', "cursor: pointer");
                },
                columnDefs: [{
                    "targets": 0,
                    "orderable": false
                }],
                columns: [
                    { data: "photo" },
                    { data: "firstname" },
                    { data: "lastname" },
                    { data: "email" },
                    { data: "areas" },
                ],
            });
        }
    });

    $(".nav-link.newagent").on("click", function(){
        if ( ! $.fn.DataTable.isDataTable('#newagent-'+$(this).attr("data-program")+'-table') ) {
            var data_program = $(this).attr("data-program");
            $('#newagent-'+data_program+'-table').DataTable({
                processing: true,
                serverSide: true,
                // pageLength: 3,
                ajax: {
                    url: $('#newagent-'+data_program+'-table').attr('data-href'),
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                dataSrc: function(json){
                    return json.data;
                },
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id);
                    if($('#newagent-'+data_program+'-table').attr('data-page') == "new-agent"){
                        $(row).addClass('modalAssigAgentnSite');
                        $(row).attr('data-program', data_program);
                    }
                    $(row).attr('style', "cursor: pointer");
                },
                columnDefs: [{
                    "targets": 0,
                    "orderable": false
                }],
                columns: [
                    { data: "photo" },
                    { data: "firstname" },
                    { data: "lastname" },
                    { data: "email" },
                    // { data: "areas" },
                ],
            });
        }
    });

    $('.assign-agent-site-table').on('click', 'tr td:not(:first-child)', function (e) {
        e.preventDefault();
        $(".lgu_check div").remove();
        $(".province_check div").remove();
        $(".assign-agent-div select#region option").remove();
        $("#user_id").val($(this).parent().attr('data-id'));
        $("#assign-agent-site-btn").attr("data-program", $(this).parent().attr('data-program'));
        $.ajax({
            url: "/get-region",
            method: "GET",
            success: function(resp){
                if(!resp.error){
                    $("#assign-agent-site-modal").modal("show");
                    $(".assign-agent-div select#region").append(
                        '<option value="">Please select region</option>'
                    );
                    resp.message.forEach(element => {
                        $(".assign-agent-div select#region").append(
                            '<option value="['+ element.region_name +']'+element.region_id+'">' + element.region_name +
                            '</option>'
                        );
                    });
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $("select#region").on("change", function(e){
        e.preventDefault();
        var val = $(this).val();
        var location_type = $(this).attr("data-location-type");
        $(".province_check div").remove();
        $.ajax({
            url: "/get-location/"+val.replace(/ *\[[^)]*\] */g, "")+"/"+location_type,
            method: "GET",
            success: function(resp){
                if(!resp.error){
                    $(".province_check").append(
                        '<div class="col-4"><input name="province[]" id="provinceAll" type="checkbox" class="provinceInput" value="[all]" ><label for="provinceAll"> All</label></div>'
                    );
                    resp.message.forEach(element => {
                        $(".province_check").append(
                            '<div class="col-4"><input name="province[]" data-location-type="province" class="provinceInput" id="province'+element.province_id+'" type="checkbox" class="mr-1" value="['+element.province_name+']'+element.province_id+'" ><label for="province'+element.province_id+'"> '+element.province_name+'</label></div>'
                        );
                    });
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $(document).on("change", ".provinceInput", function(e){
        e.preventDefault();

        var val = $(this).val();
        var checkedProvinces = [];
        var location_type = $(this).attr("data-location-type");
        $(".lgu_check div").remove();

        if(this.checked) {
            if(val != "[all]") {
                $.each($(".provinceInput:checked"), function(){
                    if($(this).val() != "[all]"){
                        checkedProvinces.push($(this).val());
                    }
                });

                getLocation(checkedProvinces, location_type);
                
            } else {
                $('.provinceInput:checkbox').each(function() {
                    this.checked = true;                        
                });
            }
        } else {
            if($('#provinceAll:checkbox:checked').length < 1){
                $('.provinceInput:checkbox').each(function() {
                    this.checked = false;                        
                });
                $(".lgu_check div").remove();
                
                $.each($(".provinceInput:checked"), function(){
                    if($(this).val() != "[all]"){
                        checkedProvinces.push($(this).val());
                    }
                });

                getLocation(checkedProvinces, location_type);
            }

            if ($('.provinceInput:checkbox').length != $('.provinceInput:checkbox:checked').length){
                $('#provinceAll:checkbox').each(function() {
                    this.checked = false;                        
                });
            }
        }
    });

    function getLocation(checkedProvinces, location_type){
        for (let i = 0; i < checkedProvinces.length; i++) {
            $.ajax({
                url: "/get-location/"+checkedProvinces[i].replace(/ *\[[^)]*\] */g, "")+"/"+location_type,
                method: "GET",
                success: function(resp){
                    if(!resp.error){
                        $(".lgu_check").append(
                            '<div class="col-4"><input name="lgu[]" id="lguAll" class="lgu" type="checkbox" value="[all]" ><label for="lguAll"> All</label></div>'
                        );
                        resp.message.forEach(element => {
                            $(".lgu_check").append(
                                '<div class="col-4"><input name="lgu[]" class="lgu" id="lgu'+element.lgu_id+'" type="checkbox" class="mr-1" value="['+element.lgu_name+']'+element.lgu_id+'" ><label for="lgu'+element.lgu_id+'"> '+element.lgu_name+'</label></div>'
                            );
                        });

                        $(".lgu_check").append(
                            '<div class="col-12"><hr></div>'
                        );
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                },
                error: function(resp){
                    toastr.error(resp.message, 'Error');
                }
            });
        }
    }

    $("#assign-agent-site-btn").on('click', function(e){
        $("#assign-agent-site-btn").text("Assigning...");
        $("#assign-agent-site-btn").attr("disabled", "disabled");
        var data_program = $(this).attr('data-program');

        $.ajax({
            url: $(this).attr('data-href'),
            method: "POST",
            data: $("#assign-agent-site-form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#agent-"+data_program+"-table").DataTable().ajax.reload(function(){
                        $(".lgu_check div").remove();
                        $(".province_check div").remove();
                        $(".assign-agent-div select#region option").remove();
                        $("#assign-agent-site-form")[0].reset();
                        $("#assign-agent-site-modal").modal("hide");
                        toastr.success(resp.message, 'Success');
                        $("#assign-agent-site-btn").text("Assign agent");
                        $("#assign-agent-site-btn").removeAttr("disabled");
                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                        $("#assign-agent-site-btn").text("Assign agent");
                        $("#assign-agent-site-btn").removeAttr("disabled");
                    } else {
                        toastr.error(resp.message, 'Error');
                        $("#assign-agent-site-btn").text("Assign agent");
                        $("#assign-agent-site-btn").removeAttr("disabled");
                    }
                }
            },
            error: function(resp){
                $("#assign-agent-site-btn").text("Assign agent");
                $("#assign-agent-site-btn").removeAttr("disabled");
                toastr.error(resp.message, 'Error');
            }
        });
    });

    /////////////////////////////////////
    //                                 //  
    // U N A S S I G N E D   S I T E S //
    //                                 //  
    /////////////////////////////////////


    if(program_lists.length >= 1){
        $('#unasigned-'+program_lists[0]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#unasigned-'+program_lists[0]+'-table').attr('data-href'),
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
                $(row).attr('data-id', data.sam_id);
                $(row).addClass('modalDataUnassigned'+data.sam_id);
                $(row).addClass('modalDataEndorsement');
                $(row).attr('data-site_name', data.sitename);
                $(row).attr('data-program_id', data.program_id);
                $(row).attr('data-site_vendor_id', data.site_vendor_id);
            },
            columnDefs: [{
                "targets": 0,
                "orderable": false
            }],
            columns: [
                { data: "photo" },
                { data: "site_endorsement_date" },
                { data: "sam_id" },
                { data: "site_name" },
                { data: "technology" },
                // { data: "pla_id" }
            ],
        });
    }

    $(".nav-link.unasigned").on("click", function(){
        if ( ! $.fn.DataTable.isDataTable('#unasigned-'+$(this).attr("data-program")+'-table') ) {
            var data_program = $(this).attr("data-program");
            $('#unasigned-'+data_program+'-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: $('#unasigned-'+data_program+'-table').attr('data-href'),
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
                    $(row).attr('data-program', data_program);
                    $(row).addClass('modalDataEndorsement');
                    $(row).attr('data-id', data.sam_id);
                    $(row).attr('data-program_id', data.program_id);
                    $(row).attr('data-site_name', data.sitename);
                    $(row).attr('data-program_id', data.program_id);
                    $(row).attr('data-site_vendor_id', data.site_vendor_id);
                },
                columnDefs: [{
                    "targets": 0,
                    "orderable": false
                }],
                columns: [
                    { data: "photo" },
                    { data: "site_endorsement_date" },
                    { data: "sam_id" },
                    { data: "site_name" },
                    { data: "technology" },
                ],
            });
        }
    });

    $('.unasigned-table').on( 'click', 'tr td:first-child', function (e) {
        e.preventDefault();

        if ($(this).attr("colspan") != 5) {
            $("#btn-assign-sites").attr('data-id', $(this).parent().attr('data-id'));
            $("#btn-assign-sites").attr('data-site_vendor_id', $(this).parent().attr('data-site_vendor_id'));
            $("#btn-assign-sites").attr('data-program', $(this).parent().attr('data-program'));
            $("#sam_id").val($(this).parent().attr('data-sam_id'));
            $("#btn-assign-sites").attr("data-site_name", $(this).parent().attr('data-site_name'));
            $("#btn-assign-sites").attr("data-program_id", $(this).parent().attr('data-program_id'));

            $("#modal-assign-sites select#agent_id option").remove();
            $.ajax({
                url: "/get-agent-based-program/"+ $(this).parent().attr('data-program_id'),
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        console.log(resp.message);
                        resp.message.forEach(element => {
                            $("#modal-assign-sites select#agent_id").append(
                                '<option value="'+element.id+'">'+element.name+'</option>'
                            );
                        });

                        $("#modal-assign-sites").modal("show");
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                },
                error: function (resp) {
                    toastr.error(resp.message, 'Error');
                }
            });
        }
    });

    $(document).on('click',"#btn-assign-sites", function(e){
        e.preventDefault();

        $(this).attr('disabled', 'disabled');
        $(this).text('Processing...');
        var sam_id = $("#sam_id").val();
        var agent_id = $("#agent_id").val();

        var data_program = $(this).attr('data-program');
        var site_name = $(this).attr('data-site_name');
        var activity_name = $(this).attr('data-activity_name');
        var site_vendor_id = $(this).attr('data-site_vendor_id');

        $.ajax({
            url: $(this).attr('data-href'),
            data: {
                sam_id : sam_id,
                agent_id : agent_id,
                site_name : site_name,
                activity_name : activity_name,
                site_vendor_id : site_vendor_id,
                data_program : data_program
            },
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
    
    $(".nav-link.new-endoresement").on("click", function(){
        if ( ! $.fn.DataTable.isDataTable('#new-endoresement-'+$(this).attr("data-program")+'-table') ) {
            var data_program = $(this).attr("data-program");
            $('#new-endoresement-'+data_program+'-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: $('#new-endoresement-'+data_program+'-table').attr('data-href'),
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
                    $(row).attr('data-program', data_program);
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
            // if(allowed_keys.includes(new_json[i].field_name.toUpperCase())){
                $(".content-data").append(
                    '<div class="position-relative form-group col-md-6">' +
                        '<label for="' + new_json[i].field_name.toLowerCase() + '" style="font-size: 11px;">' +  new_json[i].field_name + '</label>' +
                        '<input class="form-control"  value="'+new_json[i].value+'" name="' + new_json[i].field_name.toLowerCase() + '"  id="'+new_json[i].field_name.toLowerCase()+'" >' +
                    '</div>'
                );
            // }
        }

        $(".modal-title").text(json_parse.site_name);
        $(".btn-accept-endorsement").attr('data-sam_id', json_parse.sam_id);
        $(".btn-accept-endorsement").attr('data-site_vendor_id', json_parse.site_vendor_id);
        $("#modal-endorsement").modal("show");
    } );

    $(document).on("click", ".checkAll", function(e){
        e.preventDefault();
        var val = $(this).val();
        var atLeastOneIsChecked = $('input[name='+val+']:checkbox:checked').length > 0;
        
        if (!atLeastOneIsChecked) {
            $('input[name='+val+']').not(this).prop('checked', this.checked);
        } else {
            $('input[name='+val+']').not(this).prop('checked', false);
        }
    });

    $(".btn-accept-endorsement").click(function(e){
        e.preventDefault();
        // $("#loaderModal").modal("show");

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');
        var activity_name = $(this).attr('data-activity_name');
        var site_vendor_id = [$(this).attr('data-site_vendor_id')];

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: $(this).attr('data-href'),
            data: {
                sam_id : sam_id,
                data_complete : data_complete,
                activity_name : activity_name,
                site_vendor_id : site_vendor_id,
                data_program : data_program,
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
                        $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                        $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Accept Endorsement");
                    });
                } else {
                    // $("#loaderModal").modal("hide");
                    toastr.error(resp.message, 'Error');
                    $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                    $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Accept Endorsement");
                }
            },
            error: function(resp){
                // $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
                $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Accept Endorsement");
            }
        });

    });

    $(".btn-bulk-acceptreject-endorsement").click(function(e){
        e.preventDefault();
        // $("#loaderModal").modal("show");

        var sam_id = $(this).attr('data-sam_id');
        var data_complete = $(this).attr('data-complete');
        var data_program = $(this).attr('data-program');
        var activity_name = $(this).attr('data-activity_name');

        var data_id = $(this).attr('data-id');
        var inputElements = document.getElementsByName('program'+data_id);

        var id = $(this).attr('id');

        var text = id == "reject"+data_program.replace(" ", "-") ? "Reject" : "Endorse New Sites";

        $("#"+id).attr("disabled", "disabled");
        $("#"+id).text("Processing...");

        sam_id = [];
        site_vendor_id = [];
        for(var i=0; inputElements[i]; ++i){
            if(inputElements[i].checked){
                sam_id.push(inputElements[i].value);
                site_vendor_id.push(inputElements[i].attributes[5].value);
            }
        }

        $.ajax({
            url: $(this).attr('data-href'),
            data: {
                sam_id : sam_id,
                data_complete : data_complete,
                activity_name : activity_name,
                data_program : data_program,
                site_vendor_id : site_vendor_id,
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

    /////////////////////////////////////
    //                                 //  
    //           E N D   O F           //  
    // N E W   E N D O R S E M E N T S //
    //                                 //  
    /////////////////////////////////////
    
});