$(document).ready(() => {
    $('#for-verification-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#for-verification-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function(row, data) {

            var suffix = data.suffix == null ? "" : data.suffix;
            $(row).attr('data-user_id', data.user_id);
            $(row).attr('data-profile_id', data.designation);
            $(row).attr("data-info", JSON.stringify(data));
            $(row).attr('data-employeename', data.firstname + " " + data.lastname + " " + suffix);
            $(row).addClass('modalSetProfile');
        },
        columns: [
            { data: "user_id" },
            { data: "profile" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
        ],
    });


    $('#employee-agents-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $('#employee-agents-table').attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function(row, data) {
        },
        columns: [
            { data: "user_id" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
        ],
    });


    $('#for-verification-table tbody').on('click', 'tr', function () {
                
        // var data = $( this ).attr("data-chapter_id");


        $(".btn-assign-profile").attr('data-user_id', $( this ).attr("data-user_id"));
        $(".btn-assign-profile").attr('data-profile_id', $( this ).attr("data-profile_id"));

        var data = JSON.parse($( this ).attr("data-info"));

        // console.log(data);

        $("#modal-employee-verification").modal("show");

        $("#fullname").val(data.firstname+" "+data.lastname);
        $('#designation').val(data.designation).trigger('change');
        $('#employment_classification').val(data.employment_classification).trigger('change');
        $('#employment_status').val(data.employment_status).trigger('change');
        $('#hiring_date').val(data.hiring_date);

        if($( this ).attr("data-profile_id") == 2){
            $(".supervisor_area").removeClass('d-none');
            $(".agent_area").removeClass('d-none');

            $('.supervisor-data select option').remove();
            $.ajax({
                url: '/get-supervisor',
                method: "GET",
                success: function (resp) {
                    if(!resp.error){
                        $('.supervisor-data').removeClass("d-none");
                        resp.message.forEach(element => {
                            $('.supervisor_select select').append("<option value="+element.id+">"+element.email+"</option>");
                        });
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp) {
                    toastr.error(resp.message, "Error");
                }
            });
        } else {
            $(".supervisor_area").addClass('d-none');
            $(".agent_area").addClass('d-none');
        }
        // window.location.href = "/chapters/"+data;
    } );

    $(document).on( 'click', '.btn-assign-profile', function (e) {
        e.preventDefault();

        var user_id = $(this).attr('data-user_id');
        var profile_id = $(this).attr('data-profile_id');

        var mysupervisor = $("#mysupervisor").val();
        
        var inputElements = document.getElementsByName('vendor_program_id');

        checkbox_id = [];
        for(var i=0; inputElements[i]; ++i){
            if(inputElements[i].checked){
                checkbox_id.push(inputElements[i].value);
            }
        }

        $.ajax({
            url: '/assign-profile',
            method: "POST",
            data: {
                user_id : user_id,
                profile_id : profile_id,
                checkbox_id : checkbox_id,
                mysupervisor : mysupervisor,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if(!resp.error){
                    $('#for-verification-table').DataTable().ajax.reload(function(){
                        toastr.success(resp.message, "Success");
                        $("#modal-employee-verification").modal("hide");
                    });
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (resp) {
                toastr.error(resp.message, "Error");
            }
        });
    });

});