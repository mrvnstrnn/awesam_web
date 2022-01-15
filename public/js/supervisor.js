
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

        var program_id = $('#agent-'+program_lists[0]+'-table').attr('data-program_id');

        $('#agent-'+program_lists[0]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#agent-'+program_lists[0]+'-table').attr('data-href'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    program_id : program_id
                }
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
                { data: "action" },
            ],
        });

        $('#vendor-admin-'+program_lists[0]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#vendor-admin-'+program_lists[0]+'-table').attr('data-href'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    program_id : program_id
                }
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('data-id', data.id);
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

        if ( ! $.fn.DataTable.isDataTable('#vendor-admin-'+$(this).attr("data-program")+'-table') ) {
            var data_program = $(this).attr("data-program");
            $('#vendor-admin-'+data_program+'-table').DataTable({
                processing: true,
                serverSide: true,
                // pageLength: 3,
                ajax: {
                    url: $('#vendor-admin-'+data_program+'-table').attr('data-href'),
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
                ],
            });
        }
    });

    $('.assign-agent-site-table').on('click', 'tr td:not(:first-child)', function (e) {
        e.preventDefault();
        // $(".lgu_check div").remove();
        // $(".province_check div").remove();
        $(".assign-agent-div select#region option").remove();
        $("#user_id").val($(this).parent().attr('data-id'));
        $("#assign-agent-site-btn").attr("data-program", $(this).parent().attr('data-program'));
        $.ajax({
            url: "/get-sam-region",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#assign-agent-site-modal").modal("show");

                    $(".assign-agent-div #region_div div").remove();

                    resp.message.forEach(element => {
                        $(".assign-agent-div #region_div").append(
                            '<div class="col-4">'+
                            '<input name="region[]" class="regionInput" id="region'+element.sam_region_id+'" type="checkbox" class="" value="'+element.sam_region_id+'" >' + 
                            '<label style="margin-left: 20px;" for="region'+element.sam_region_name+'">' + element.sam_region_name+'</label>' +
                            '</div>'
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

    // $("select#region").on("change", function(e){
    //     e.preventDefault();
    //     var val = $(this).val();
    //     var location_type = $(this).attr("data-location-type");
    //     $(".province_check div").remove();
    //     $.ajax({
    //         url: "/get-location/"+val.replace(/ *\[[^)]*\] */g, "")+"/"+location_type,
    //         method: "GET",
    //         success: function(resp){
    //             if(!resp.error){
    //                 $(".province_check").append(
    //                     '<div class="col-4"><input name="province[]" id="provinceAll" type="checkbox" class="provinceInput" value="[all]" ><label style="margin-left: 20px;" for="provinceAll">All </label></div>'
    //                 );
    //                 resp.message.forEach(element => {
    //                     $(".province_check").append(
    //                         '<div class="col-4">'+
    //                             '<input name="province[]" data-location-type="province" class="provinceInput" id="province'+element.province_id+'" type="checkbox" class="" value="['+element.province_name+']'+element.province_id+'" >' + 
    //                             '<label style="margin-left: 20px;" for="province'+element.province_id+'">' + element.province_name+'</label>' +
    //                             '</div>'
    //                     );
    //                 });
    //             } else {
    //                 toastr.error(resp.message, 'Error');
    //             }
    //         },
    //         error: function(resp){
    //             toastr.error(resp.message, 'Error');
    //         }
    //     });
    // });

    // $(document).on("change", ".provinceInput", function(e){
    //     e.preventDefault();

    //     var val = $(this).val();
    //     var checkedProvinces = [];
    //     var location_type = $(this).attr("data-location-type");
    //     $(".lgu_check div").remove();

    //     if(this.checked) {
    //         if(val != "[all]") {
    //             $.each($(".provinceInput:checked"), function(){
    //                 if($(this).val() != "[all]"){
    //                     checkedProvinces.push($(this).val());
    //                 }
    //             });

    //             getLocation(checkedProvinces, location_type);
                
    //         } else {
    //             $('.provinceInput:checkbox').each(function() {
    //                 this.checked = true;                        
    //             });
    //         }
    //     } else {
    //         if($('#provinceAll:checkbox:checked').length < 1){
    //             $('.provinceInput:checkbox').each(function() {
    //                 this.checked = false;                        
    //             });
    //             $(".lgu_check div").remove();
                
    //             $.each($(".provinceInput:checked"), function(){
    //                 if($(this).val() != "[all]"){
    //                     checkedProvinces.push($(this).val());
    //                 }
    //             });

    //             getLocation(checkedProvinces, location_type);
    //         }

    //         if ($('.provinceInput:checkbox').length != $('.provinceInput:checkbox:checked').length){
    //             $('#provinceAll:checkbox').each(function() {
    //                 this.checked = false;                        
    //             });
    //         }
    //     }
    // });

    // function getLocation(checkedProvinces, location_type){
    //     for (let i = 0; i < checkedProvinces.length; i++) {
    //         $.ajax({
    //             url: "/get-location/"+checkedProvinces[i].replace(/ *\[[^)]*\] */g, "")+"/"+location_type,
    //             method: "GET",
    //             success: function(resp){
    //                 if(!resp.error){
    //                     $(".lgu_check").append(
    //                         '<div class="col-4"><input name="lgu[]" id="lguAll" class="lgu" type="checkbox" value="[all]" ><label style="margin-left:20px;" for="lguAll">All</label></div>'
    //                     );
    //                     resp.message.forEach(element => {
    //                         $(".lgu_check").append(
    //                             '<div class="col-4"><input name="lgu[]" class="lgu" id="lgu'+element.lgu_id+'" type="checkbox" class="mr-1" value="['+element.lgu_name+']'+element.lgu_id+'" ><label style="margin-left:20px;" for="lgu'+element.lgu_id+'"> '+element.lgu_name+'</label></div>'
    //                         );
    //                     });

    //                     $(".lgu_check").append(
    //                         '<div class="col-12"><hr></div>'
    //                     );
    //                 } else {
    //                     toastr.error(resp.message, 'Error');
    //                 }
    //             },
    //             error: function(resp){
    //                 toastr.error(resp.message, 'Error');
    //             }
    //         });
    //     }
    // }

    $(document).on('click', "#assign-agent-site-btn", function(e){
        $(this).text("Assigning...");
        $(this).attr("disabled", "disabled");
        var data_program = $(this).attr('data-program');

        $("#assign-agent-site-form small").text("");

        $.ajax({
            url: '/assign-agent-site',
            method: "POST",
            data: $("#assign-agent-site-form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#newagent-"+data_program+"-table").DataTable().ajax.reload(function(){
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
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                    $("#assign-agent-site-btn").text("Assign agent");
                    $("#assign-agent-site-btn").removeAttr("disabled");
                }
            },
            error: function(resp){
                $("#assign-agent-site-btn").text("Assign agent");
                $("#assign-agent-site-btn").removeAttr("disabled");
                toastr.error(resp, 'Error');
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
});