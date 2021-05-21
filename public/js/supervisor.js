
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
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('data-id', data.id);
                if($('#agent-'+program_lists[i]+'-table').attr('data-page') == "new-agent"){
                    $(row).addClass('modalAssigAgentnSite');
                    $(row).attr('data-program', program_lists[i]);
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
    }

    $('.assign-agent-site-table').on('click', 'tr', function (e) {
        e.preventDefault();
        $(".assign-agent-div select#region option").remove();
        $("#user_id").val($(this).attr('data-id'));
        $("#assign-agent-site-btn").attr("data-program", $(this).attr('data-program'));
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

        // if ($(this).not(':checked')) {
            
        // if($(".provinceInput").length != $(".provinceInput:checked").length){
        //     $('#provinceAll:checkbox').each(function() {
        //         this.checked = false;                        
        //     });
        // }

        if(this.checked) {
            if(val != "[all]") {
                $.each($(".provinceInput:checked"), function(){
                    if($(this).val() != "[all]"){
                        checkedProvinces.push($(this).val());
                    }
                });
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
            } else {
                $('.provinceInput:checkbox').each(function() {
                    this.checked = true;                        
                });
            }
        }
    });

    $("#assign-agent-site-btn").on('click', function(e){
        var data_program = $(this).attr('data-program')
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
                        $("#assign-agent-site-form")[0].reset();
                        $("#assign-agent-site-modal").modal("hide");
                        toastr.success(resp.message, 'Success');
                    });
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