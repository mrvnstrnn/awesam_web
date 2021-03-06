$('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
    e.preventDefault();


    loader = "<img src='/images/awesam_loader.png' width='200px;' alt-text='Loading...'/>";
    $.blockUI({ message: loader, css:{backgroundColor: "transparent", border: '0px;'} });

    $(".ajax_content_box").attr("data-what_table", $(this).attr('data-what_table'));

    if($(this).find("td").hasClass('dataTables_empty') == false){

        if (typeof $(this).attr('data-sam_id') !== 'undefined') {

            var sam_id = $(this).attr('data-sam_id');
            var activity = $(this).attr('data-activity');
            var main_activity = $(this).attr('data-main_activity');
            var site = $(this).attr("data-site");
            var activity_source = $(this).parent().parent().attr("data-type");
            
            var program_id =  $("#"+$(this).attr('data-what_table')).attr("data-program_id");

            $("#viewInfoModal .modal-title").text($(this).attr("data-site") + " : " + activity);

            $.ajax({
                // url: "/get-all-docs",
                url: "/get-component",
                method: "POST",
                // data: {
                //     site : site,
                //     activity : activity,
                //     main_activity : main_activity,
                //     mode : table_to_load,
                //     sam_id : sam_id,
                //     program_id : program_id,
                // },
                data: {
                    site : site,
                    // mode : table_to_load,
                    sam_id : sam_id,
                    activity_source : activity_source,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    },
        
                success: function (resp){
                    $('.ajax_content_box').html("");
                    $('.ajax_content_box').html(resp);

                    $.unblockUI();
                    $('#viewInfoModal').modal('show');

                },
                complete: function(){
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            })
            .done(function(){
                $('.file_list_item').first().click();
            });

        }

        else {


            // var activity = $(this).attr('data-activity');
            var generated_pr_memo = $(this).attr('data-generated_pr_memo');
            // var program_id =  $("#"+$(this).attr('data-what_table')).attr("data-program_id");

            $("#viewInfoModal .modal-title").text($(this).attr("data-site") + " : " + activity);

                $.ajax({
                    url: "/get-pr-memo",
                    method: "POST",
                    data: {
                        generated_pr_memo : generated_pr_memo,
                        // activity : activity,
                        // program_id : program_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        },
            
                    success: function (resp){
                        $('.ajax_content_box').html("");   
                        $('.ajax_content_box').html(resp);

                        $.unblockUI();
                        $('#viewInfoModal').modal('show');


                    },
                    complete: function(){

                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
                });

        }
    } 
});


$('.show_activity_modal').on( 'click', function (e) {

    e.preventDefault();

    var sam_id = $(this).attr('data-sam_id');
    var activity = $(this).attr('data-activity')
    var activity_id = $(this).attr('data-activity_id')
    var site = $(this).attr("data-site");
    var main_activity = main_activity;
    var activity_source = $(this).attr('data-activity_source');

    loader = "<img src='/images/awesam_loader.png' width='200px;' alt-text='Loading...'/>";
    $.blockUI({ message: loader, css:{backgroundColor: "transparent", border: '0px;'} });

    $(".ajax_content_box").attr("data-sam_id", $(this).attr('data-sam_id'));
    $(".ajax_content_box").attr("data-activity", $(this).attr('data-activity'));

    $.ajax({
        url: "/get-component",
        method: "POST",
        data: {
            sam_id : sam_id,
            activity_source : activity_source,
        },

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            },

        success: function (resp){
            $('.ajax_content_box').html("");   
            $('.ajax_content_box').html(resp);   

            $.unblockUI();
            $('#viewInfoModal').modal('show');


        },
        complete: function(){
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });



});


$(".agent_engagement .show_action_modal, tr.show_action_modal").on('click', function(e){
// $(document).on('click', '.show_action_modal', function(e){
    e.preventDefault();

    loader = "<img src='/images/awesam_loader.png' width='200px;' alt-text='Loading...'/>";
    $.blockUI({ message: loader, css:{backgroundColor: "transparent", border: '0px;'} });

    // $(".ajax_content_box").attr("data-sam_id", $(this).attr('data-sam_id'));
    // $(".ajax_content_box").attr("data-activity", $(this).attr('data-activity'));

    var activity_source = $(this).attr('data-activity_source');
    var json = $(this).attr('data-json');

    $.ajax({
        url: "/get-component",
        method: "POST",
        data: {
            // sam_id : sam_id,
            activity_source : activity_source,
            json : json,
            direct_mode : true,
        },

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            },

        success: function (resp){
            $('.ajax_content_box').html("");   
            $('.ajax_content_box').html(resp);   

            $.unblockUI();
            $('#viewInfoModal').modal('show');


        },
        complete: function(){
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });


});