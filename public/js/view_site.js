Dropzone.autoDiscover = false;
$(".dropzone").dropzone({
    addRemoveLinks: true,
    maxFiles: 1,
    maxFilesize: 5,
    paramName: "file",
    url: "/upload-file",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (file, resp) {
        $("#form-upload  #file_name").val(resp.file);
        console.log(resp.message);
    },
    error: function (file, response) {
        toastr.error(resp.message, "Error");
    }
});


$(document).ready(() => {

    // subactivity_switch

    $('.subactivity_switch').on( 'click', function (e) {

        var show_what = "#subactivity_" + $(this).attr("data-activity_id");
        $(".subactivity").addClass("d-none");
        $('.subactivity_action_list').removeClass('d-none');
        $('.subactivity_action').addClass('d-none');


        $(show_what).removeClass("d-none");


    });


    // $('.subactivity_action_switch').on( 'click', function (e) {
    //     $('.subactivity_action_list').addClass('d-none');
    //     $('.subactivity_action').removeClass('d-none');

    // });

    $('#btn_add_issue_cancel').on( 'click', function (e) {
        $('.add_issue_form').addClass('d-none');
        $('#btn_add_issue_switch').removeClass('d-none');
    });

    $('#btn_add_issue_switch').on( 'click', function (e) {
        $('.add_issue_form').removeClass('d-none');
        $(this).addClass('d-none');
    });

    $("#issue_type").on("change", function (){
        // $(this).val();
        if($(this).val() != ""){
            $("select[name=issue] option").remove();
            $.ajax({
                url: "/get-issue/"+$(this).val(),
                method: "GET",
                success: function (resp){
                    if(!resp.error){
                        console.log(resp.message);
    
                        resp.message.forEach(element => {
                            $("select[name=issue]").append(
                                '<option value="'+element.issue_type_id+'">'+element.issue+'</option>'
                            );
                        });
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });
        }
    });


    $(".add_issue").on("click", function (){
        $.ajax({
            url: "/add-issue",
            method: "POST",
            data: $(".add_issue_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if(!resp.error){
                    $('.my_table_issue').DataTable().ajax.reload(function(){
                        $(".add_issue_form")[0].reset();
                        $('#btn_add_issue_cancel').trigger("click");
                        toastr.success(resp.message, "Success");
                    });
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (resp){
                toastr.error(resp.message, "Error");
            }
        });
    });

    $('.my_table_issue').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('.my_table_issue').attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        columns: [
            { data: "date_created" },
            { data: "issue" },
            { data: "issue_details" },
            { data: "issue_status" },
        ],
    });

    $('.my_table_issue').on("click", "tr td", function(){
        if($(this).attr("colspan") != 4){
            $("#modal_issue").modal("show");
        }
    });
    

    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function daysToMilliseconds(days) {
        return days * 24 * 60 * 60 * 1000;
    }

    function drawChart() {

        var data = new google.visualization.DataTable();
        
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('string', 'Resource');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        var timeline = $('#timeline').val();
        var obj = jQuery.parseJSON(timeline);

        var times =[];
        var chain = null;

        $.each(obj, function(key,value) {
            whattopush = [
                value.stage_name, 
                value.stage_name, 
                value.stage_name,
                new Date(value.start_date), 
                new Date(value.end_date), 
                null,
                100,  
                chain
            ];

            chain = value.stage_name    
            times.push(whattopush);
        });    

        data.addRows(times);
        var options = {
            height: 415,
            gantt: {
            }
        };

        var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

        chart.draw(data, options);
    }

    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {

        var container = document.getElementById('example4.2');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();
    
        dataTable.addColumn({ type: 'string', id: 'Role' });
        dataTable.addColumn({ type: 'string', id: 'Name' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });

        var timeline = $('#timeline').val();
        var obj = jQuery.parseJSON(timeline);

        var times =[];

        $.each(obj, function(key,value) {
            whattopush = [
                'Timeline',
                value.stage_name, 
                new Date(value.start_date), 
                new Date(value.end_date)
            ];
            times.push(whattopush);
        });    

        dataTable.addRows(times);
    
        var options = {
            timeline: { groupByRowLabel: true, showRowLabels: true }
        };
    
        chart.draw(dataTable, options);

    }

    

});
